<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use App\Bases\BaseModel;

class Activity extends BaseModel
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'position_id',
        'area_id',
        'date_report',
        'time_report',
        'time_report_last',
        'subject',
    ];

    /**
     * Custom attribute
     *
     * @return void
     */
    public function getDateReportAttribute($value)
    {
        return $this->attributes['date_report'] = Carbon::parse($value)->format('d-m-Y');
    }

    /**
     * Custom attribute
     *
     * @return void
     */
    public function getTimeReportAttribute($value)
    {
        return $this->attributes['time_report'] = generateTime($value);
    }

    /**
     * Custom attribute
     *
     * @return void
     */
    public function getTimeReportLastAttribute($value)
    {
        return $this->attributes['time_report_last'] = (!empty($value) ? generateTime($value) : null);
    }

    /**
     * Relationship to activity attaches table
     *
     * @var collection
     */
    public function attaches()
    {
        return $this->hasMany(ActivityAttach::class, 'activity_id', 'id');
    }

    /**
     * Relationship to user table
     *
     * @var collection
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship to position table
     *
     * @var collection
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    /**
     * Relationship to area table
     *
     * @var collection
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
