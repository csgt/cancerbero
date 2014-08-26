<?php
return array(

	'modulos' => array(
		'tabla'          => 'authmodulos',
		'id'             => 'moduloid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'nombrefriendly',
		'descripcion'    => 'descripcion',
	),

	'permisos' => array(
		'tabla'          => 'authpermisos',
		'id'             => 'permisoid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'nombrefriendly' 
	),

	'roles' => array(
		'tabla'          => 'authroles',
		'id'             => 'rolid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'descripcion' 
	),

	'rolidusuarios' => 'rolid',

	'modulopermisos' => array(
		'tabla'     => 'authmodulopermisos',
		'id'        => 'modulopermisoid',
		'moduloid'  => 'moduloid',
		'permisoid' => 'permisoid' 
	),

	'rolmodulopermisos' => array(
		'tabla'           => 'authrolmodulopermisos',
		'id'              => 'rolmodulopermisoid',
		'modulopermisoid' => 'modulopermisoid',
		'rolid'           => 'rolid' 
	),

	'modulosocultos'  => array('cancerbero'),
	
	'permisosocultos' => array('asignar', 'guardarpermisos', 'modulopermisos', 'guardarmodulopermisos'),
	
	'rolbackdoor'     => 1,

	'mensajemodulopermisoexitoso' => 'Se han actualizado los permisos para los m&oacute;dulos exitosamente.',

	'rutalogin' => 'login', 

	'errorenrutas' => 'Se ha producido un error con tus rutas. &iquest;Todas tus rutas tienen nombre?',

	'accesodenegado' => 'No tienes permisos para ejecutar esta acci&oacute;n. Favor contactar al administrador.',

);