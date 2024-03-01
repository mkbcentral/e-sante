<?php

namespace App\Livewire\Helpers\Query;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MakeQueryBuilderHelper
{
    /**
     * Create new record
     * @param string $tableName
     * @param array $data
     * @return bool
     */
    public static function create(string $tableName, array $data): bool
    {
        return DB::table($tableName)->insert($data);
    }

    /**
     * Get single recors for one where clause
     * @param string $tableName
     * @param string $colName
     * @param string $value
     * @return Model|Builder|object|null
     */
    public static function getSingleDataWithOneWhereClause(
        string $tableName,
        string $colName,
        string $value
    ) {
        return DB::table($tableName)->where($colName, $value)
            ->first();
    }
    /**
     * Get single recors for two where clauses
     * @param string $tableName
     * @param string $colName1
     * @param string $colName2
     * @param string $value1
     * @param string $value2
     * @return Model|Builder|object|null
     */
    public static function getSingleDataWithTowWhereClause(
        string $tableName,
        string $colName1,
        string $colName2,
        string $value1,
        string $value2
    ) {
        return DB::table($tableName)->where($colName1, $value1)
            ->where($colName2, $value2)
            ->first();
    }
    public static function getSingleData(string $tableName, $column, string $value)
    {
        return DB::table($tableName)->where($column, $value)
            ->first();
    }

    public static function getData(string $tableName, string $value1, $value2)
    {
        return DB::table($tableName)->where('consultation_request_id', $value1)
            ->where('product_id', $value2)
            ->first();
    }
    public static function update(string $tableName, string $colName, string $id, array $data): int
    {
        return DB::table($tableName)
            ->where($colName, $id)
            ->update($data);
    }
    public static function delete(string $tableName, string $colName, string $id): int
    {
        return  DB::table($tableName)->where('id', $id)->delete();
    }

    public static function deleteWithKey(string $tableName, string $colName, string $value): int
    {
        return  DB::table($tableName)->where($colName, $value)->delete();
    }
}
