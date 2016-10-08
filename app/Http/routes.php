<?php

/*** RUTAS GENERALES *******************************/

Route::get('/', function(){
	return view('welcome');
});

Route::get('/init/{clave}', [
		'uses'	=> 'InitController@master',
		'as'	=> 'init.master'
	]);

Route::group(['middleware'=>['web']], function(){
	Route::auth();
	Route::get('/home','HomeController@index');
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


/***********************************************************************************/
/* DEBE ESTAR LOGUEADO */
Route::group(['middleware' => ['auth']], function()
{
	//http://localhost/roles_users_laravel/public/home/admin

	// Solo administrativos
	Route::group(['middleware' => ['roles:01-09']], function()
	{
		Route::get('users',['uses'=>'UsersController@index','as'=>'admin.users.index']);
		Route::get('dhoras/lista',[
			'uses'	=>'DhorasController@lista',
			'as'	=>'admin.dhoras.lista']);
		Route::get('dhoras/list2excel',[
			'uses'	=>	'DhorasController@List2Excel',
			'as'	=>	'admin.dhoras.List2Excel']);
		Route::get('dcursos/lista',[
			'uses'=>'DcursosController@lista',
			'as'=>'admin.dcursos.lista']);
		Route::get('dcursos/list2excel',[
			'uses'	=>	'DcursosController@List2Excel',
			'as'	=>	'admin.dcursos.List2Excel']);
	});
	// Fin middleware 01, 09

	//sólo pueden acceder usuarios con role_id 9
	Route::group(['middleware' => ['roles:09']], function()
	{
 	 //return "Como mínimo tu role debe ser master, tu eres " . getRole(Auth::user()->type);
//		Route::get('users',['uses'=>'UsersController@index','as'=>'admin.users.index']);
		Route::get('users/create',['uses'=>'UsersController@create','as'=>'admin.users.create']);
		Route::post('users',['uses'=>'UsersController@store','as'=>'admin.users.store']);
		Route::get('users/{users}/edit',['uses'=>'UsersController@edit','as'=>'admin.users.edit']);
		Route::put('users/{users}',['uses'=>'UsersController@update','as'=>'admin.users.update']);
		Route::get('users/{users}',['uses'=>'UsersController@show','as'=>'admin.users.show']);
		Route::delete('users/{users}',['uses'=>'UsersController@destroy','as'=>'admin.users.destroy']);

		Route::get('users/{id}/destroy',['uses'=>'UsersController@destroy','as'=>'admin.users.destroy']);
		Route::get('users/{users}/editpass',['uses'  => 'UsersController@editpass','as'	=> 'admin.users.editpass']);
		Route::put('users/{users}/savepass',['uses'  => 'UsersController@savepass','as'	=> 'admin.users.savepass']);
		Route::get('users/{id}/crypt',['uses'  => 'UsersController@cryptpass','as'	=> 'admin.users.crypt']);

		// Rutas GRUPOS
		//Route::resource('grupos','GruposController');
		Route::get('grupos',['uses'=>'GruposController@index','as'=>'admin.grupos.index']);
		Route::get('grupos/create',['uses'=>'GruposController@create','as'=>'admin.grupos.create']);
		Route::post('grupos',['uses'=>'GruposController@store','as'=>'admin.grupos.store']);
		Route::get('grupos/{users}/edit',['uses'=>'GruposController@edit','as'=>'admin.grupos.edit']);
		Route::put('grupos/{grupos}',['uses'=>'GruposController@update','as'=>'admin.grupos.update']);
		Route::get('grupos/{grupos}',['uses'=>'GruposController@show','as'=>'admin.grupos.show']);
		Route::delete('grupos/{grupos}',['uses'=>'GruposController@destroy','as'=>'admin.grupos.destroy']);
		Route::get('grupos/{id}/destroy',['uses'  => 'GruposController@destroy','as'=> 'admin.grupos.destroy']);

		// Rutas GRUPOCURSOS
		//Route::resource('grupocursos','GrupoCursosController');
		Route::get('grupocursos',['uses'=>'GrupoCursosController@index','as'=>'admin.grupocursos.index']);
		Route::get('grupocursos/create',['uses'=>'GrupoCursosController@create','as'=>'admin.grupocursos.create']);
		Route::post('grupocursos',['uses'=>'GrupoCursosController@store','as'=>'admin.grupocursos.store']);
		Route::get('grupocursos/{users}/edit',['uses'=>'GrupoCursosController@edit','as'=>'admin.grupocursos.edit']);
		Route::put('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@update','as'=>'admin.grupocursos.update']);
		Route::get('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@show','as'=>'admin.grupocursos.show']);
		Route::delete('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@destroy','as'=>'admin.grupocursos.destroy']);

		
		
		// Rutas DATAUSERS
		//Route::resource('datausers','DataUsersController');
		Route::get('datausers',['uses'=>'DataUsersController@index','as'=>'admin.datausers.index']);
		Route::get('datausers/create',['uses'=>'DataUsersController@create','as'=>'admin.datausers.create']);
		Route::post('datausers',['uses'=>'DataUsersController@store','as'=>'admin.datausers.store']);
		
		Route::delete('datausers/{datausers}',['uses'=>'DataUsersController@destroy','as'=>'admin.datausers.destroy']);

		Route::post('datausers/{datausers}/update',['uses'  => 'DatausersController@update','as'	=> 'admin.datausers.update']);

		
		// Rutas RESPONSABLES
		//Route::resource('usergrupos', 'UserGruposController');
		Route::get('usergrupos',['uses'=>'UserGruposController@index','as'=>'admin.usergrupos.index']);
		Route::get('usergrupos/create',['uses'=>'UserGruposController@create','as'=>'admin.usergrupos.create']);
		Route::post('usergrupos',['uses'=>'UserGruposController@store','as'=>'admin.usergrupos.store']);
		Route::get('usergrupos/{users}/edit',['uses'=>'UserGruposController@edit','as'=>'admin.usergrupos.edit']);
		Route::put('usergrupos/{usergrupos}',['uses'=>'UserGruposController@update','as'=>'admin.usergrupos.update']);
		Route::get('usergrupos/{usergrupos}',['uses'=>'UserGruposController@show','as'=>'admin.usergrupos.show']);
		Route::delete('usergrupos/{usergrupos}',['uses'=>'UserGruposController@destroy','as'=>'admin.usergrupos.destroy']);

		Route::get('usergrupos/{id}/destroy',['uses'  => 'UserGruposController@destroy','as'	=> 'admin.usergrupos.destroy']);


		// Rutas MAESTRO DE ENVIOS
		//Route::resource('menvios', 'MenviosController');
		Route::get('menvios',['uses'=>'MenviosController@index','as'=>'admin.menvios.index']);
		Route::get('menvios/create',['uses'=>'MenviosController@create','as'=>'admin.menvios.create']);
		Route::post('menvios',['uses'=>'MenviosController@store','as'=>'admin.menvios.store']);
		Route::get('menvios/{users}/edit',['uses'=>'MenviosController@edit','as'=>'admin.menvios.edit']);
		Route::put('menvios/{menvios}',['uses'=>'MenviosController@update','as'=>'admin.menvios.update']);
		Route::get('menvios/{menvios}',['uses'=>'MenviosController@show','as'=>'admin.menvios.show']);
		Route::delete('menvios/{menvios}',['uses'=>'MenviosController@destroy','as'=>'admin.menvios.destroy']);
		Route::post('menvios/{id}/update',['uses'  => 'MenviosController@update','as'	=> 'admin.menvios.update']);
		Route::get('menvios/{id}/destroy',['uses'  => 'MenviosController@destroy','as'	=> 'admin.menvios.destroy']);
		Route::get('menvios/{id}/dshow',['uses'  => 'MenviosController@dshow','as'	=> 'admin.menvios.dshow']);
		Route::post('menvios/dupdate',['uses'  => 'MenviosController@dupdate','as'	=> 'admin.menvios.dupdate']);
		Route::get('menvios/{data}/dmarkall',['uses'  => 'MenviosController@dmarkall','as'	=> 'admin.menvios.dmarkall']);
		Route::get('menvios/{data}/dunmarkall',['uses'  => 'MenviosController@dunmarkall','as'	=> 'admin.menvios.dunmarkall']);

		// Rutas ENVIOS
		Route::get('envios/{data}/send',['uses'  => 'EnviosController@send','as'	=> 'admin.envios.send']);
		Route::get('envios/testsend',['uses'  => 'EnviosController@testsend','as'	=> 'admin.envios.testsend']);
		Route::get('envios/{user_id, tipo}/enviados',['uses'  => 'EnviosController@enviados','as'	=> 'admin.envios.enviados']);

		Route::get('acciones/downdata',[
				'uses'	=>	'AccionesController@DownData',
				'as'	=>	'acciones.downdata'
			]);

		Route::get('importar/index',[
				'uses'	=>	'ImportController@index',
				'as'	=>	'import.index'
			]);

		Route::get('importar/{tipo}',[
				'uses'	=>	'ImportController@updata',
				'as'	=>	'import.updata'
			]);
	});
	// Fin middleware 09
	 
	//http://localhost/roles_users_laravel/public/home/new_post
	//sólo pueden acceder usuarios con role_id 3 y 9
	Route::group(['middleware' => ['roles:03-09']], function()
//	Route::get('/home',array("before" => "roles:03-09,resp", function()
	{
	 
//	 	return "Como mínimo tu role debe ser responsable, tu eres " . getRole(Auth::user()->type);
	 	// Rutas GRUPOCURSOS
	    Route::get('grupocursos/{user_id}/index2',['uses'  => 'GrupoCursosController@index2','as'	=> 'admin.grupocursos.index2']);
		Route::get('grupocursos/{grupo_id}/index',['uses'  => 'GrupoCursosController@index','as'	=> 'admin.grupocursos.index']);
		Route::get('grupocursos/{curso_id}/orden',['uses'  => 'GrupoCursosController@orden',
			'as'	=> 'admin.grupocursos.orden']);
		Route::get('grupocursos/{id}/uporden',['uses'  => 'GrupoCursosController@uporden',
			'as'	=> 'admin.grupocursos.uporden']);
		Route::get('grupocursos/{id}/downorden',['uses'  => 'GrupoCursosController@downorden',
			'as'	=> 'admin.grupocursos.downorden']);
	});
	// Fin middleware 03, 09
	 
	//http://localhost/roles_users_laravel/public/home/show_reply
	//sólo pueden acceder usuarios con role_id 2, 3 y 9
	Route::group(['middleware' => ['roles:02-03-09']], function()
//	Route::get('/home',array("before" => "roles:02-03-09,docente", function()
	{
	 
// 		return "Como mínimo tu role debe ser docente, tu eres " . getRole(Auth::user()->type);
 		// Rutas DATAUSERS
	    Route::get('datausers/{users}/edit',['uses'=>'DataUsersController@edit','as'=>'admin.datausers.edit']);
		Route::put('datausers/{datausers}',['uses'=>'DataUsersController@update','as'=>'admin.datausers.update']);
		Route::get('datausers/{datausers}',['uses'=>'DataUsersController@show','as'=>'admin.datausers.show']);

		// Rutas DHORAS
		//Route::resource('dhoras','DhorasController');
		Route::get('dhoras',['uses'=>'DhorasController@index','as'=>'admin.dhoras.index']);
		Route::get('dhoras/create',['uses'=>'DhorasController@create','as'=>'admin.dhoras.create']);
		Route::post('dhoras',['uses'=>'DhorasController@store','as'=>'admin.dhoras.store']);
		Route::get('dhoras/{users}/edit',['uses'=>'DhorasController@edit','as'=>'admin.dhoras.edit']);
		Route::put('dhoras/{dhoras}',['uses'=>'DhorasController@update','as'=>'admin.dhoras.update']);
		Route::get('dhoras/{dhoras}',['uses'=>'DhorasController@show','as'=>'admin.dhoras.show']);
		Route::delete('dhoras/{dhoras}',['uses'=>'DhorasController@destroy','as'=>'admin.dhoras.destroy']);


		// Rutas DCURSOS
		//Route::resource('dcursos','DcursosController');
		Route::get('dcursos',['uses'=>'DcursosController@index','as'=>'admin.dcursos.index']);
		Route::get('dcursos/create',['uses'=>'DcursosController@create','as'=>'admin.dcursos.create']);
		Route::post('dcursos',['uses'=>'DcursosController@store','as'=>'admin.dcursos.store']);
		Route::get('dcursos/{users}/edit',['uses'=>'DcursosController@edit','as'=>'admin.dcursos.edit']);
		Route::put('dcursos/{dcursos}',['uses'=>'DcursosController@update','as'=>'admin.dcursos.update']);
		Route::get('dcursos/{dcursos}',['uses'=>'DcursosController@show','as'=>'admin.dcursos.show']);
		Route::delete('dcursos/{dcursos}',['uses'=>'DcursosController@destroy','as'=>'admin.dcursos.destroy']);

	});
	// Fin middleware 02, 03, 09

	//sólo pueden acceder usuarios con role_id 1, 2 y 3
	Route::group(['middleware' => ['roles:01-02-03-09']], function()
//	Route::get('/home',array("before" => "roles:01-02-03-09,administrativo", function()
	{

		/*** RUTAS PDF *************************************/
		// Ruta para imprimir en PDF
		//Route::get('pdf', 'PdfController@invoice');
//		return "Como mínimo tu role debe ser administrativo, tu eres " . getRole(Auth::user()->type);
		Route::get('pdf',['uses'	=> 'PDFController@invoice','as'	=> 'pdf']	);

		Route::get('pdf/{id}/usuario',['uses'  => 'PDFController@usuario','as'	=> 'PDF.usuario']);

		Route::put('pdf/silaboCurso',['uses'  => 'PDFController@silaboCurso','as'	=> 'PDF.silaboCurso']);	

		/*** RUTAS CARGA HORARIA ******************************/
		Route::get('horarios/show',['uses'=>'HorariosController@show','as'=>'admin.horario.show']
		);
	});
	// Fin middleware 01, 02, 03, 09



	//http://localhost/roles_users_laravel/public/home
	//si ha iniciado sesión puede acceder, cualquier role
	Route::get('/home', function()
	{
	 
		//dd('get');
	 	return view('main');
	 	//"Si estás logueado ya puedes acceder aquí, tu eres " . getRole(Auth::user()->type);
	     
	});
 
});
 
//ruta para cerrar sesión
//http://localhost/roles_users_laravel/public/logout
Route::get("logout", function()
{
	Auth::logout();
	return Redirect::to('login');
});


?>