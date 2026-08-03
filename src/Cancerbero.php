<?php
namespace Csgt\Cancerbero;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class Cancerbero
{
    public static function can($aRuta)
    {
        return self::tienePermisos($aRuta, false, false);

    }

    public static function tienePermisos($aRuta, $aRedirect = true, $aJson = true)
    {

        if (Auth::guest()) {
            if ($aRedirect) {
                return Redirect::guest(config('csgtcancerbero.rutalogin'));
            } else {
                return null;
            }

        }

        $arr     = explode('.', $aRuta);
        $modulo  = 'index';
        $permiso = 'index';

        if (count($arr) >= 2) {
            $permiso = $arr[count($arr) - 1];
            array_pop($arr);
            $modulo = implode('.', $arr);
        } elseif (count($arr) == 1) {
            $modulo = $arr[0];
        }

        if ($modulo == '') {
            $response['error']  = config('csgtcancerbero.errorenrutas');
            $response['acceso'] = false;

            return Response::json($response);
        }

        $modulostbl   = config('csgtcancerbero.modulos.tabla');
        $permisostbl  = config('csgtcancerbero.permisos.tabla');
        $mptabl       = config('csgtcancerbero.modulopermisos.tabla');
        $modulospk    = config('csgtcancerbero.modulos.id');
        $permisospk   = config('csgtcancerbero.permisos.id');
        $modulosname  = config('csgtcancerbero.modulos.nombre');
        $permisosname = config('csgtcancerbero.permisos.nombre');
        $mppk         = config('csgtcancerbero.modulopermisos.id');
        $rmppk        = config('csgtcancerbero.rolmodulopermisos.id');
        $colrolid     = config('csgtcancerbero.rolidusuarios');
        $urtabla      = config('csgtcancerbero.usuarioroles.tabla');
        $urusuario    = config('csgtcancerbero.usuarioroles.usuarioid');
        $urrol        = config('csgtcancerbero.usuarioroles.rolid');

        $usuarioroles = [];
        if (config('csgtcancerbero.multiplesroles') == true) {
            $usuarioroles = self::getUserRoles($urtabla, $urusuario, $urrol);
        } else {
            $usuarioroles[] = Auth::user()->$colrolid;
        }

        foreach ($usuarioroles as $ur) {
            $rolmodulopermisoid = DB::table(config('csgtcancerbero.rolmodulopermisos.tabla') . ' AS rmp')
                ->leftJoin($mptabl . ' AS mp', 'mp.' . $mppk, '=', 'rmp.' . $mppk)
                ->leftJoin($modulostbl . ' AS m', 'm.' . $modulospk, '=', 'mp.' . $modulospk)
                ->leftJoin($permisostbl . ' AS p', 'p.' . $permisospk, '=', 'mp.' . $permisospk)
                ->where('m.' . $modulosname, $modulo)
                ->where('p.' . $permisosname, $permiso)
                ->where('rmp.' . $colrolid, $ur)
                ->value($rmppk);

            if ($rolmodulopermisoid != '') {
                if ($aJson) {
                    $response['error']  = '';
                    $response['acceso'] = true;

                    return Response::json($response);
                } else {
                    return true;
                }
            }
        }

        if ($aJson) {
            $response['error']  = config('csgtcancerbero.accesodenegado');
            $response['acceso'] = false;

            return Response::json($response);
        } else {
            return false;
        }
    }

    public static function tienePermisosCrud($aModulo)
    {
        $addjson = self::tienePermisos($aModulo . '.create', false);
        if ($addjson == null) {
            return Redirect::guest(config('csgtcancerbero.rutalogin'));
        }

        $add = $addjson->getData();
        $add = $add->acceso;

        $editjson = self::tienePermisos($aModulo . '.edit', false);
        if ($editjson == null) {
            return Redirect::guest(config('csgtcancerbero.rutalogin'));
        }

        $edit = $editjson->getData();
        $edit = $edit->acceso;

        $deletejson = self::tienePermisos($aModulo . '.destroy', false);
        if ($deletejson == null) {
            return Redirect::guest(config('csgtcancerbero.rutalogin'));
        }

        $delete = $deletejson->getData();
        $delete = $delete->acceso;

        return ['add' => $add, 'edit' => $edit, 'delete' => $delete];
    }

    public static function isGod()
    {
        if (Auth::check()) {
            $rolid       = config('csgtcancerbero.roles.id');
            $rolbackdoor = config('csgtcancerbero.rolbackdoor');

            if (config('csgtcancerbero.multiplesroles') === true) {

                $urtabla   = config('csgtcancerbero.usuarioroles.tabla');
                $urusuario = config('csgtcancerbero.usuarioroles.usuarioid');
                $urrol     = config('csgtcancerbero.usuarioroles.rolid');

                $usuarioroles = self::getUserRoles($urtabla, $urusuario, $urrol);
                if (in_array($rolbackdoor, $usuarioroles)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                if (Auth::user()->$rolid == $rolbackdoor) {
                    return true;
                } else {
                    return false;
                }

            }
        } else {
            return false;
        }

    }

    public static function getGodRol()
    {
        return config('csgtcancerbero.rolbackdoor');
    }

    /**
     * Obtiene los roles de un usuario como arreglo sin depender de lists() o pluck().
     *
     * lists() fue removido en Laravel moderno y pluck() no devuelve el mismo tipo en
     * todas las versiones soportadas. select() y get() mantienen este comportamiento
     * desde Laravel 5.5 hasta Laravel 11.
     *
     * @param string $tabla
     * @param string $columnaUsuario
     * @param string $columnaRol
     * @return array
     */
    private static function getUserRoles($tabla, $columnaUsuario, $columnaRol)
    {
        $roles = DB::table($tabla)
            ->where($columnaUsuario, Auth::id())
            ->select($columnaRol . ' as cancerbero_role_id')
            ->get();

        $resultado = [];
        foreach ($roles as $rol) {
            $resultado[] = $rol->cancerbero_role_id;
        }

        return $resultado;
    }
}
