<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Bases\BaseModel;

class Division extends BaseModel
{
    use SoftDeletes;

    protected $table = 'division'; // Table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function position()
    {
        return $this->hasOne(Position::class, 'division_id', 'id');
    }
}
