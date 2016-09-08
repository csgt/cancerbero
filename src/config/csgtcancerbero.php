<?php
return array(

	'modulos' => [
		'tabla'          => 'authmodulos',
		'id'             => 'moduloid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'nombrefriendly'
	],

	'permisos' => [
		'tabla'          => 'authpermisos',
		'id'             => 'permisoid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'nombrefriendly'
	],

	'roles' => [
		'tabla'          => 'authroles',
		'id'             => 'rolid',
		'nombre'         => 'nombre',
		'nombrefriendly' => 'descripcion'
	],

	'rolidusuarios' => 'rolid',

	'modulopermisos' => [
		'tabla'     => 'authmodulopermisos',
		'id'        => 'modulopermisoid',
		'moduloid'  => 'moduloid',
		'permisoid' => 'permisoid'
	],

	'rolmodulopermisos' => [
		'tabla'           => 'authrolmodulopermisos',
		'id'              => 'rolmodulopermisoid',
		'modulopermisoid' => 'modulopermisoid',
		'rolid'           => 'rolid'
	],
	
	'rolbackdoor' => 1,
	
	'mensajemodulopermisoexitoso'    => 'Se han actualizado los permisos para los m&oacute;dulos exitosamente.',
	
	'mensajerolmodulopermisoexitoso' => 'Se han actualizado los permisos para el rol exitosamente.',
	
	'mensajerolinvalido' 						 => 'Rol inválido.',

	'rutalogin'                      => 'login',
	
	'rutaroles'                      => 'roles', 
	
	'errorenrutas'                   => 'Se ha producido un error con tus rutas. &iquest;Todas tus rutas tienen nombre?',
	
	'accesodenegado'                 => 'No tienes permisos para ejecutar esta acci&oacute;n. Favor contactar al administrador.',
	
	'idencriptado'                   => true,

	'usuarioroles' => [
		'tabla'     => 'authusuarioroles',
		'id'        => 'usuariorolid',
		'usuarioid' => 'usuarioid',
		'rolid'     => 'rolid'
	],
	
	'template' => 'layouts.app',

	/*
	|--------------------------------------------------------------------------
	| Route extras
	|--------------------------------------------------------------------------
	|
	| Esta informacion se le agrega a las rutas predefinidas
	| Se agregan middlewares o cualquier otra configuracion en el route group
	| 'routeextras' => ['middleware'=>'subdomain.setup', 'domain' => '{cliente}.dominio.localdev']
	|
	*/
	'routeextras' => [],
);