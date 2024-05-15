<?php

namespace App\Bases;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelScopes;
use Carbon\Carbon;

class BaseModel extends Model
{
    use ModelScopes;

    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Custom attribute
     *
     * @return void
     */
    public function getCreatedAtAttribute($value)
    {
        return $this->attributes['created_at'] = Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    /**
     * Custom attribute
     *
     * @return void
     */
    public function getUpdatedAtAttribute($value)
    {
        return $this->attributes['updated_at'] = Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
