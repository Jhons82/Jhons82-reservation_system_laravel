<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'consultant_id',
        'reservation_date',
        'start_time',
        'end_time',
        'reservation_status',
        'total_amount',
        'payment_status',
        'cancellation_reason',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function consultant() {
        return $this->belongsTo(User::class, 'consultant_id');
    }

}
