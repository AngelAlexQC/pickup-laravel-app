<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'owner_id',
        'meta',
    ];

    protected $searchableFields = ['*'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function member()
    {
        return $this->belongsToMany(User::class, 'team_member');
    }
}
