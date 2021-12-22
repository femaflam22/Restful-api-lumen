<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Category extends Model
{
    use Filterable;
    protected $table = 'categories';
    protected $fillable = ['name'];
    // public $timestamps = true;
    protected $defaultSort = 'asc';

    public function getSortDirection()
    {
        return $this->defaultSort;
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
