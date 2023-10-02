<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    public $timestamps    = false;
    protected $primaryKey = 'name';
    public $incrementing  = false;
    protected $appends    = ['module', 'permission'];

    public function getModuleAttribute()
    {
        $arr = explode('.', $this->name);
        array_pop($arr);

        return implode('.', $arr);
    }

    public function getPermissionAttribute()
    {
        $arr        = explode('.', $this->name);
        $permission = array_pop($arr);

        return $permission;
    }
}
