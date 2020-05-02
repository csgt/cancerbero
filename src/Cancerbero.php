<?php
namespace Csgt\Cancerbero;

use Auth;
use App\Models\Auth\Permission;
use App\Models\Auth\RoleModulePermission;

class Cancerbero
{

    public static function can($aRouteName)
    {
        if (Auth::guest()) {
            return false;
        }

        $roleIds    = Auth::user()->roleIds();
        $routeArray = collect(explode('.', $aRouteName));

        $permissionName = $routeArray->last();

        $p = Permission::where('name', $permissionName)->first();
        if (!$p) {
            return false;
        }

        $ps = Permission::where('id', $p->id)->orWhere('id', $p->parent_id)->pluck('id');

        $moduleName = implode('.', $routeArray->take($routeArray->count() - 1)->toArray());

        $roleModulePermission = RoleModulePermission::select('id')
            ->whereHas('role', function ($query) use ($roleIds) {
                $query->whereIn('id', $roleIds);
            })
            ->whereHas('module_permission.module', function ($query) use ($moduleName) {
                $query->where('name', $moduleName);
            })
            ->whereHas('module_permission.permission', function ($query) use ($ps) {
                $query->whereIn('id', $ps);
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
