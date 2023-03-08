<?php

namespace App\Library\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Summary of ServiceInterface
 */
interface ServiceInterface{
    function validateArray():array;
    function judgeArray():array;
    function show(): Collection;
    function find(int $id):array;
    /**
     * Summary of store
     * @param Request $data
     * @return array
     */
    function store(Request $data):array;
    function edit(int $id, Request $data):array;
    function remove(int $id):bool;
}
