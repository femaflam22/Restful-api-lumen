<?php

namespace App\Http\Responses;

use Carbon\Carbon;

class BookResponse
{
    public function __construct($model)
    {
        $this->id = $model->id;
        $this->category_id = $model->category_id;
        $this->title = $model->title;
        $this->author = $model->author;
        $this->publisher = $model->publisher;
        $this->cover = $model->cover; 
    }

    public function serialize()
    {
        return get_object_vars($this);
    }
}
