<?php
Route::get('/', function(){
	return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

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

		Route::resource('datausers','DataUsersController');

		Route::resource('dhoras','DhorasController');
		Route::resource('dcursos','DcursosController');

});


Route::group(['middleware'=>['web']], function(){
	Route::auth();

	Route::get('/home', 'HomeController@index');
});

Route::get('auth/logout',[
	'uses'	=>	'Auth\AuthController@getLogout',
	'as'	=>	'auth.logout'
	]);


?>
