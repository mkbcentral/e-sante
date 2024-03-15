<?php

use NumberToWords\NumberToWords;

function app_format_number_letter(int|float $value): string
{
    $numberToWords = new NumberToWords();
    // Obtenez un convertisseur de nombres en mots en français
    $numberTransformer = $numberToWords->getNumberTransformer('fr');
    // Convertissez un nombre en mots
    $montantEnLettres = $numberTransformer->toWords($value);

    return $montantEnLettres;;
}
