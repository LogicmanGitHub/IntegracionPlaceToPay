<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PagosModuleTest extends TestCase
{
    /**
     * @test
     */
    function listar_pagos()
    {
    	$this->get('/pagos')
    	->assertStatus(200)
    	->assertViewHas('pagos');
    }

    function crear_pago()
    {
    	$this->get('/pagos/create')
    	->assertStatus(200);

    }

    function guardar_pago()
    {
    	$this->get('/pagos/store')
    	->assertStatus(200);    	
    }
}
