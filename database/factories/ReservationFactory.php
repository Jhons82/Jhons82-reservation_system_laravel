<?php

namespace Database\Factories;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Reservation::class;

    public function definition(): array
    {
        $usersId = User::where('rol_id', 3)->pluck('id')->toArray();
        $consultantsId = User::where('rol_id', 2)->pluck('id')->toArray();
        $reservationDate = $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d');
        $startTime = $this->faker->numberBetween(9, 15);
        $endTime = $startTime + 1;
        return [
            'user_id' => $this->faker->randomElement($usersId),
            'consultant_id' => $this->faker->randomElement($consultantsId),
            'reservation_date' => $reservationDate,
            'start_time' => sprintf('%02d:00:00', $startTime),
            'end_time' => sprintf('%02d:00:00', $endTime),
            'reservation_status' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada']),
            'total_amount' => $this->faker->randomFloat(2, 50, 1000), // 2 decimales, entre 50 y 1000
            'payment_status'=> $this->faker->randomElement(['pendiente', 'pagado', 'fallido'])
        ];
    }
}
