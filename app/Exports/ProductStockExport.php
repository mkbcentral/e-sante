<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductStockExport implements FromCollection, WithHeadings
{
    public Collection $data;

    public function __construct(Collection $data)
    {
        $this->data=$data;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }
    public function headings(): array
    {
        // Définir les en-têtes du fichier Excel
        return [
            'DESIGNATION',
            'STOCK',
            'PA',
            'PV',
            // Ajoutez autant de colonnes que nécessaire
        ];
    }
}
