<?php

Route::group(['before' => ['auth']], function () {
    Route::get('cancerbero/modulopermisos', 'Csgt\Cancerbero\cancerberoController@index');
    Route::post('cancerbero/modulopermisos', 'Csgt\Cancerbero\cancerberoController@store');
    Route::get('cancerbero/asignar/{id}', 'Csgt\Cancerbero\cancerberoController@asignar');
    Route::post('cancerbero/asignar', 'Csgt\Cancerbero\cancerberoController@asignarstore');
});
