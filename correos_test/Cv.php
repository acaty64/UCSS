<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class Test extends TestCase
{

    /**
     * My test implementation
     */
    public function testCV()
    {
        $this->visit('/');
        $this->visit('/solicitud');
        $this->type('Ana', 'name1');
        $this->type('Arashiro', 'name2');
        $this->type('Ana Arashiro', 'name3');
        $this->type('10101010', 'dni');
        $this->type('asdfee@aeaf.afw', 'email');
        $this->attach('absolutePathToFile', 'cv');
        $this->press('Enviar');
        $this->seePageIs('/solicitud');
        $this->seePageIs('/solicitud');
        $this->see('Mensaje enviado, espere nuestro correo de invitación');
    }
}