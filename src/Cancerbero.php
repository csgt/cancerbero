<?php
namespace Csgt\Cancerbero;

use Auth;
use App\Models\Auth\RoleModulePermission;

class Cancerbero
{

    public static function can($aRouteName)
    {
        $roleIds    = Auth::user()->roleIds();
        $routeArray = collect(explode('.', $aRouteName));

        $permissionName = $routeArray->last();

        $moduleName = implode('.', $routeArray->take($routeArray->count() - 1)->toArray());

        $roleModulePermission = RoleModulePermission::select('id')
            ->whereHas('role', function ($query) use ($roleIds) {
                $query->whereIn('id', $roleIds);
            })
            ->whereHas('module_permission.module', function ($query) use ($moduleName) {
                $query->where('name', $moduleName);
            })
            ->whereHas('module_permission.permission', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })
            ->first();

        return ($roleModulePermission ? true : false);

    }

    public static function crudPermissions($aModule)
    {
        $permissions = collect(['create', 'update', 'destroy']);

        return $permissions->mapWithKeys(function ($permission) use ($aModule) {
            return [$permission => self::can($aModule . '.' . $permission)];
        });
    }

    public static function isGod()
    {
        if (Auth::check()) {
            $rolbackdoor  = self::godRole();
            $usuarioroles = Auth::user()->roleIds();

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
