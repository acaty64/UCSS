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
            ->type('Nombre2', 'wdoc1')
            ->type('ApellidoP2', 'wdoc2')
            ->type('ApellidoM2', 'wdoc3')
            ->select('01','type')
            ->press('Registrar')
            ->see('Se ha registrado ')
            ->see(' de forma exitosa')
            ->seePageIs('users');
 
        // Modificar Usuario
        $this->click('Mody'.$cod_test)
            ->type('NuevoNombre', 'wdoc1')
            ->press('Grabar modificaciones')
            ->seePageIs('users')
            ->see('NuevoNombre');

        // Modificar Password
        $this->click('EditPass'.$cod_test)
            ->type('NuevoPassword', 'password')
            ->type('NuevoPassword', 'checkpassword')
            ->press('Grabar nuevo password')
            ->seePageIs('users')
            ->see('Se ha modificado el password de ');

        // Modificar DataUsers
        $this->click('EditData'.$cod_test)
            ->type('5330008', 'fono1')
            ->type('5330224', 'fono2')
            ->type('5330224', 'email1')
            ->press('Grabar modificaciones')
            ->see('Se ha modificado el registro');



        // Modificar DHoras
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Dhora'.$cod_test)
            ->see('Disponibilidad Horaria del Docente');
            //->click('D1_H11');

        $curso = new App\Curso;
        $curso->ccurso = '180001';
        $curso->wcurso = 'ACTIVIDADES I';
        $curso->save();

        // Modificar DCursos
        $this->click('Usuarios')
            ->seePageIs('users')
            ->click('Dcurso'.$cod_test)
            ->see('Disponibilidad de Cursos');
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


        // Salir del usuario
        $this->click($wdocente)
            ->click('Salir')
            ->seePageIs('auth/logout')
            ->see('Identifíquese');
    }
}
