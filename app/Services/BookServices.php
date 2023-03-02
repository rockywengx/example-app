<?php

namespace App\Services;

use App\Models\Repositories\BookRepositories;
use Illuminate\Http\Request;
use Exception;

class BookServices
{
    protected $bookRepositories;

    public function __construct(BookRepositories $BookRepositories)
    {
        $this->bookRepositories = $BookRepositories;
    }
    public function get()
    {
        $data = $this->bookRepositories->get();
        if(!isset($data)){
            return response()->json([
                'success' => false,
                'msg' => '查無資料',
            ]);
        }
 
        return response()->json([
            'success' => true,
            'msg' => $data,
        ]);
    }
    
    public function getById($id)
    {
        $data = $this->bookRepositories->getById($id);
        if(!isset($data)){
            return response()->json([
                'success' => false,
                'msg' => '無此筆資料',
            ]);
        }
 
        return response()->json([
            'success' => true,
            'msg' => $data,
        ]);
    }

    public function getByName($name)
    {
        return $this->bookRepositories->where('name', $name)->get();
    }

    public function insert(Request $request){
        try
        {
            if(!$this->checkRequired($request)){
                return response()->json([
                    'success' => false,
                    'msg' => '資料不全',
                ]);
            };
    
            $error = $this->validation($request);
            if(
                isset($error)
            ){
                return response()->json([
                    'success' => false,
                    'msg' => $error,
                ]);
            }

            $post = [
                'name' => $request->data['name'],
                'another' => $request->data['another'],
                'price' => $request->data['price'],
            ];
    
            $data = $this->bookRepositories->create($post);

            return response()->json([
                'success' => true,
                'msg' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }   
    }
    
    public function update(Request $request)
    {
        try
        {
            if(!$this->checkKey($request)){
                return response()->json([
                    'success' => false,
                    'msg' => '索引不可為空',
                ]);
            };

            if(!$this->checkRequired($request)){
                return response()->json([
                    'success' => false,
                    'msg' => '資料不全',
                ]);
            };
    
            $error = $this->validation($request);
            if(
                isset($error)
            ){
                return response()->json([
                    'success' => false,
                    'msg' => $error,
                ]);
            };

            $put = [
                'id' => $request->data['id'],
                'name' => $request->data['name'],
                'another' => $request->data['another'],
                'price' => $request->data['price'],
            ];
    
            $data = $this->bookRepositories->updateById($put);

            return response()->json([
                'success' => true,
                'msg' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public function delete(Request $request){
        try
        {
            if(!$this->checkKey($request)){
                return response()->json([
                    'success' => false,
                    'msg' => '索引不可為空',
                ]);
            };

            if(!$this->checkRequired($request)){
                return response()->json([
                    'success' => false,
                    'msg' => '資料不全',
                ]);
            };
    
            $error = $this->validation($request);
            if(
                isset($error)
            ){
                return response()->json([
                    'success' => false,
                    'msg' => $error,
                ]);
            }

            // $post = [
            //     'id' => $request->data['id'],
            //     'name' => $request->data['name'],
            //     'another' => $request->data['another'],
            //     'price' => $request->data['price'],
            // ];
    
            $data = $this->bookRepositories->deleteById($request->data['id']);

            return response()->json([
                'success' => true,
                'msg' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ]);
        }
    }
    
    function checkRequired(Request $request)
    {
        if (
            !isset($request->data['name'])
            || !isset($request->data['another'])
            || !isset($request->data['price'])
        ) {
            return false;
        };
        return true;
    }

    public function validation(Request $request)
    {
        if (
            $request->data['price'] <= 0
        ) {
            return "價錢錯誤";
        };

        // if(!$this->checkKey($request)){
        //     $thisId = $request->data['id'];
        // } else {
        //     $thisId = -999;
        // }

        // $someNameCases = $this->bookRepositories->getByName($request->data['name']);
        // if(
        //     array_search($thisId, array_column($someNameCases, 'id'))
        // ){
        //     return "已擁有相同書名";
        // };

    }

    function checkKey(Request $request)
    {
        if (
            !isset($request->data['id'])
        ) {
            return false;
        };
        return true;
    }

}

