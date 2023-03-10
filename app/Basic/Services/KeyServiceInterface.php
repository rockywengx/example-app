<?php

namespace App\Basic\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Summary of MultiKeyServiceInterface
 */
interface KeyServiceInterface
{
    function validateArray(): array;
    function judgeArray(): array;
    /**
     * Summary of show
     * @return LengthAwarePaginator
     */
    function show(): LengthAwarePaginator;
    function find(array $keyValues): array;
    /**
     * Summary of store
     * @param Request $data
     * @return array
     */
    function store(Request $data): array;
    function edit(array $keyValues, Request $data): array;
    function remove(array $keyValues): bool;
}
