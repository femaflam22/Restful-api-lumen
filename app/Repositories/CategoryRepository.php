<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\ICategoryRepository;

class CategoryRepository extends GenericRepository implements ICategoryRepository
{
    public function __construct()
    {
        parent::__construct(app(Category::class));
    }

    public function findBook($id, $page, $limit, $order = null, $sort = null, $filter = null, $field = [])
    {
        $orderBy = $order ? $order : $this->model->getKeyName();
        $sortBy = $sort ? $sort : $this->model->getSortDirection();

        $data = [
            'name' =>  $filter,
            'field' => $field
        ];

        return $this->model->find($id)->books()
            ->filter($data)->orderBy($orderBy, $sortBy)
            ->offset(($page - 1) * $page)->limit($limit)
            ->paginate($limit);
    }

    public function findBookAll($id, $order = null, $sort = null, $filter = null, $field = [])
    {
        $orderBy = $order ? $order : $this->model->getKeyName();
        $sortBy = $sort ? $sort : $this->model->getSortDirection();

        $data = [
            'name' =>  $filter,
            'field' =>  $field
        ];

        return $this->model
            ->find($id)->books()
            ->filter($data)
            ->orderBy($orderBy, $sortBy)
            ->get();
    }

    public function categoryCreate(array $data)
    {
        return $this->model->create($data);
    }

    public function categoryUpdate(array $data, $id)
    {
        try {
            $category = $this->model->findOrFail($id);

            $category->update($data);
            return $category;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function categoryDelete($id)
    {
        $category = $this->model->findOrFail($id);

        $category->delete();
        return "Delete Successfull";
    }
}
