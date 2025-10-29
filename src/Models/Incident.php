<?php

namespace Dpb\Package\Incidents\Models;

use Dpb\Extension\ModelState\Traits\HasStateHistory;
use Dpb\Package\Incidents\States\IncidentState;
use Dpb\Package\Incidents\Models\IncidentType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStates\HasStates;
use Spatie\ModelStates\HasStatesContract;

class Incident extends Model implements HasStatesContract
{
    use SoftDeletes;
    use HasStates;
    use HasStateHistory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date',
        'state',
        'type_id',
        'description'
    ];

    public function __construct(array $attributes = [])
    {
        // Dynamically resolve state class from config (falls back to default)
        $this->casts['date'] = 'date';
        $this->casts['state'] = config(
            'pkg-incidents.classes.incident_state_class',
            IncidentState::class // package default
        );

        parent::__construct($attributes);
    }

    public function getTable()
    {
        return config('pkg-incidents.table_prefix') . 'incidents';
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(IncidentType::class, "type_id");
    }

    public function scopeByType(Builder $query, string|array $type)
    {
        // cast input to array
        $type = is_array($type) ? $type : [$type];

        $query->whereHas('type', function ($q) use ($type) {
            $q->whereIn('code', $type);
        });
    }    
}
