<?php
/*** RUTAS GENERALES *******************************/
Route::get('/', function(){
	return view('welcome');
});
Route::group(['middleware'=>['web']], function(){
	Route::auth();
	Route::get('/home', 'HomeController@index');
});

Route::get('auth/login',[
	'uses'	=>	'Auth\AuthController@getLogin',
	'as'	=>	'auth.login'
	]);

Route::post('auth/login',[
	'uses'	=>	'Auth\AuthController@postLogin',
	'as'	=>	'auth.login'
	]);

Route::get('auth/logout',[
	'uses'	=>	'Auth\AuthController@getLogout',
	'as'	=>	'auth.logout'
	]);
/*** fin rutas GENERALES ***************************/

/***************************************************/
/***  RUTAS ADMIN **********************************/
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
	Route::put('users/{users}/savepass',[
		'uses'  => 'UsersController@savepass',
		'as'	=> 'admin.users.savepass'
	]);
	Route::get('users/{id}/crypt',[
		'uses'  => 'UsersController@cryptpass',
		'as'	=> 'admin.users.crypt'
	]);


	// Rutas GRUPOS
	Route::resource('grupos','GruposController');
	Route::get('grupos/{id}/destroy',[
		'uses'  => 'GruposController@destroy',
		'as'	=> 'admin.grupos.destroy'
	]);

	// Rutas GRUPOCURSOS
	Route::resource('grupocursos','GrupoCursosController');
	Route::get('grupocursos/{grupo_id}/index',[
		'uses'  => 'GrupoCursosController@index',
		'as'	=> 'admin.grupocursos.index'
	]);
	Route::get('grupocursos/{user_id}/index2',[
		'uses'  => 'GrupoCursosController@index2',
		'as'	=> 'admin.grupocursos.index2'
	]);
	Route::post('grupocursos/{grupocurso}/orden',[
		'uses'  => 'GrupoCursosController@orden',
		'as'	=> 'admin.grupocursos.orden'
	]);
	Route::get('grupocursos/{id}/uporden',[
		'uses'  => 'GrupoCursosController@uporden',
		'as'	=> 'admin.grupocursos.uporden'
	]);
	Route::get('grupocursos/{id}/downorden',[
		'uses'  => 'GrupoCursosController@downorden',
		'as'	=> 'admin.grupocursos.downorden'
	]);

	// Rutas DATAUSERS
	Route::resource('datausers','DataUsersController');
	Route::post('datausers/{datausers}/update',[
		'uses'  => 'DatausersController@update',
		'as'	=> 'admin.datausers.update'
	]);

	// Rutas DHORAS
	Route::resource('dhoras','DhorasController');

	// Rutas DCURSOS
	Route::resource('dcursos','DcursosController');

	// Rutas RESPONSABLES
	Route::resource('usergrupos', 'UserGruposController');
	Route::get('usergrupos/{id}/destroy',[
		'uses'  => 'UserGruposController@destroy',
		'as'	=> 'admin.usergrupos.destroy'
	]);

	// Rutas GRUPOCURSOS
	Route::resource('grupocursos', 'GrupoCursosController');
	Route::get('grupocursos/{id}/destroy',[
		'uses'  => 'GrupocursosController@destroy',
		'as'	=> 'admin.grupocursos.destroy'
		]); 
	Route::get('grupocursos/{cursos}/orden',[
		'uses'	=> 'GrupocursosController@orden',
		'as'	=> 'admin.grupocursos.orden'
		]); 

	// Rutas MAESTRO DE ENVIOS
	Route::resource('menvios', 'MenviosController');
	Route::post('menvios/{id}/update',[
		'uses'  => 'MenviosController@update',
		'as'	=> 'admin.menvios.update'
	]);
	Route::get('menvios/{id}/destroy',[
		'uses'  => 'MenviosController@destroy',
		'as'	=> 'admin.menvios.destroy'
	]);
	Route::get('menvios/{id}/dshow',[
		'uses'  => 'MenviosController@dshow',
		'as'	=> 'admin.menvios.dshow'
	]);
	Route::post('menvios/dupdate',[
		'uses'  => 'MenviosController@dupdate',
		'as'	=> 'admin.menvios.dupdate'
	]);
	Route::get('menvios/{id}/dmarkall',[
		'uses'  => 'MenviosController@dmarkall',
		'as'	=> 'admin.menvios.dmarkall'
	]);
	Route::get('menvios/{id}/dunmarkall',[
		'uses'  => 'MenviosController@dunmarkall',
		'as'	=> 'admin.menvios.dunmarkall'
	]);
	// Rutas ENVIOS
	Route::get('envios/{id}/send',[
		'uses'  => 'EnviosController@send',
		'as'	=> 'admin.envios.send'
	]);

});
/*** fin Rutas ADMIN *******************************/

/*** RUTAS PDF *************************************/
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

Route::put('pdf/silaboCurso',[
	'uses'  => 'PDFController@silaboCurso',
	'as'	=> 'PDF.silaboCurso'
]);

/*** fin rutas PDF *********************************/

?>