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
Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']], function(){
	
	// Rutas USERS
	/*Route::resource('users','UsersController');
	Route::get('users/{id}/destroy',[
		'uses'  => 'UsersController@destroy',
		'as'	=> 'admin.users.destroy'
	]);*/

//dd('Auth::user()');

	Route::get('users',['uses'=>'UsersController@index','as'=>'admin.users.index']);
	Route::get('users/create',['uses'=>'UsersController@create','as'=>'admin.users.create']);
	Route::post('users',['uses'=>'UsersController@store','as'=>'admin.users.store']);
	Route::get('users/{users}/edit',['uses'=>'UsersController@edit','as'=>'admin.users.edit']);
	Route::put('users/{users}',['uses'=>'UsersController@update','as'=>'admin.users.update']);
	Route::get('users/{users}',['uses'=>'UsersController@show','as'=>'admin.users.show']);
	Route::delete('users/{users}',['uses'=>'UsersController@destroy','as'=>'admin.users.destroy']);

	Route::get('users/{id}/destroy',[
		'uses'=>'UsersController@destroy',
		'as'=>'admin.users.destroy'
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
	//Route::resource('grupos','GruposController');
	Route::get('grupos',['uses'=>'GruposController@index','as'=>'admin.grupos.index']);
	Route::get('grupos/create',['uses'=>'GruposController@create','as'=>'admin.grupos.create']);
	Route::post('grupos',['uses'=>'GruposController@store','as'=>'admin.grupos.store']);
	Route::get('grupos/{users}/edit',['uses'=>'GruposController@edit','as'=>'admin.grupos.edit']);
	Route::put('grupos/{grupos}',['uses'=>'GruposController@update','as'=>'admin.grupos.update']);
	Route::get('grupos/{grupos}',['uses'=>'GruposController@show','as'=>'admin.grupos.show']);
	Route::delete('grupos/{grupos}',['uses'=>'GruposController@destroy','as'=>'admin.grupos.destroy']);
	Route::get('grupos/{id}/destroy',[
		'uses'  => 'GruposController@destroy',
		'as'	=> 'admin.grupos.destroy'
	]);

	// Rutas GRUPOCURSOS
	//Route::resource('grupocursos','GrupoCursosController');
	Route::get('grupocursos',['uses'=>'GrupoCursosController@index','as'=>'admin.grupocursos.index']);
	Route::get('grupocursos/create',['uses'=>'GrupoCursosController@create','as'=>'admin.grupocursos.create']);
	Route::post('grupocursos',['uses'=>'GrupoCursosController@store','as'=>'admin.grupocursos.store']);
	Route::get('grupocursos/{users}/edit',['uses'=>'GrupoCursosController@edit','as'=>'admin.grupocursos.edit']);
	Route::put('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@update','as'=>'admin.grupocursos.update']);
	Route::get('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@show','as'=>'admin.grupocursos.show']);
	Route::delete('grupocursos/{grupocursos}',['uses'=>'GrupoCursosController@destroy','as'=>'admin.grupocursos.destroy']);

	Route::get('grupocursos/{grupo_id}/index',[
		'uses'  => 'GrupoCursosController@index',
		'as'	=> 'admin.grupocursos.index'
	]);
	Route::get('grupocursos/{user_id}/index2',[
		'uses'  => 'GrupoCursosController@index2',
		'as'	=> 'admin.grupocursos.index2'
	]);
	Route::get('grupocursos/{curso_id}/orden',[
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
	//Route::resource('datausers','DataUsersController');
	Route::get('datausers',['uses'=>'DataUsersController@index','as'=>'admin.datausers.index']);
	Route::get('datausers/create',['uses'=>'DataUsersController@create','as'=>'admin.datausers.create']);
	Route::post('datausers',['uses'=>'DataUsersController@store','as'=>'admin.datausers.store']);
	Route::get('datausers/{users}/edit',['uses'=>'DataUsersController@edit','as'=>'admin.datausers.edit']);
	Route::put('datausers/{datausers}',['uses'=>'DataUsersController@update','as'=>'admin.datausers.update']);
	Route::get('datausers/{datausers}',['uses'=>'DataUsersController@show','as'=>'admin.datausers.show']);
	Route::delete('datausers/{datausers}',['uses'=>'DataUsersController@destroy','as'=>'admin.datausers.destroy']);

	Route::post('datausers/{datausers}/update',[
		'uses'  => 'DatausersController@update',
		'as'	=> 'admin.datausers.update'
	]);

	// Rutas DHORAS
	Route::resource('dhoras','DhorasController');

	// Rutas DCURSOS
	Route::resource('dcursos','DcursosController');

	// Rutas RESPONSABLES
	//Route::resource('usergrupos', 'UserGruposController');
	Route::get('usergrupos',['uses'=>'UserGruposController@index','as'=>'admin.usergrupos.index']);
	Route::get('usergrupos/create',['uses'=>'UserGruposController@create','as'=>'admin.usergrupos.create']);
	Route::post('usergrupos',['uses'=>'UserGruposController@store','as'=>'admin.usergrupos.store']);
	Route::get('usergrupos/{users}/edit',['uses'=>'UserGruposController@edit','as'=>'admin.usergrupos.edit']);
	Route::put('usergrupos/{usergrupos}',['uses'=>'UserGruposController@update','as'=>'admin.usergrupos.update']);
	Route::get('usergrupos/{usergrupos}',['uses'=>'UserGruposController@show','as'=>'admin.usergrupos.show']);
	Route::delete('usergrupos/{usergrupos}',['uses'=>'UserGruposController@destroy','as'=>'admin.usergrupos.destroy']);

	Route::get('usergrupos/{id}/destroy',[
		'uses'  => 'UserGruposController@destroy',
		'as'	=> 'admin.usergrupos.destroy'
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

/***********************************************************************************/

//devuelve el nombre del rol del usuario según el número
if(!function_exists('getRole'))
{
	function getRole($role)
	{
	 
	switch ($role) {
		case '00':
			return "Invitado.";
			break;
		case '01':
			return "Administrativo.";
			break;
		case '02':
			return "Docente.";
			break;
		case '03':
			return "Responsable.";
			break; 
		case '09':
			return "Master.";
			break; 
		default:
			return "Invitado.";
			break;
	 }
	 
	 }
}
 
/*ruta con el prefijo home que comprueba primero si 
//existe la sesión, si es así comprueba el rol del usuario
/
/admin: 3
/editor: 2
/suscriptor: 1
/invitado: 0
/
*/
Route::group(array('prefix' => 'home','before' => 'auth'), function()
{
 
	//http://localhost/roles_users_laravel/public/home/admin
	//sólo pueden acceder usuarios con role_id 3
	Route::get('master',array("before" => "roles:'09',master", function()
	{
	 
	 	return "Como mínimo tu role debe ser master, tu eres " . getRole(Auth::user()->type);
	     
	}));
	 
	//http://localhost/roles_users_laravel/public/home/new_post
	//sólo pueden acceder usuarios con role_id 2 y 3
	Route::get('resp',array("before" => "roles:03-09,resp", function()
	{
	 
	 	return "Como mínimo tu role debe ser responsable, tu eres " . getRole(Auth::user()->type);
	     
	}));
	 
	//http://localhost/roles_users_laravel/public/home/show_reply
	//sólo pueden acceder usuarios con role_id 1, 2 y 3
	Route::get('docente',array("before" => "roles:02-03-09,docente", function()
	{
	 
 		return "Como mínimo tu role debe ser docente, tu eres " . getRole(Auth::user()->type);
	     
	}));

	//http://localhost/roles_users_laravel/public/home
	//si ha iniciado sesión puede acceder, cualquier role
	Route::get('/', function()
	{
	 
	 	return "Si estás logueado ya puedes acceder aquí, tu eres " . getRole(Auth::user()->type);
	     
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