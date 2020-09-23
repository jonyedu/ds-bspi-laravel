<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioPrescripcion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $rutaFile;
    public $datosPaciente;

    public function __construct($rutaFile, $datosPaciente)
    {
        $this->rutaFile = $rutaFile;
        $this->datosPaciente = $datosPaciente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$rutaFile = 'reports/prescripciones/Jonathan  Mora -CED_0954776712-2020-09-03 11_44_33.pdf';
        return $this->view('mail.envioPrescripcion')
            ->attach($this->rutaFile);
    }
}
