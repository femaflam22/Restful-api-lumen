<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    use Filterable;
    protected $table = 'books';
    protected $fillable = ['category_id','title','author','publisher','cover'];
    // public $timestamps = true;
    protected $defaultSort = 'asc';

    public function getSortDirection()
    {
        return $this->defaultSort;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
