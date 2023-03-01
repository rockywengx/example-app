<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Entities\Book;

class BookRepositories extends Model
{
    protected $book;

    public function __construct()
    {
        $this->book = new Book();
    }
    
    public function get()
    {
        return $this->book->get();
    }

    
    public function getById($id)
    {
        return $this->book->where('id', $id)->get();
    }

    public function getByName($name)
    {
        return $this->book->where('name', $name)->get();
    }

    public function create($data){
        return $this->book->create($data);
    }
    
    public function updateById($data){
        return $this->book->where('id', $data['id'])->update($data);
    }

    public function deleteById($data){
        return $this->book->where('id', $data['id'])->delete();
    }
}

