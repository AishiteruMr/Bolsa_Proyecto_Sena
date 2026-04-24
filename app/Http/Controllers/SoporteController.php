<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\MensajeSoporte;

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

        // Send Email (Requires configuration in .env)
        // Mail::send('emails.soporte', ['data' => $validated], function ($m) use ($validated) {
        //     $m->to('admin@sena.edu.co')->subject('Nuevo mensaje de soporte: ' . $validated['motivo']);
        // });

        return back()->with('success', 'Tu mensaje ha sido enviado correctamente.');
    }
}
