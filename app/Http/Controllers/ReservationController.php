<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservationDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\View;
use Twilio\Rest\Client;

class ReservationController extends Controller
{
    //Index -Admin
    public function index() {
        $reservations = Reservation::with(['user', 'consultant'])->get();
        return view('reservations.index', compact('reservations'));
    }
    //Index - Client
    public function indexClient() {
        $customerId = Auth::user()->id;
        $reservations = Reservation::where('user_id', $customerId)->get();
        return view('client.index', compact('reservations'));
    }
    //Create - Admin
    public function create() {
        $users = User::where('rol_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('rol_id', 2)->whereNull('deleted_at')->get();

        return view('reservations.create', compact('users', 'consultants'));
    }
    //Create - Client
    public function createClient() {
        $users = User::where('rol_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('rol_id', 2)->whereNull('deleted_at')->get();

        return view('client.create', compact('users', 'consultants'));
    }

    public function store(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'consultant_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i|after_or_equal:09:00|before_or_equal:16:00',
            'end_time' => 'required|date_format:H:i|before_or_equal:17:00',
            'reservation_status' => 'required|in:pendiente,confirmada,cancelada',
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pendiente,pagado,fallido',
        ]);

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'consultant_id' => $request->consultant_id,
            'reservation_date' => $request->reservation_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reservation_status' => $request->reservation_status,
            'total_amount' => $request->total_amount,
            'payment_status' => $request->payment_status,
        ]);

        $this->sendConfirmationEmail($reservation);

        $user=User::find($request->user_id);
        $userPhone = $user->telefono;
        if ($userPhone) {
            $this->sendWhatsAppMessage($userPhone, $this->generateWhatsAppMessage($reservation, $user));
        }

        return redirect()->route('reservations.index')->with('success', 'Reservación creada con éxito');
    }

    public function edit(string $id) {
        $reservation = Reservation::findOrFail($id);
        $reservation->start_time = Carbon::parse($reservation->start_time)->format('H:i');
        $reservation->end_time = Carbon::parse($reservation->end_time)->format('H:i');

        $users = User::where('rol_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('rol_id', 2)->whereNull('deleted_at')->get();

        return view('reservations.edit', compact('reservation', 'users', 'consultants'));
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'consultant_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i|after_or_equal:09:00|before_or_equal:16:00',
            'end_time' => 'required|date_format:H:i|before_or_equal:17:00',
            'reservation_status' => 'required|in:pendiente,confirmada,cancelada',
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pendiente,pagado,fallido',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'user_id' => $request->user_id,
            'consultant_id' => $request->consultant_id,
            'reservation_date' => $request->reservation_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reservation_status' => $request->reservation_status,
            'total_amount' => $request->total_amount,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservación actualizada con éxito');
    }

    public function cancel(Request $request) {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'cancellation_reason' => 'required|string|max:255',
        ]);

        $reservation = Reservation::findOrFail($request->reservation_id);
        $reservation->reservation_status = 'cancelada';
        $reservation->cancellation_reason = $request->cancellation_reason;
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Reservación cancelada con éxito'
        ]);
    }
    //Información en JSON para Calendar - Rol: Administrador
    public function getAllReservations() {
        // Cargar solo las relaciones y campos necesarios
        $reservations = Reservation::with([
            'user:id,nombres,apellidos',
            'consultant:id,nombres,apellidos',
        ])->get([
            'id',
            'user_id',
            'consultant_id',
            'reservation_date',
            'start_time',
            'end_time',
            'reservation_status',
            'payment_status',
            'total_amount',
            'cancellation_reason',
        ]);

        $events = $reservations->map(function ($reservation) {
            $startTimeFormatted = Carbon::parse($reservation->start_time)->format('g:i A');
            $endTimeFormatted = Carbon::parse($reservation->end_time)->format('g:i A');

            $statusColor = match ($reservation->reservation_status) {
                'Confirmada' => ['#cfe2ff', '#084298'],
                'Pendiente'  => ['#d1ecf1', '#0c5460'],
                default      => ['#f8d7da', '#842029'],
            };

            return [
                'id' => $reservation->id,
                'title' => "Reservación de {$reservation->user->nombres} {$reservation->user->apellidos} - Consultor: {$reservation->consultant->nombres} {$reservation->consultant->apellidos}",
                'start' => $reservation->reservation_date,
                'time_range' => "{$startTimeFormatted} - {$endTimeFormatted}",
                'color' => $statusColor[0],
                'textColor' => $statusColor[1],
                'description' => "Reservación de {$reservation->user->nombres} {$reservation->user->apellidos} con Consultor: {$reservation->consultant->nombres} {$reservation->consultant->apellidos}",
                'reservation_status' => $reservation->reservation_status,
                'payment_status' => $reservation->payment_status,
                'total_amount' => $reservation->total_amount,
                'cancellation_reason' => $reservation->cancellation_reason,
                'badge_class' => $reservation->reservation_badge_class,
                'payment_badge_class' => $reservation->payment_badge_class,
            ];
        });

        return response()->json($events);
    }
    //Información en JSON para Calendar - Rol: Asesor
    public function getAllReservationsAdviser() {

        $consultantId = Auth::user()->id;
        $reservations = Reservation::where('consultant_id', $consultantId)->get();

        $events = $reservations->map(function ($reservation) {
            $startTimeFormatted = Carbon::parse($reservation->start_time)->format('g:i A');
            $endTimeFormatted = Carbon::parse($reservation->end_time)->format('g:i A');

            $statusColor = match ($reservation->reservation_status) {
                'Confirmada' => ['#cfe2ff', '#084298'],
                'Pendiente'  => ['#d1ecf1', '#0c5460'],
                default      => ['#f8d7da', '#842029'],
            };

            return [
                'id' => $reservation->id,
                'start' => $reservation->reservation_date,
                'time_range' => "{$startTimeFormatted} - {$endTimeFormatted}",
                'color' => $statusColor[0],
                'textColor' => $statusColor[1],
                'title' => "Reservación con el Cliente:  {$reservation->user->nombres} {$reservation->user->apellidos}",
                'reservation_status' => $reservation->reservation_status,
                'payment_status' => $reservation->payment_status,
                'total_amount' => $reservation->total_amount,
                'cancellation_reason' => $reservation->cancellation_reason,
                'badge_class' => $reservation->reservation_badge_class,
                'payment_badge_class' => $reservation->payment_badge_class,
            ];
        });

        return response()->json($events);
    }

    //Información en JSON para Calendar - Rol: Cliente
    public function getAllReservationsClient() {

        $userId = Auth::user()->id;
        $reservations = Reservation::where('user_id', $userId)->get();

        $events = $reservations->map(function ($reservation) {
            $startTimeFormatted = Carbon::parse($reservation->start_time)->format('g:i A');
            $endTimeFormatted = Carbon::parse($reservation->end_time)->format('g:i A');

            $statusColor = match ($reservation->reservation_status) {
                'Confirmada' => ['#cfe2ff', '#084298'],
                'Pendiente'  => ['#d1ecf1', '#0c5460'],
                default      => ['#f8d7da', '#842029'],
            };

            return [
                'id' => $reservation->id,
                'start' => $reservation->reservation_date,
                'time_range' => "{$startTimeFormatted} - {$endTimeFormatted}",
                'color' => $statusColor[0],
                'textColor' => $statusColor[1],
                'title' => "Reservación con el Asesor:  {$reservation->consultant->nombres} {$reservation->consultant->apellidos}",
                'reservation_status' => $reservation->reservation_status,
                'payment_status' => $reservation->payment_status,
                'total_amount' => $reservation->total_amount,
                'cancellation_reason' => $reservation->cancellation_reason,
                'badge_class' => $reservation->reservation_badge_class,
                'payment_badge_class' => $reservation->payment_badge_class,
            ];
        });

        return response()->json($events);
    }

    public function completePayment(Request $request) {
        $request->validate([
            'orderID' => 'required',
            'details' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'consultant_id' => 'required|exists:users,id',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i|after_or_equal:09:00|before_or_equal:16:00',
            'end_time' => 'required|date_format:H:i|before_or_equal:17:00',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $details = $request->details;
        $payment_status = $details['status'] ?? null;

        if ($payment_status === 'COMPLETED') {
            DB::beginTransaction();
            try {
                $reservation = Reservation::create([
                    'user_id' =>$request->user_id,
                    'consultant_id' => $request->consultant_id,
                    'reservation_date' => $request->reservation_date,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'reservation_status' => 'Confirmada',
                    'payment_status' => 'Pagado',
                    'total_amount' => $request->total_amount,
                ]);

                $transaction_id = $details['id'] ?? null;
                $payer_id = $details['payer']['payer_id'] ?? null;
                $payer_email = $details['payer']['email_address'] ?? null;
                $amount = isset($details['purchase_units'][0]['amount']['value']) ? floatval($details['purchase_units'][0]['amount']['value']) : null;

                ReservationDetail::create([
                    'reservation_id' => $reservation->id,
                    'transaction_id' => $transaction_id,
                    'payer_id' =>  $payer_id,
                    'payer_email' => $payer_email,
                    'payment_status' => $payment_status,
                    'amount' => $amount,
                    'response_json' => json_encode($details),
                ]);
                DB::commit();
                $this->sendConfirmationEmail($reservation);

                $user=User::find($request->user_id);
                $userPhone = $user->telefono;
                if ($userPhone) {
                    $this->sendWhatsAppMessage($userPhone, $this->generateWhatsAppMessage($reservation, $user));
                }
                return response()->json(['success' => true, 'reservation_id' => $reservation->id]);
            } catch (\Exception $e) {
                DB::rollBack();
                /* \Log::error('Error en completePayment: ' . $e->getMessage()); */
                return response()->json([
                    'error' =>'Error al procesar el pago o guardar la reservación',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }else {
            return response()->json(['error' => 'Pago no completado'], 400);
        }
    }

    //Envio de Alertas
    public function sendConfirmationEmail($reservation) {
        $user = User::find($reservation->user_id);
        $consultant = User::find($reservation->consultant_id);

        //Validación de User y Consultant
        if (!$user || !$consultant) {
            Log::error('Usuario o Asesor no encontrado');
            return back()->with('error', 'Error al encontrar los datos de usuario o asesor.');
        }

        $mail = new PHPMailer(true);

        try {
            //Configurar SMTP en PHPMailer
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; //smtp.office365.com -> Outlook / Hotmail / Office365
            $mail->Port = 587;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME'); //'tu_email@outlook.com' -> Outlook / Hotmail / Office365
            $mail->Password = env('MAIL_PASSWORD'); //tucontraseña / contraseña de Aplicación / getenv('GMAIL_APP_PASSWORD')

            //Enviar correo a Usuario
            $mail->setFrom('jhon969392668@gmail.com', 'J-GOD Reservaciones');
            $mail->addAddress($user->email);

            //Configuración del Correo
            $mail->CharSet = 'UTF-8';
            //Asunto del Correo
            $mail->Subject = 'Confirmación de Reservación - J-GOD';
            //Template
            $html = View::make('emails.reservation', [
                'userName' => $user->nombres . ' ' .$user->apellidos,
                'consultantName' => $consultant->nombres . ' ' . $consultant->apellidos,
                'reservationDate' => $reservation->reservation_date,
                'startTime' => $reservation->start_time,
                'endTime' => $reservation->end_time,
                'reservationStatus' => $reservation->reservation_status,
                'paymentStatus' => $reservation->payment_status,
                'totalAmount' => $reservation->total_amount,
            ])->render();

            //Configurar de correo para soporte de html
            $mail->isHTML(true);
            $mail->Body = $html;

            //Enviar Correo
            $mail->send();
        } catch(Exception $e) {
            Log::error('Error en envío de correo: ' .$e->getMessage());
            return back()->with('error','No se pudo enviar el correo: ' .$e->getMessage());
        }
    }
    //Generar Mensaje de WhatsApp
    protected function generateWhatsAppMessage($reservation, $user) {
        return "Hola {$user->nombres}"." "."{$user->apellidos}, tu reservación ha sido confirmada.\n".
            "Fecha de Reservación: {$reservation->reservation_date}\n".
            "Hora de Inicio: {$reservation->start_time}\n".
            "Hora de Fin: {$reservation->end_time}\n".
            "Estado de Reservación: {$reservation->reservation_status}\n".
            "Costo de Pago:{$reservation->total_amount} USD\n".
            "Gracias por elegir nuestros servicios.\n".
            "J-GOD.\n";
    }
    //Enviar Mensaje de WhatsApp
    protected function sendWhatsAppMessage($to, $message) {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $token);

        $twilio->messages->create(
            "whatsapp:+{$to}",
            [
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'body' => $message,
            ]
        );
    }
    // Pagos de clientes - Admin
    public function showPayments() {
        $payments = ReservationDetail::with(['reservation.user', 'reservation.consultant'])->get();
        return view('reservations.payments', compact('payments'));
    }
    // Pagos unicos del Cliente
    public function showClientPayments() {
        $userId = Auth::id();
        $payments = ReservationDetail::whereHas('reservation', function($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        return view('client.payments', compact('payments'));
    }
}