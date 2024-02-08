<?php

namespace App\Imports;

use App\Models\Tarif;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TarifImport implements ToCollection
{
    private $category_id;

    public function __construct($value)
    {
        $this->category_id = $value;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Tarif::create([
                'name'=>$row[0],
                'abbreviation' => $row[1],
                'price_private'=>$row[2],
                'subscriber_price' => $row[3],
                'category_tarif_id' => $this->category_id,
            ]);
        }
    }
}
