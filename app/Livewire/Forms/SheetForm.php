<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class SheetForm extends Form
{
    #[Rule('required', message: 'Numéro fiche obligation', onUpdate: false)]
    #[Rule('numeric', message: 'Format numerique invalide', onUpdate: false)]
    public $number_sheet = '';

    #[Rule('required', message: 'Nom patient obligatoire')]
    #[Rule('min:3', message: 'Taille caractère faible')]
    public $name = '';

    #[Rule('required', message: 'Date de naissance obligatoire')]
    #[Rule('date', message: 'Format date invalide')]
    public $date_of_birth = '';

    #[Rule('required', message: 'Genre obligatoire')]
    public $gender = '';

    #[Rule('required', message: 'N° tél patient obligatoire')]
    public $phone = '';

    #[Rule('nullable')]
    public $other_phone = '';

    #[Rule('nullable')]
    public $email = '';

    #[Rule('required', message: 'Commune obligatoire')]
    public $municipality = '';

    #[Rule('required', message: 'Champ obligatoire')]
    public $rural_area = '';

    #[Rule('nullable')]
    public $street = '';

    #[Rule('nullable')]
    #[Rule('numeric', message: 'Format numérique invalide')]
    public $street_number = '';

    #[Rule('nullable')]
    public $blood_group = 'Aucun';

    #[Rule('nullable')]
    #[Rule('numeric', message: 'Format numérique invalide')]
    public $agent_service_id;

    #[Rule('nullable')]
    public $registration_number;

    #[Rule('required', message: 'Type patient obligatoire')]
    #[Rule('numeric', message: 'Format numérique invalide')]
    public $type_patient_id;

    #[Rule('required', message: 'Type consultation obligatoire')]
    #[Rule('numeric', message: 'Format numérique invalide')]
    public $consultation_id ;
}
