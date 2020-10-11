<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultaExternaModuleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConsultUsers()
    {
        $this->get('/LeonBecerra/datos_generales/usuarios/cargar_usuarios')
            ->assertStatus(302);
    }
    public function testCreateUsers()
    {
        $this->get('/LeonBecerra/datos_generales/usuarios/guardar_usuario')
            ->assertStatus(302);
    }    
    public function testModifyUsers()
    {
        $this->get('/LeonBecerra/datos_generales/usuarios/modificar_usuario')
            ->assertStatus(302);
    }
    public function testDeleteUsers()
    {
        $this->get('/LeonBecerra/datos_generales/usuarios/eliminar_usuario/{5}')
            ->assertStatus(302);
    }
}
