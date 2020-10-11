<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeguridadModuleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testConsultLogs()
    {
        $this->get('/LeonBecerra/datos_generales/logs/registrar_log_usuario')
            ->assertStatus(302);
    }
    public function testCreateLogs()
    {
        $this->get('/LeonBecerra/datos_generales/logs/cargar_logs')
            ->assertStatus(302);
    } 
}
