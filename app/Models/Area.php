<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Bases\BaseModel;

class Area extends BaseModel
{
    use SoftDeletes;

    protected $table = 'areas'; // Table name
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_id',
        'name',
        'latitude',
        'longitude',
    ];

    /**
     * Relationship to region table
     *
     * @var collection
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    /**
     * Relationship to shift table
     *
     * @var collection
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'area_positions', 'area_id', 'position_id', 'id', 'id');
    }

    /**
     * Relationship to shift table
     *
     * @var collection
     */
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_areas', 'area_id', 'shift_id', 'id', 'id');
    }
}
