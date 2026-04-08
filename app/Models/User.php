<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    const ROL_APRENDIZ = 1;

    const ROL_INSTRUCTOR = 2;

    const ROL_EMPRESA = 3;

    const ROL_ADMIN = 4;

    protected $fillable = [
        'numero_documento',
        'correo',
        'contrasena',
        'rol_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'contrasena' => 'hashed',
    ];

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function hasVerifiedEmail(): bool
    {
        return ! is_null($this->email_verified_at);
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    // Ahora Laravel gestiona los timestamps (created_at y updated_at) por defecto.
    public $timestamps = true;

    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }

    // Mantengo estos atributos simulados si las vistas lo necesitan, aunque conviene en vistas usar $user->correo directo.
    public function getEmailAttribute(): string
    {
        return $this->correo;
    }

    public function getNameAttribute(): string
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz?->nombres ?? '',
            self::ROL_INSTRUCTOR => $this->instructor?->nombres ?? '',
            self::ROL_ADMIN => $this->administrador?->nombres ?? '',
            self::ROL_EMPRESA => $this->empresa?->nombre ?? '',
            default => '',
        };
    }

    public function aprendiz(): HasOne
    {
        return $this->hasOne(Aprendiz::class, 'usuario_id', 'id');
    }

    public function instructor(): HasOne
    {
        return $this->hasOne(Instructor::class, 'usuario_id', 'id');
    }

    public function administrador(): HasOne
    {
        return $this->hasOne(Administrador::class, 'usuario_id', 'id');
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 'usuario_id', 'id');
    }

    public function isActivo(): bool
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz?->activo === 1,
            self::ROL_INSTRUCTOR => $this->instructor?->activo === 1,
            self::ROL_ADMIN => $this->administrador?->activo === 1,
            self::ROL_EMPRESA => $this->empresa?->activo === 1,
            default => false,
        };
    }

    public function getNombreCompletoAttribute(): string
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => trim(($this->aprendiz?->nombres ?? '').' '.($this->aprendiz?->apellidos ?? '')),
            self::ROL_INSTRUCTOR => trim(($this->instructor?->nombres ?? '').' '.($this->instructor?->apellidos ?? '')),
            self::ROL_ADMIN => trim(($this->administrador?->nombres ?? '').' '.($this->administrador?->apellidos ?? '')),
            self::ROL_EMPRESA => $this->empresa?->nombre ?? '',
            default => '',
        };
    }

    public function getNombreRolAttribute(): string
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => 'Aprendiz',
            self::ROL_INSTRUCTOR => 'Instructor',
            self::ROL_EMPRESA => 'Empresa',
            self::ROL_ADMIN => 'Administrador',
            default => 'Desconocido',
        };
    }

    public static function findByEmail(string $email): ?self
    {
        return static::where('correo', $email)->first();
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['contrasena'] = Hash::make($password);
    }

    public function tienePerfil(): bool
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz !== null,
            self::ROL_INSTRUCTOR => $this->instructor !== null,
            self::ROL_ADMIN => $this->administrador !== null,
            self::ROL_EMPRESA => $this->empresa !== null,
            default => false,
        };
    }
}
