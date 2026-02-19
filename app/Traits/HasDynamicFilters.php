<?php

namespace App\Traits;

trait HasDynamicFilters
{
    /**
     * Apply dynamic filters to query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @param array $filterOperators
     * @param array $allowedColumns - Direct columns allowed for filtering
     * @param array $allowedRelations - Relations allowed for filtering
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyDynamicFilters($query, $filters = [], $filterOperators = [], $allowedColumns = [], $allowedRelations = [])
    {
        foreach ($filters as $key => $value) {
            if (empty($value) && $value !== '0' && $value !== 0) {
                continue;
            }

            // Get operator (default: = for strings)
            $operator = $filterOperators[$key] ?? '=';
            
            // Check if it's a relation filter (contains dot)
            if (strpos($key, '.') !== false) {
                $parts = explode('.', $key);
                $column = array_pop($parts);        // ambil kolom terakhir
                $relation = implode('.', $parts);   // sisanya adalah relasi
                
                // Check if relation is allowed
                if (in_array($relation, $allowedRelations)) {
                    $query->whereHas($relation, function($q) use ($column, $operator, $value) {
                        $this->applyFilterCondition($q, $column, $operator, $value);
                    });
                }
            } else {
                // Direct column filter - check if allowed
                if (in_array($key, $allowedColumns)) {
                    $this->applyFilterCondition($query, $key, $operator, $value);
                }
            }
        }

        return $query;
    }

    /**
     * Apply filter condition based on operator
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param string $operator
     * @param mixed $value
     */
    protected function applyFilterCondition($query, $column, $operator, $value)
    {
        switch (strtolower($operator)) {
            case 'like':
                $query->where($column, 'LIKE', "%{$value}%");
                break;
            case 'equals':
            case '=':
                $query->where($column, '=', $value);
                break;
            case 'not_equals':
            case '!=':
                $query->where($column, '!=', $value);
                break;
            case 'greater_than':
            case '>':
                $query->where($column, '>', $value);
                break;
            case 'greater_than_equal':
            case '>=':
                $query->where($column, '>=', $value);
                break;
            case 'less_than':
            case '<':
                $query->where($column, '<', $value);
                break;
            case 'less_than_equal':
            case '<=':
                $query->where($column, '<=', $value);
                break;
            case 'in':
                $values = is_array($value) ? $value : explode(',', $value);
                $query->whereIn($column, $values);
                break;
            case 'not_in':
                $values = is_array($value) ? $value : explode(',', $value);
                $query->whereNotIn($column, $values);
                break;
            case 'between':
                $values = is_array($value) ? $value : explode(',', $value);
                if (count($values) === 2) {
                    $query->whereBetween($column, $values);
                }
                break;
            case 'null':
                $query->whereNull($column);
                break;
            case 'not_null':
                $query->whereNotNull($column);
                break;
            case 'starts_with':
                $query->where($column, 'LIKE', "{$value}%");
                break;
            case 'ends_with':
                $query->where($column, 'LIKE', "%{$value}");
                break;
            default:
                $query->where($column, 'LIKE', "%{$value}%");
        }
    }
}
