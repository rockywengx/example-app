<?php

namespace App\Basic\Models\Traits;

use Illuminate\Support\Facades\DB;

trait RecursiveHelper
{

    public function recursiveFilter(array $col, string $table, array $param = [], array $relationships = null): array
    {
        $filterBuilder = function ($param, &$queryString, &$queryParam) use ($table) {
            foreach ($param as $col => $value) {
                if (is_null($value)) {
                    $queryString .= ' AND `' . $table . '`.`' . $col . '` IS NULL';
                } elseif (is_array($value)) {
                    if ($value) {
                        $queryString .= ' AND `' . $table . '`.`' . $col . '` IN (' . implode(', ', array_fill(0, count($value), '?')) . ')';
                        $queryParam = array_merge($queryParam, $value);
                    } else {
                        $queryString .= ' AND `' . $table . '`.`' . $col . '` != `' . $table . '`.`' . $col . '`';
                    }
                } else {
                    $queryString .= ' AND `' . $table . '`.`' . $col . '` = ?';
                    $queryParam[] = $value;
                }
            }
        };

        $colString = '`' . implode('`,`', $col) . '`';
        $colAliasString = '`' . implode('`,`', array_map(function ($a) use ($table) {
            return $table . '`.`' . $a;
        }, $col)) . '`';

        $relationshipString = '';
        $queryString = '';
        $queryParam = [];
        $relationshipAppendString = '';
        $relationshipAppendParam = [];

        if (!isset($relationships)) {
            $relationships = ['query' => '', 'reverse' => false, 'append' => []];
        }

        $relationships = array_merge(['query' => '', 'reverse' => false, 'append' => []], $relationships);

        if ($relationships['query']) {
            $relationshipString = $relationships['query'];
        } else {
            $relationshipString = $relationships['reverse'] ? ('`cte`.`parent_id` = `' . $table . '`.`id`') : ('`cte`.`id` = `' . $table . '`.`parent_id`');
        }

        $filterBuilder($param, $queryString, $queryParam);

        $filterBuilder($relationships['append'], $relationshipAppendString, $relationshipAppendParam);

        // TODO 需要解決 SQL Injection rate
        $query = '
        WITH RECURSIVE `cte` (' . $colString . ') AS (
            SELECT ' . $colAliasString . '
            FROM `' . $table . '`
            WHERE 1' . $queryString . '
            UNION
            SELECT ' . $colAliasString . '
            FROM `' . $table . '`
                INNER JOIN `cte` ON ' . $relationshipString . $relationshipAppendString . '
        )
        SELECT ' . $colString . '
        FROM `cte`
        ';
        return DB::select($query, array_merge($queryParam, $relationshipAppendParam));
    }
}
