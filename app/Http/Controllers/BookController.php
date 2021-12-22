<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Repositories\Contracts\IBookRepository;
use App\Http\Requests\BookPostRequest;
use App\Http\Requests\BookPatchRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\BookTransformer;

class BookController extends Controller
{
    private $repo;
    public function __construct(IBookRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index($search = null)
    {
        try {
            $user = auth()->user();
            $user = json_decode(json_encode($user),true);
            
            $limit = request('limit');
            $field = request('field');
            $page = request('page', 1);
            $filter = request('filter');
            $order = request('order');
            $sort = request('sort', 'asc');
            if ($search) {
                $filter = $search;
            }

            if ($limit) {
                $data = $this->repo->get($page, $limit, $order, $sort, $filter, $field);
            } else {
                $data = $this->repo->getAll($order, $sort, $filter, $field);
            }

            if (count($data)) {
                $book = fractal($data, new BookTransformer())->toArray();
                return $this->buildResponses('success', 'books', $book);
            } else {
                return $this->buildFailResponse('fail', 'Book Not Found');
            }
        } catch (\Exception $exception) {
            return $this->buildErrorResponse('error', 'Unable to communicate with database');
        }
    }

    public function show($id)
    {
        $book = $this->repo->find($id);
        if ($book) {
            $data = fractal($book, new BookTransformer())->toArray();
            return $this->buildResponse('success', $data);
        } else {
            return $this->buildFailResponse('fail', 'book not found');
        }
    }

    public function store(Request $request)
    {
        $validate = new BookPostRequest($request->all());
        $data = $validate->parse();
        $book = $this->repo->bookCreate($data);
        return $this->buildResponse('success', $book);
        // return response()->json(dd($book));
    }

    public function update(Request $request, $id)
    {
        $validate = new BookPatchRequest($request->all());
        $data = $validate->parse();
        $book = $this->repo->bookUpdate($data, $id);
        if ($book) {
            return $this->buildResponse('success', $book);
        } else {
            return $this->buildFailResponse('fail', 'book not found');
        }
    }

    public function destroy($id)
    {
        try {
            $this->repo->bookDelete($id);

            return $this->buildResponse('success');
        } catch (ModelNotFoundException $exception) {
            return $this->buildFailResponse("fail", "No query result for " . $id);
        }
    }
}
