<?php

	$routedata = ['namespace' => 'Csgt\Cancerbero\Http\Controllers', 'middleware'=>['auth']];
	if(config('csgtcancerbero.routeextras')) {
		$routedata = array_merge($routedata, config('csgtlogin.routeextras',[]));
	}

	Route::group($routedata, function() {
		Route::get ('cancerbero/asignar/{id}', 'cancerberoController@show');
		Route::post('cancerbero/asignar', 'cancerberoController@store');
	});