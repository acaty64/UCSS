<?php
Route::get('/', function(){
	return view('welcome');
});
// Rutas ADMIN
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
	// Rutas USERS
	Route::resource('users','UsersController');
	Route::get('users/{id}/destroy',[
		'uses'  => 'UsersController@destroy',
		'as'	=> 'admin.users.destroy'
	]);
	Route::get('users/{users}/editpass',[
		'uses'  => 'UsersController@editpass',
		'as'	=> 'admin.users.editpass'
	]);
	Route::put('users/{users}',[
		'uses'  => 'UsersController@savepass',
		'as'	=> 'admin.users.savepass'
	]);


	// Rutas SEMESTRES
/*		Route::resource('semestres','SemestresController');
	Route::get('semestres/{id}/destroy',[
		'uses'  => 'SemestresController@destroy',
		'as'	=> 'admin.semestres.destroy'
	]);
*/

	// Rutas DATAUSERS
	Route::resource('datausers','DataUsersController');

	// Rutas DHORAS
	Route::resource('dhoras','DhorasController');

	// Rutas DCURSOS
	Route::resource('dcursos','DcursosController');

	/***********************************************************************/
	// Rutas RESPONSABLES
	Route::resource('usergrupos', 'UserGruposController');
	Route::get('usergrupos/{id}/destroy',[
		'uses'  => 'UserGruposController@destroy',
		'as'	=> 'admin.usergrupos.destroy'
	]);

	// Rutas GRUPOCURSOS
	Route::resource('grupocursos', 'GrupoCursosController');
	Route::get('grupocursos/{cursos}/orden',[
		'uses'	=> 'GrupocursosController@orden',
		'as'	=> 'admin.grupocursos.orden'
		]); 

});

// Ruta para imprimir en PDF
//Route::get('pdf', 'PdfController@invoice');
Route::get('pdf',[
	'uses'	=> 'PDFController@invoice',
	'as'	=> 'pdf'
	]	);

Route::get('pdf/{id}/usuario',[
	'uses'  => 'PDFController@usuario',
	'as'	=> 'PDF.usuario'
]);


Route::group(['middleware'=>['web']], function(){
	Route::auth();

	Route::get('/home', 'HomeController@index');
});

Route::get('auth/logout',[
	'uses'	=>	'Auth\AuthController@getLogout',
	'as'	=>	'auth.logout'
	]);


?>