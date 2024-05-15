<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use App\Traits\ModelScopes;

class Permission extends Model
{
    use ModelScopes;

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'guard_name', 'created_at', 'updated_at'
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_has_permissions', 'permission_id', 'menu_id');
    }
}
