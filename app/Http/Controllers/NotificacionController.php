<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $usuario = User::findOrFail(cuser_id());
        $filter = $request->get('filter', 'all');

        $query = $usuario->notifications()->orderByDesc('created_at');

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        }

        $notificaciones = $query->paginate(20);
        
        // Guardar la URL de retorno si no venimos de la misma página de notificaciones
        $previous = url()->previous();
        if (strpos($previous, '/notificaciones') === false && !empty($previous)) {
            session(['notificaciones_return_url' => $previous]);
        }
        
        return view('shared.notificaciones', compact('notificaciones', 'usuario', 'filter'));
    }

    public function leer(Request $request, string $id)
    {
        $usuario = User::findOrFail(cuser_id());
        $notificacion = $usuario->notifications()->where('id', $id)->firstOrFail();
        
        $notificacion->markAsRead();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Notificación marcada como leída.']);
        }

        return back()->with('success', 'Notificación marcada como leída.');
    }

    public function leerTodas(Request $request)
    {
        $usuario = User::findOrFail(cuser_id());
        $usuario->unreadNotifications->markAsRead();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Todas las notificaciones marcadas como leídas.']);
        }

        return back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }
}
