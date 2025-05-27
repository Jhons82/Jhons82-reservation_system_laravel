<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index() {
        $reservations = Reservation::with(['user', 'consultant'])->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create() {
        $users = User::where('rol_id', 3)->whereNull('deleted_at')->get();
        $consultants = User::where('rol_id', 2)->whereNull('deleted_at')->get();

        return view('reservations.create', compact('users', 'consultants'));
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

}