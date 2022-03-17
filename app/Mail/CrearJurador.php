<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CrearJurador extends Mailable
{
    use Queueable, SerializesModels;
    public $info;
    public $pass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$pasword)
    {
        $this->info = $data;
        $this->pass = $pasword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Datos de usuario.')->view('correo.nuevoJurado');
    }
}
