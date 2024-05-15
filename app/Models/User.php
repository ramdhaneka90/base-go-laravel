<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ModelScopes;

class User extends Authenticatable
{
    use HasApiTokens, ModelScopes, HasRoles, SoftDeletes;

    protected $table = 'users'; // Table name
    protected $keyType = 'string';
    public $incrementing = false;

    protected static $logFillable = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'type',
        'status',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Username for credentials login
     *
     * @var string
     */
    public function username()
    {
        return 'username';
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_has_roles', 'user_id', 'role_id')
            ->withPivot('model_type');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'user_areas', 'user_id', 'area_id', 'id', 'id');
    }
}
