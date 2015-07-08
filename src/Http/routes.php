<?php

	Route::group(['middleware' => ['auth'], 'namespace' => 'Csgt\Cancerbero\Http\Controllers'], function() {
		Route::get ('cancerbero/asignar/{id}', 'cancerberoController@show');
		Route::post('cancerbero/asignar', 'cancerberoController@store');
	});