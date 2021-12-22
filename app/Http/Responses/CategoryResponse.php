<?php

namespace App\Http\Responses;

use Carbon\Carbon;

class CategoryResponse
{
    public function __construct($model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        // $this->books = $model->books;
    }

    public function includeBook($model)
    {
        $this->id = $model->id;
        $this->name = $model->name;
        $this->books = $model->books;
    }

    public function serialize()
    {
        return get_object_vars($this);
    }
}
