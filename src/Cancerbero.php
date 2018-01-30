<?php

namespace Csgt\Cancerbero;

use Auth;
use App\Models\Auth\Module;
use App\Models\Auth\Permission;
use App\Models\Auth\ModulePermission;
use App\Models\Auth\RoleModulePermission;

class Cancerbero
{

    public static function can($aRouteName)
    {
        $roleIds = Auth::user()->roleIds();
        $routeArray = collect(explode('.', $aRouteName));

        $permissionName = $routeArray->last();

        $moduleName = implode('.', $routeArray->take($routeArray->count() - 1)->toArray());

        $rolModulePermission = RoleModulePermission::leftJoin('module_permissions', 'module_permission_id', '=', 'id')
            ->leftJoin('roles', 'role_id', '=', 'id')
            ->leftJoin('modules', 'module_permissions.module_id', '=', 'id')
            ->leftJoin('permissions', 'module_permissions.permission_id', '=', 'id')
            ->whereIn('roles.id', $roleIds)
            ->where('modules.name', $moduleName)
            ->where('permission.name', $permissionName)
            ->first();

        return (!$rolModulePermission ? false : true);

    }

    public static function crudPermissions($aModule)
    {
        $permissions = collect(['add', 'edit', 'delete']);

        return $permissions->mapWithKeys(function($permission) use $aModule{
            return [$permission => self::can($aModule . '.' . $permission)];
        });
    }

    public static function isGod()
    {
        if (Auth::check()) {
            $rolbackdoor = self::godRole();
            $usuarioroles = Auth::user()->getRoles();

            return (in_array($rolbackdoor, $usuarioroles));
        } else {
            return false;
        }
    }

    public static function godRole()
    {
        return config('csgtcancerbero.backdoor_role');
    }
}
