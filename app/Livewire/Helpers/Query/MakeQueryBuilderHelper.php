<?php

namespace App\Livewire\Helpers\Query;

use Illuminate\Support\Facades\DB;

class MakeQueryBuilderHelper
{
    public static function create(){}
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
