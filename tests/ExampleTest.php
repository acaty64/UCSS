<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test1()
    {
        $this->visit('/login')
             ->seePageIs('login');
    }

    public function test09()
    {
        $this->visit('/login')
            ->type('000001', 'username')
            ->type('123456', 'password')
            ->press('Acceder')
            ->seePageIs('home');
    }

    /* Prueba acceso administrador */
    public function test0901()
    {
        $this->test09();
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Registrar Nuevo Usuario')
            ->see('Crear Usuario')
            ->click('opcLogin')
            ->click('opcLogout');
    }

    public function test0902()
    {
        $this->test09();
        $this->click('opcGrupos')
            ->see('Crear Nuevo Grupo');
//            ->click('Crear Nuevo Grupo')
//            ->see('admin.grupos.create');
    }

    public function test0903()
    {
        $this->test09();
        $this->click('opcResponsables')
            ->see('Responsables')
            ->click('opcLogin')
            ->click('opcLogout');
    }


    // Prueba acceso usuario 
    public function test02()
    {
        $this->visit('/login')
            ->type('000006', 'username')
            ->type('123456', 'password')
            ->press('Acceder')
            ->seePageIs('home')
            ->see('Datos Personales')
            ->see('Disponibilidad');
    }

    public function test0202()
    {
        $this->test02();
        $this->click('Datos Personales')
            ->see('Modificación de Datos del Docente');
    }

    public function test0203()
    {
        $this->test02();
        $this->click('Dias y Horas')
            ->see('Disponibilidad Horaria');
    }
    
    // Prueba acceso responsable 
    public function test03()
    {
        $this->visit('/login')
            ->type('000152', 'username')
            ->type('123456', 'password')
            ->press('Acceder')
            ->seePageIs('home')
            ->see('Datos Personales')
            ->see('Disponibilidad')
            ->see('Prioridad Docentes');
    }

    public function test0301()
    {
        $this->test03();
        $this->click('Prioridad Docentes')
            ->see('Cursos del grupo')            
            ->click('Seleccionar')
            ->see('Prioridad de Docentes del curso');
    }

    // Prueba acceso Administrativos
    public function test01()
    {
        $this->visit('/login')
            ->type('999999', 'username')
            ->type('999999', 'password')
            ->press('Acceder')
            ->seePageIs('home')
            ->see('Datos Personales');
    }

    public function test0101()
    {
        $this->test01();
        $this->click('Datos Personales')
            ->seePageIs('users')
            ->Click('Ver PDF')
            ->see('pdf');
    }

}
