<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'foto',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role() {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

    public function consultantReservations() {
        return $this->hasMany(Reservation::class, 'consultant_id');
    }
    // Badge class for the role
    public function getRolBadgeClassAttribute() {
        $roleName = strtolower(trim($this->role->name ?? ''));
        return match ($roleName) {
            'administrador' => 'badge bg-dark',
            'asesor' => 'badge bg-success',
            'usuario' => 'badge bg-primary',
            default => 'badge bg-danger',
        };
    }
}
