<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdministracionFarmaciaModuleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConsultFarmacia()
    {
        $this->get('/LeonBecerra/gestion_hospitalaria/dministracion_farmacia/cargar_farmacia')
            ->assertStatus(302);
    }
    public function testCreateFarmacia()
    {
        $this->get('/LeonBecerra/gestion_hospitalaria/dministracion_farmacia/guardar_farmacia')
            ->assertStatus(302);
    }    
    public function testModifyFarmacia()
    {
        $this->get('/LeonBecerra/gestion_hospitalaria/dministracion_farmacia/modificar_farmacia')
            ->assertStatus(302);
    }
    public function testDeleteFarmacia()
    {
        $this->get('/LeonBecerra/gestion_hospitalaria/dministracion_farmacia/eliminar_farmacia{1}')
            ->assertStatus(302);
    }
}
