<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Repositories\BookRepositories;

class BookController extends Controller
{
    protected $bookRepositories;

    public function __construct(
        BookRepositories $BookRepositories,
    ) {
        $this->bookRepositories = $BookRepositories;
    }


    public function get(){
        $data = $this->bookRepositories->get();
        if(isset($data)){
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

    public function getById(Request $request){
        $data = $this->bookRepositories->getById($request->id);
        if(isset($data)){
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


    public function new(Request $request){
        
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

    public function edit(Request $request){
        
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

            $post = [
                'id' => $request->data['id'],
                'name' => $request->data['name'],
                'another' => $request->data['another'],
                'price' => $request->data['price'],
            ];
    
            $data = $this->bookRepositories->update($post);

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

    public function deleteById(Request $request){
        
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

