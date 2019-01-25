<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = ['id'];

    public function role_module_permissions()
    {
        return $this->hasMany(RoleModulePermission::class, 'role_id', 'id');
    }
}
