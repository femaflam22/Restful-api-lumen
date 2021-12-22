<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookPatchRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'category_id' => 'required',
            'title' => 'required|max:100',
            'author' => 'required|max:200',
            'publisher' => 'required|max:100',
            'cover' => 'mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:5000'
        ]);

        if ($validator->fails())
            throw new ValidationException($validator, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->category_id = property_exists($object, 'category_id') ? $object->category_id : null;
        $this->title = property_exists($object, 'title') ? $object->title : null;
        $this->author = property_exists($object, 'author') ? $object->author : null;
        $this->publisher = property_exists($object, 'publisher') ? $object->publisher : null;
        $this->cover = property_exists($object, 'cover') ? $object->cover : null;
    }

    public function parse()
    {
        $result = array(
            'category_id' => $this->category_id,
            'title' => $this->title,
            'author' => $this->author,
            'publisher' => $this->publisher,
            'cover' => $this->cover
        );

        return $result;
    }
}
