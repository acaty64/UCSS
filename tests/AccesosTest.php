<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccesosTest extends TestCase
{
    use DatabaseMigrations;

    // Verificacion de acceso al Login
    public function testAccesos()
    {
        $this->visit('/')
            ->see('Login')
            ->seePageIs('/');

        $this->click('Login')
            ->see('Identifíquese')
            ->see('Acceder');

        $user = factory(App\User::class)
            ->create([
                'username'  =>'000001', 
                'wdoc1'     =>'Nombre1',
                'wdoc2'     =>'ApellidoP1',
                'wdoc3'     =>'ApellidoM1',
                'type'      =>'09',
                'password'  =>bcrypt('password'),
                'swcierre'  =>'false', 
                'slug'      => ''
            ]);
        $wdocente = $user->wdoc2 . ' ' . $user->wdoc3 . ', ' . $user->wdoc1;

        // Master
        $this->actingAs($user)
            ->visit('/home')
             ->seePageIs('home')
             ->see($user->wdoc3)
             ->see('Usuarios')
             ->see('Grupos de Cursos')
                ->see('Grupos')
                ->see('Responsables')
             ->see('Verificaciones')
                ->see('Actualización de Disponibilidad Horaria')
                ->see('Actualización de Disponibilidad de Cursos')
                ->see('Actualización de Datos Usuarios')
             ->see('Acciones')
                ->see('Envíos de correos electrónicos')
                ->see('Exportar información')
                ->see('Importar información');

        // Administrativos
        $user->type = '01';
        $this->actingAs($user)
            ->visit('/home')
             ->seePageIs('home')
             ->see($user->wdoc3)
             ->see('Datos Personales');

        // Docentes
        $user->type = '02';
        $this->actingAs($user)
            ->visit('/home')
             ->seePageIs('home')
             ->see($user->wdoc3)
             ->see('Datos Personales')
             ->see('Disponibilidad')
                ->see('Días y Horas')
                ->see('Cursos')
             ->see('Carga Asignada');

        // Docentes
        $user->type = '03';
        $this->actingAs($user)
            ->visit('/home')
             ->seePageIs('home')
             ->see($user->wdoc3)
             ->see('Datos Personales')
             ->see('Disponibilidad')
                ->see('Días y Horas')
                ->see('Cursos')
             ->see('Carga Asignada')
             ->see('Prioridad Docentes');

        // Salir del usuario
        $this->click($wdocente)
            ->click('Salir')
            ->seePageIs('/')
            ->see('Bienvenido');
    }
    
}
