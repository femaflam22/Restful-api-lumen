<?php

namespace App\Repositories\Contracts;

interface ICategoryRepository extends IGenericRepository
{
    public function findBook($id, $page, $limit, $order, $sort, $filter, $field);
    public function findBookAll($id, $order, $sort, $filter, $field);
    public function categoryCreate(array $data);
    public function categoryUpdate(array $data, $id);
    public function categoryDelete($id);
}
