<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as Model;

use App\Traits\ModelScopes;

class LogActivity extends Model
{
    use ModelScopes;

    protected $table = 'activity_log'; // Table name
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }
}
