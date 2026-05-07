<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeSoporte;
use App\Mail\SoporteMailable;
use App\Jobs\SendEmailJob;

class SoporteController extends Controller
{
    public function enviar(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'motivo' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        // Save to DB
        MensajeSoporte::create($validated);

        // Send email notification to admin (async via queue)
        SendEmailJob::dispatch(
            config('mail.from.address'),
            new SoporteMailable($validated)
        );

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }
}
