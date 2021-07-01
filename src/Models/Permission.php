<?php
namespace Csgt\Cancerbero\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps    = false;
    protected $primaryKey = 'name';
    public $incrementing  = false;

    public function parent()
    {
        return $this->hasOne(self::class, 'parent');
    }
}
