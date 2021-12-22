<?php
namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\IBookRepository;

class BookRepository extends GenericRepository implements IBookRepository
{
    public function __construct()
    {
        parent::__construct(app(Book::class));
    }

    public function bookCreate(array $data)
    {
        if($data['cover']){
            $image = $data['cover'];
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $data['cover'] = url('storage/images/'.$imageName);
        }

        return $this->model->create($data);
    }

    public function bookUpdate(array $data, $id)
    {
        try {
            $book = $this->model->findOrFail($id);

            if ($data['cover']) {
                $image = $data['cover'];
                $imageName = $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $data['cover'] = url('storage/images/' . $imageName);
            }

            $book->update($data);
            return $book;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function bookDelete($id)
    {
        $book = $this->model->findOrFail($id);

        $book->delete();
        return "Delete Successfull";
    }
}