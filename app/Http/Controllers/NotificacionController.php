<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificacionController extends Controller
{
    public function index()
    {
        $usuario = User::findOrFail(cuser_id());
        $notificaciones = $usuario->notifications()->orderByDesc('created_at')->paginate(20);
        
        // Guardar la URL de retorno si no venimos de la misma página de notificaciones
        $previous = url()->previous();
        if (strpos($previous, '/notificaciones') === false && !empty($previous)) {
            session(['notificaciones_return_url' => $previous]);
        }
        
        return view('shared.notificaciones', compact('notificaciones'));
    }

    public function leer(string $id)
    {
        $usuario = User::findOrFail(cuser_id());
        $notificacion = $usuario->notifications()->where('id', $id)->firstOrFail();
        
        $notificacion->markAsRead();
        
        return back()->with('success', 'Notificación marcada como leída.');
    }

    public function leerTodas()
    {
        $usuario = User::findOrFail(cuser_id());
        $usuario->unreadNotifications->markAsRead();
        
        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
