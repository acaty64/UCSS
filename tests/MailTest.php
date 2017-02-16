<?php

//  SOLO PARA LOCALHOST

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MailTest extends TestCase
{
	public function testContacto()
	{
	
		$this->visit('/')
			->see('Bienvenido')
            ->seePageIs('/');
        $this->click("Correo de contacto")
        	->type('Ana', 'name1')
        	->type('Arashiro', 'name2')
        	->type('Ana Arashiro', 'name3')
        	->type('10101010', 'dni')
        	->type('asdfee@aeaf.afw', 'email')
        	->attach('C:\Users\ana\Desktop\print_prueba.pdf', 'cv')
			->press('Enviar')
			->seePageIs('/solicitud')
    		->see('Mensaje enviado, espere nuestro correo de invitación');

	}
}
