<?php
namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\RegistroExitoso;
use App\Traits\PaginacionTrait;
use App\Traits\ValidacionMensajes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ValidacionMensajes, PaginacionTrait;

    // ─── MÉTODOS COMPARTIDOS ────────────────────────────────────────────────────────

    protected function getPerfilUsuario(int $usrId, int $rol): ?object
    {
        return match ($rol) {
            1 => DB::table('aprendices')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', 'activo as estado')
                ->first(),
            2 => DB::table('instructores')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', 'activo as estado')
                ->first(),
            3 => DB::table('empresas')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nit as nit', 'nombre as nombre', DB::raw("'' as apellido"), 'activo as estado')
                ->first(),
            4 => DB::table('administradores')
                ->where('usuario_id', $usrId)
                ->select('id as id', 'nombres as nombre', 'apellidos as apellido', DB::raw('1 as estado'))
                ->first(),
            default => null
        };
    }

    protected function enviarCorreoBienvenida(string $correo, string $nombre, string $apellido): void
    {
        SendEmailJob::dispatch($correo, new RegistroExitoso($nombre, $apellido));
    }
}