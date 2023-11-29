<?php

namespace App\Livewire\Helpers\Query;

use Illuminate\Support\Facades\DB;

class MakeQueryBuilderHelper
{
    public static function create(string $tableName,array $data): bool
    {
        return DB::table($tableName)->insert($data);
    }
    public static function getData(string $tableName,string $value1,$value2){
       return DB::table($tableName)->where('consultation_request_id',$value1)
           ->where('product_id',$value2)
           ->first();
    }
    public static function update(string $id,array $data,string $tableName): int
    {
        return DB::table($tableName)
            ->where('id', $id)
            ->update($data);
    }
    public static function delete(string $id,string $tableName): int
    {
        return  DB::table($tableName)->where('id',$id)->delete();
    }
}
