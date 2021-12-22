<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\Contracts\ICategoryRepository;
use App\Http\Requests\CategoryPostRequest;
use App\Http\Requests\CategoryPatchRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\CategoryTransformer;
use App\Transformers\BookTransformer;

class CategoryController extends Controller
{
    private $repo;
    public function __construct(ICategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        try {
            $limit = request('limit');
            $field = request('field');
            $page = request('page', 1);
            $filter = request('filter');
            $order = request('order');
            $sort = request('sort', 'asc');

            if ($limit) {
                $data = $this->repo->get($page, $limit, $order, $sort, $filter, $field);
            } else {
                $data = $this->repo->getAll($order, $sort, $filter, $field);
            }

            if (count($data)) {
                $book = fractal($data, new CategoryTransformer())->toArray();
                return $this->buildResponses('success', 'categories', $book);
            } else {
                return $this->buildFailResponse('fail', 'Category Not Found');
            }
        } catch (\Exception $exception) {
            return $this->buildErrorResponse('error', 'Unable to communicate with database');
        }
    }

    public function show($id)
    {
        $category = $this->repo->find($id);
        if ($category) {
            $data = fractal($category, new CategoryTransformer())->toArray();
            return $this->buildResponse('success', $data);
        } else {
            return $this->buildFailResponse('fail', 'category not found');
        }
    }

    public function findBook($id)
    {
        try {
            $limit = request('limit');
            $field = request('field');
            $page = request('page', 1);
            $filter = request('filter');
            $order = request('order');
            $sort = request('sort', 'asc');

            if($limit){
                $data = $this->repo->findBook($id, $page, $limit, $order, $sort, $filter, $field);
            }else{
                $data = $this->repo->findBookAll($id, $order, $sort, $filter, $field);
            }
            if ($data) {
                $category = $this->repo->find($id);
                $book = fractal($data, new BookTransformer())->toArray();
                $relation = fractal($category, new CategoryTransformer())->toArray();

                return $this->buildRelationResponses('success', 'books', $book, 'category', $relation);
            } else {
                return $this->buildFailResponse('fail', 'Product Not Found');
            }
            
        } catch (\Exception $exception) {
            return $this->buildErrorResponse('error' , 'Unable to communicate with database');
        }
    }

    public function store(Request $request)
    {
        $validate = new CategoryPostRequest($request->all());
        $data = $validate->parse();
        $category = $this->repo->categoryCreate($data);
        return $this->buildResponse('success', $category);
    }

    public function update(Request $request, $id)
    {
        $validate = new CategoryPatchRequest($request->all());
        $data = $validate->parse();
        $category = $this->repo->categoryUpdate($data, $id);
        if ($category) {
            return $this->buildResponse('success', $category);
        } else {
            return $this->buildFailResponse('fail', 'category not found');
        }
    }

    public function destroy($id)
    {
        try {
            $this->repo->categoryDelete($id);

            return $this->buildResponse('success');
        } catch (ModelNotFoundException $exception) {
            return $this->buildFailResponse("fail", "No query result for " . $id);
        }
    }
}
