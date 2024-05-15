<?php

namespace App\Models;

use App\Bases\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends BaseModel
{
    use SoftDeletes;

    protected $table = 'regions'; // Table name
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relationship to areas table
     *
     * @var collection
     */
    public function areas()
    {
        return $this->hasMany(Area::class, 'region_id', 'id');
    }
}
