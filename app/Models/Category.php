<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'parent_category_id',
        'name',
        'slug',
        'description',
        'meta',
        'file',
    ];

    protected $searchableFields = ['*'];

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function childrem_categories()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function items()
    {
        return $this->morphedByMany(Item::class, 'categoryable');
    }
}
