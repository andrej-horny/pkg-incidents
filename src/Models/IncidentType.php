<?php

namespace Dpb\Package\Incidents\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'type_id');
    }

    /**
     * Summary of scopeByCode
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $code
     * @return void
     */
    public function scopeByCode(Builder $query, string|array $code)
    {
        // cast input to array
        $code = is_array($code) ? $code : [$code];

        $query->whereIn('code', $code);
    }     
}
