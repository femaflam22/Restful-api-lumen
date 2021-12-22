<?php

namespace App\Models\ModelFilters;

use EloquentFilter\ModelFilter;

class BookFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function id($id)
    {
        return $this->find($id);
    }

    public function name($title)
    {
        return $this->where('title', 'like', '%' . $title . '%');
    }

    public function field($fields)
    {
        return $this->select($fields);
    }
}
