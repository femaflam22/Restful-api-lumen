<?php

namespace App\Models\ModelFilters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter
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
    
    public function name($name)
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    public function field($fields)
    {
        return $this->select($fields);
    }
}
