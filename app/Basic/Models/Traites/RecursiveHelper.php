<?php

namespace App\Basic\Models\Traits;

use Illuminate\Support\Facades\DB;

trait RecursiveHelper
{
    public function recursiveFilter(array $columns, string $table, array $params = [], array $relationships = null): array
    {
        $filterBuilder = function ($params, &$queryString, &$queryParam) use ($table) {
            foreach ($params as $column => $value) {
                if (is_null($value)) {
                    $queryString .= ' AND `' . $table . '`.`' . $column . '` IS NULL';
                } elseif (is_array($value)) {
                    if (!empty($value)) {
                        $queryString .= ' AND `' . $table . '`.`' . $column . '` IN (' . implode(', ', array_fill(0, count($value), '?')) . ')';
                        $queryParam = array_merge($queryParam, $value);
                    } else {
                        $queryString .= ' AND `' . $table . '`.`' . $column . '` != `' . $table . '`.`' . $column . '`';
                    }
                } else {
                    $queryString .= ' AND `' . $table . '`.`' . $column . '` = ?';
                    $queryParam[] = $value;
                }
            }
        };

        $columnString = '`' . implode('`,`', $columns) . '`';
        $columnAliasString = '`' . implode('`,`', array_map(function ($alias) use ($table) {
            return $table . '`.`' . $alias;
        }, $columns)) . '`';

        $relationshipString = '';
        $queryString = '';
        $queryParam = [];
        $relationshipAppendString = '';
        $relationshipAppendParam = [];

        if ($relationships === null) {
            $relationships = ['query' => '', 'reverse' => false, 'append' => []];
        }

        $relationships = array_merge(['query' => '', 'reverse' => false, 'append' => []], $relationships);

        if ($relationships['query']) {
            $relationshipString = $relationships['query'];
        } else {
            $relationshipString = $relationships['reverse'] ? ('`cte`.`parent_id` = `' . $table . '`.`id`') : ('`cte`.`id` = `' . $table . '`.`parent_id`');
        }

        $filterBuilder($params, $queryString, $queryParam);

        $filterBuilder($relationships['append'], $relationshipAppendString, $relationshipAppendParam);

        // 使用參數綁定，防範 SQL 注入攻擊
        $query = <<<SQL
            WITH RECURSIVE `cte` ({$columnString}) AS (
                SELECT {$columnAliasString}
                FROM `{$table}`
                WHERE 1{$queryString}
                UNION
                SELECT {$columnAliasString}
                FROM `{$table}`
                    INNER JOIN `cte` ON {$relationshipString}{$relationshipAppendString}
            )
            SELECT {$columnString}
            FROM `cte`
        SQL;
        $params = array_merge($queryParam, $relationshipAppendParam);
        return DB::select($query, $params);
    }
}
