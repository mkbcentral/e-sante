<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductForm extends Form
{
    #[Rule('required|numeric', message: 'Numéro lot obligation', onUpdate: false)]
    public $butch_number = '';
    #[Rule('required|string', message: 'Nom produit obligation', onUpdate: false)]
    public $name = '';
    #[Rule('required|numeric', message: 'Quantité initiale obligation', onUpdate: false)]
    public $initial_quantity = '';
    #[Rule('required|numeric', message: 'Prix unitaire obligation', onUpdate: false)]
    public $price = '';
    #[Rule('required|date', message: 'Quantité initiale obligation', onUpdate: false)]
    public $expiration_date = '';
    #[Rule('required|numeric', message: 'Categorie obligation', onUpdate: false)]
    public $product_category_id = '';
    #[Rule('required|numeric', message: 'Famille obligation', onUpdate: false)]
    public $product_family_id = '';
}
