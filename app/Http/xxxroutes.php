<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*Route::get('/home', function () {
    return view('welcome');
});*/


/* Grupo de rutas de admin */
Route::group(['prefix' => 'admin'], function(){
		/* Route:resource('ruta','controlador') 
		*	Toma las rutas segun los metodos del controller
		*/
		Route::resource('users','UsersController');
		Route::get('users/{id}/destroy',[
			'uses'  => 'UsersController@destroy',
			'as'	=> 'admin.users.destroy'
		]);

		Route::resource('semestres','SemestresController');
		Route::get('semestres/{id}/destroy',[
			'uses'  => 'SemestresController@destroy',
			'as'	=> 'admin.semestres.destroy'
		]);
});



/* Rutas asignadas para cambiar el campo de validacion*/

Route::get('admin/auth/login',[
	'uses'	=>	'Auth\AuthController@getLogin',
	'as'	=>	'admin.auth.login'
	]);

Route::post('admin/auth/login',[
	'uses'	=>	'Auth\AuthController@postLogin',
	'as'	=>	'admin.auth.login'
	]);

Route::get('admin/auth/logout',[
	'uses'	=>	'Auth\AuthController@getLogout',
	'as'	=>	'admin.auth.logout'
	]);
/**/

/* Rutas creadas por make:auth */
/*Route::group(['middleware'=>['web']], function(){
	//
	Route::auth();

	Route::get('/home', 'HomeController@index');
});*/


//	Route::resource('datausers','DataUsersController');
	
	/* Ejemplo de ROUTE independiente */
/*	Route::get('view/{id}',[
		'uses'	=>	'TestController@view',
		'as'	=>	'usersView'
	]);
*/

?>