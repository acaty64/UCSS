<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// Verificacion de funcionalidad de usuario MASTER
class MasterTest extends TestCase
{
    use DatabaseMigrations;

    // Verificacion de acceso al Login
    public function testUsuarios()
    {
        $this->visit('/')
            ->see('Login')
            ->seePageIs('/');

        $this->click('Login')
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
             ->see('Usuarios');

        // Agregar Usuario 
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Registrar Nuevo Usuario')
            ->seePageIs('users/create');
        
        $sede = new App\Sede;
        $sede->create([
                    'csede' => 'LIM',
                    'wsede' => 'SEDE CENTRAL'
                ]);


        $cod_test = '000002';

        $this->see('Registrar')
            ->type($cod_test, 'username')
            ->type($cod_test, 'password')
            ->type('A', 'wdoc1')
            ->type('B', 'wdoc2')
            ->type('C', 'wdoc3')
            ->select('01','type')
            ->press('Registrar')
            ->see('El campo wdoc1 debe contener al menos 2 caracteres.')
            ->see('El campo wdoc2 debe contener al menos 2 caracteres.')
            ->type($cod_test, 'password')
            ->type('Nombre', 'wdoc1')
            ->type('ApellidoP1', 'wdoc2')
            ->type('ApellidoM1', 'wdoc3')
            ->press('Registrar')
            ->see('Se ha registrado ')
            ->see(' de forma exitosa')
            ->seePageIs('users')
            ->seeInDatabase('users',[
                'username'  => $cod_test,
                'wdoc1'     => 'Nombre'
                ])
            ->seeInDatabase('dhoras',[
                'cdocente'  => $cod_test
                ]);
 
        // Modificar Usuario
        $this->click('Mody'.$cod_test)
            ->seePageIs('users/2/edit')
            ->newSeeInField('wdoc1','Nombre')
            ->type('NuevoNombre', 'wdoc1')
            ->press('Grabar modificaciones')
            ->seePageIs('users/2/edit')
            ->see('NuevoNombre');

        // Modificar Password
        $this->click('Usuarios')
            ->click('EditPass'.$cod_test)
            ->seePageIs('users/2/editpass')
            ->type('NuevoPassword', 'password')
            ->type('NuevoPassword', 'checkpassword')
            ->press('Grabar nuevo password')
            ->seePageIs('users')
            ->see('Se ha modificado el password de ');

        // Modificar DataUsers
        $this->click('Usuarios')
            ->click('EditData'.$cod_test)
            ->seePageIs('datausers/2/edit')
            ->type('5330008', 'fono1')
            ->type('5330224', 'fono2')
            ->type('5330224', 'email1')
            ->press('Grabar modificaciones')
            ->seePageIs('datausers/2/edit')
            ->see('Se ha modificado el registro');

        // Agregar las franjas horarias        
        $franja = App\Franja::create([
                'csede' => 'LIM',
                'dia'   => 1,
                'turno' => 1,
                'hora'  => 1, 
                'wfranja' => '08:30-10:00',
                'sede_id'  => 1
            ]);

        // MODULO DISPONIBILIDAD DE HORAS
        // Modificar DHoras
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Dhora'.$cod_test)
            ->see('08:30-10:00')
            ->seePageIs('dhoras/2/edit')
            ->see('Disponibilidad Horaria del Docente')
//            ->newSeeInField('D1_H11', 'off');
            ->check('D1_H11')
            ->press('Grabar modificaciones')
            ->seeInDatabase('dhoras',[
                'cdocente'  => $cod_test,
                'D1_H11'    => '1'
                ])
            ->seePageIs('users')
            ->see('Se ha registrado la modificación de forma exitosa');


        // MODULO DISPONIBILIDAD DE CURSOS
        $curso = new App\Curso;
        $curso->ccurso = '180001';
        $curso->wcurso = 'ACTIVIDADES I';
        $curso->save();

        // Modificar DCursos
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Dcurso'.$cod_test)
            ->see('Disponibilidad de Cursos')
            ->select('ACTIVIDADES I','cursos[]')
            ->see('Grabar o Confirmar cursos');
//            ->press('Grabar');
/*            ->see('Se ha registrado la modificación de disponibilidad de cursos de forma exitosa');
//            ->see('ACTIVIDADES I');
//            ->newSeeInField('cursos[]', 'ACTIVIDADES I');
/*          NO SE COMO AGREGAR UN CURSO EN SELECT MULTIPLE-CHOICE
            ->select('1','cursos[]')
            ->see('ACTIVIDADES I');
*/


        /////////////////// PENDIENTE
        // VERIFICACIONES
            // Actualizacion de Disponilidad Horaria
            // Actualizacion de Disponilidad de Cursos
            // Actualizacion de Datos Usuarios
        // ACCIONES
            // Envíos de correos electrónicos
            // Exportar información
            // Importar información



/*
        //// VA AL FINAL

        // Eliminar Usuario
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Dele'.$cod_test)
            ->see('Está seguro de eliminar el registro?');

/*          NO SE COMO SE CONTROLA LA VENTANA   
            ->click(true)
            ->seePageIs('users')
            ->see('Se ha eliminado usuario '.$cod_test)
            ->Dontsee('NuevoNombre');
*/

/*
        // Salir del usuario
        $this->click($wdocente)
            ->click('Salir')
            ->seePageIs('auth/logout')
            ->see('Identifíquese');
*/

    }
}
