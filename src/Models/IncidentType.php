<?php

namespace Dpb\Package\Incidents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'title',
    ];

    public function getTable()
    {
        return config('pkg-incidents.table_prefix') . 'incident_types';
    }   
}
