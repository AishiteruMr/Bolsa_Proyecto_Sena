<?php

namespace App\Http\Controllers;

use App\Events\SoporteEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\MensajeSoporte;
use App\Mail\SoporteMailable;
use App\Jobs\SendEmailJob;

class SoporteController extends Controller
{
    public function enviar(Request $request): \Illuminate\Http\RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'motivo' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        MensajeSoporte::create($validated);

        event(new SoporteEvent('nuevo', [
            'message' => "Nuevo mensaje de soporte de {$validated['nombre']}",
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'motivo' => $validated['motivo'],
        ]));

        SendEmailJob::dispatch(
            config('mail.from.address'),
            new SoporteMailable($validated)
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Mensaje enviado. Te responderemos pronto.'
            ]);
        }

        return back()->with('success', 'Mensaje enviado. Te responderemos pronto.');
    }
}
