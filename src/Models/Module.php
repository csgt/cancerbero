<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $timestamps    = false;
    protected $primaryKey = 'name';
    public $incrementing  = false;

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class);
    }

    public function modulepermissions()
    {
        return $this->hasMany(ModulePermission::class);
    }
}
