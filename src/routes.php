<?php

	Route::group(array('before' => array('auth')), function() {
		Route::get ('cancerbero/modulopermisos', 'Csgt\Cancerbero\cancerberoController@index');
		Route::post('cancerbero/modulopermisos', 'Csgt\Cancerbero\cancerberoController@store');
	});