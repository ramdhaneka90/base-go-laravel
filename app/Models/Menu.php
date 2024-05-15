<?php

namespace App\Models;

use App\Bases\BaseModel;

class Menu extends BaseModel
{
    protected $table = 'menus'; // Table name
    protected $keyType = 'string';

    /*
     * Defining Fillable Attributes On A Model
     */
    protected $fillable = [
        'id',
        'name',
        'code',
        'custom_url',
        'url',
        'icon',
        'description',
        'category',
        'parent_id',
        'sequence',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'menu_has_permissions', 'menu_id', 'permission_id')
            ->withPivot('name', 'sequence');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_visibilities', 'menu_id', 'role_id');
    }
}
