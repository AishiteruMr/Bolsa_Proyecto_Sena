<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'usr_id';

    const ROL_APRENDIZ = 1;
    const ROL_INSTRUCTOR = 2;
    const ROL_EMPRESA = 3;
    const ROL_ADMIN = 4;

    protected $fillable = [
        'usr_documento',
        'usr_correo',
        'usr_contrasena',
        'rol_id',
        'usr_fecha_creacion',
    ];

    protected $hidden = [
        'usr_contrasena',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'usr_fecha_creacion' => 'datetime',
        'usr_contrasena' => 'hashed',
    ];

    public $timestamps = false;

    public function getAuthPassword(): string
    {
        return $this->usr_contrasena;
    }

    public function getEmailAttribute(): string
    {
        return $this->usr_correo;
    }

    public function getNameAttribute(): string
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz?->apr_nombre ?? '',
            self::ROL_INSTRUCTOR => $this->instructor?->ins_nombre ?? '',
            self::ROL_ADMIN => $this->administrador?->adm_nombre ?? '',
            default => '',
        };
    }

    public function aprendiz(): HasOne
    {
        return $this->hasOne(Aprendiz::class, 'usr_id', 'usr_id');
    }

    public function instructor(): HasOne
    {
        return $this->hasOne(Instructor::class, 'usr_id', 'usr_id');
    }

    public function administrador(): HasOne
    {
        return $this->hasOne(Administrador::class, 'usr_id', 'usr_id');
    }

    public function empresa(): HasOne
    {
        return $this->hasOne(Empresa::class, 'usr_id', 'usr_id');
    }

    public function isActivo(): bool
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz?->apr_estado === 1,
            self::ROL_INSTRUCTOR => $this->instructor?->ins_estado === 1,
            self::ROL_EMPRESA => $this->empresa?->emp_estado === 1,
            self::ROL_ADMIN => true,
            default => false,
        };
    }

    public function getNombreCompletoAttribute(): string
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => trim(($this->aprendiz?->apr_nombre ?? '') . ' ' . ($this->aprendiz?->apr_apellido ?? '')),
            self::ROL_INSTRUCTOR => trim(($this->instructor?->ins_nombre ?? '') . ' ' . ($this->instructor?->ins_apellido ?? '')),
            self::ROL_ADMIN => trim(($this->administrador?->adm_nombre ?? '') . ' ' . ($this->administrador?->adm_apellido ?? '')),
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
        return static::where('usr_correo', $email)->first();
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes['usr_contrasena'] = Hash::make($password);
    }

    public function tienePerfil(): bool
    {
        return match ($this->rol_id) {
            self::ROL_APRENDIZ => $this->aprendiz !== null,
            self::ROL_INSTRUCTOR => $this->instructor !== null,
            self::ROL_ADMIN => $this->administrador !== null,
            self::ROL_EMPRESA => false,
            default => false,
        };
    }
}
