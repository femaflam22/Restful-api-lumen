<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CategoryPatchRequest
{
    public function __construct($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:100',
        ]);

        if ($validator->fails())
            throw new ValidationException($validator, $validator->errors());

        $this->map((object)$data);
    }

    private function map($object)
    {
        $this->name = property_exists($object, 'name') ? $object->name : null;
    }

    public function parse()
    {
        $result = array(
            'name' => $this->name,
        );

        return $result;
    }
}
