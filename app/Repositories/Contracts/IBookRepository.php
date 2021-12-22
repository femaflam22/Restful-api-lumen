<?php

namespace App\Repositories\Contracts;

interface IBookRepository extends IGenericRepository
{
    public function bookCreate(array $data);
    public function bookUpdate(array $data, $id);
    public function bookDelete($id);
}
