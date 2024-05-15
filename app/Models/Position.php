<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Bases\BaseModel;

class Position extends BaseModel
{
    use SoftDeletes;

    protected $table = 'position'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function shifts()
    {
        // ON PROGRESS
        return $this->belongsToMany(Shift::class, 'position_shifts');
    }
}
