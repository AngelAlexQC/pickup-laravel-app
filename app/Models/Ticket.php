<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'vehicle_id',
        'name',
        'description',
        'meta',
        'price',
        'datetime_start',
        'datetime_end',
        'sender_id',
        'reciever_id',
        'driver_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'datetime_start' => 'datetime',
        'datetime_end' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'track_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function roads()
    {
        return $this->belongsToMany(Road::class, 'road_tracks', 'tracks_id');
    }

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }
}
