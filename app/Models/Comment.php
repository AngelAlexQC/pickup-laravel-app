<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'description', 'file'];

    protected $searchableFields = ['*'];

    public function items()
    {
        return $this->morphedByMany(Item::class, 'commentable');
    }

    public function tickets()
    {
        return $this->morphedByMany(Ticket::class, 'commentable');
    }
}
