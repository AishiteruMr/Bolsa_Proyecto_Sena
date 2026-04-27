<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespuestaSoporte extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $motivo;
    public $mensaje;
    public $respuesta;

    public function __construct($nombre, $motivo, $mensaje, $respuesta)
    {
        $this->nombre = $nombre;
        $this->motivo = $motivo;
        $this->mensaje = $mensaje;
        $this->respuesta = $respuesta;
    }

    public function build()
    {
        return $this->subject('Respuesta a tu solicitud de soporte')
                    ->view('emails.respuesta-soporte');
    }
}
