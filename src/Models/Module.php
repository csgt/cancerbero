<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function permissions()
    {
        return $this->belongsToMany(Permissions::class);
    }

    public function modulepermissions()
    {
        return $this->hasMany(ModulePermission::class);
    }
}
