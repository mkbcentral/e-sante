<?php

namespace App\Exports;

use App\Models\ProductPurchase;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ExportProductPurcharseItems implements FromCollection,WithHeadings, WithStyles
{
    public ?ProductPurchase $productPurchase;
    public Collection $data;

    public function __construct(?ProductPurchase $productPurchase, Collection $data)
    {
        $this->productPurchase = $productPurchase;
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
            'N°',
            'DESIGNATION',
            'QTE DISPO',
            'QTE DEMANDEE',
            'CPP',
            'CPA',
            // Ajoutez autant de colonnes que nécessaire
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour les en-têtes
            1 => ['font' => ['bold' => true]],

            // Style pour les cellules de données
            'A' => ['font' => ['italic' => true]],
            // Vous pouvez ajouter plus de styles ici selon vos besoins

            'A1:B1' => [
                'font' => ['bold' => true], // Mettre en gras les en-têtes
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'c0c0c0'], // Couleur de fond pour les en-têtes
                ],
            ],
            'A2:B2' . ($this->data->count() + 1) => [
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT], // Aligner le contenu à gauche
            ],
        ];
    }

}
