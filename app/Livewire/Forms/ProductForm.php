<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class ProductForm extends Form
{
    #[Rule('min:4', message: 'Taill numero lot faible obligation', onUpdate: false)]
    #[Rule('nullable')]
    public $butch_number = '';
    #[Rule('required', message: 'Nom produit obligation', onUpdate: false)]
    public $name = '';
    #[Rule('required', message: 'Quantité initiale obligation', onUpdate: false)]
    public $initial_quantity = '';
    #[Rule('required', message: 'Prix unitaire obligation', onUpdate: false)]
    public $price = '';
    #[Rule('required', message: 'Quantité initiale obligation', onUpdate: false)]
    #[Rule('date', message: 'Date invalide', onUpdate: false)]
    public $expiration_date = '';
    #[Rule('required', message: 'Categorie obligation', onUpdate: false)]
    public $product_category_id = '';
    #[Rule('nullable')]
    public $product_family_id = '';
}
