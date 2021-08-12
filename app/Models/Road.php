<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Road extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'address_start_id',
        'address_end_id',
        'meta',
        'price',
    ];

    protected $searchableFields = ['*'];

    public function waypoints()
    {
        return $this->hasMany(Address::class, 'waypoint_road_id');
    }

    public function address_start()
    {
        return $this->belongsTo(Address::class, 'address_start_id');
    }

    public function address_end()
    {
        return $this->belongsTo(Address::class, 'address_end_id');
    }

    public function allTracks()
    {
        return $this->belongsToMany(Ticket::class, 'road_tracks', 'tracks_id');
    }
}
