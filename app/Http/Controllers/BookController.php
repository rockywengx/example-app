<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookServices;

class BookController extends Controller
{
    protected $bookServices;

    public function __construct(
        BookServices $BookServices,
    ) {
        $this->bookServices = $BookServices;
    }


    public function get(){
        return $this->bookServices->get();
    }

    public function getById(Request $request, string $id){
        return $this->bookServices->getById($id);
    }

    public function new(Request $request)
    {    
        return $this->bookServices->insert($request);
    }

    public function edit(Request $request)
    {
        return $this->bookServices->update($request);    
      
    }

    public function delete(Request $request)
    {
        return $this->bookServices->delete($request);    
    }
}

