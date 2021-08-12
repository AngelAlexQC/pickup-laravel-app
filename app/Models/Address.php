<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'meta',
        'waypoint_road_id',
    ];

    protected $searchableFields = ['*'];

    public function road()
    {
        return $this->belongsTo(Road::class, 'waypoint_road_id');
    }

    public function start_address_of()
    {
        return $this->hasMany(Road::class, 'address_start_id');
    }

    public function end_address_of()
    {
        return $this->hasMany(Road::class, 'address_end_id');
    }
}
