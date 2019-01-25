<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
