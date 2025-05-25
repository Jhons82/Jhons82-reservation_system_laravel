<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;

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
}
