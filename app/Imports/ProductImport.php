<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name'=>$row[1],
            'price'=>0,
            'initial_quantity'=>$row[2],
            'expiration_date'=>'2026-05-25',
            'source_id' => 1,
            'source_id' => 1,
            'product_category_id' => null,
            'product_family_id' =>null,
        ]);
    }
}
