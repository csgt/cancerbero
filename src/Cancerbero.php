<?php
namespace Csgt\Cancerbero;

use Auth;
use App\Models\RoleModulePermission;

class Cancerbero
{

    public static function can($aRouteName)
    {
        if (Auth::guest()) {
            return false;
        }

        $roleIds              = Auth::user()->roleIds();
        $roleModulePermission = RoleModulePermission::query()
            ->whereIn('role_id', $roleIds)
            ->where('module_permission', $aRouteName)
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
