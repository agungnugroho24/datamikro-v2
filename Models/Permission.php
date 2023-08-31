<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    public $guarded = [];

    protected $parentColumn = 'parent';

    public function parent()
    {
        return $this->belongsTo(Permission::class, $this->parentColumn);
    }

    public function child()
    {
        return $this->hasMany(Permission::class, $this->parentColumn);
    }

    public function allChild()
    {
        return $this->children()->with('allChild');
    }
}
