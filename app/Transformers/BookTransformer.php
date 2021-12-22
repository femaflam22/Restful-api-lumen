<?php

namespace App\Transformers;

use App\Models\Book;
use League\Fractal\TransformerAbstract;
use App\Http\Responses\BookResponse;

class BookTransformer extends TransformerAbstract
{
    public function transform(Book $model)
    {
        $response = new BookResponse($model);

        return $response->serialize();
    }
}
