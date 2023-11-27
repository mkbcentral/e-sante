<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class SheetForm extends Form
{
    #[Rule('required|min:3|string',message: 'Numéro fiche obligation',onUpdate: false)]
    public $number_sheet = '';

    #[Rule('required|min:3|string',message: 'Nom patient obligatoire')]
    public $name = '';

    #[Rule('required|date',message: 'Date de naissance obligatoire')]
    public $date_of_birth = '';

    #[Rule('required|string',message: 'Genre obligatoire')]
    public $gender = '';

    #[Rule('required|string',message: 'Nom patient obligatoire')]
    public $phone = '';

    #[Rule('nullable|string')]
    public $other_phone = '';

    #[Rule('nullable|string')]
    public $email = '';

    #[Rule('required|string',message: 'Commune obligatoire')]
    public $municipality = '';

    #[Rule('required|string',message: 'Champ obligatoire')]
    public $rural_area = '';

    #[Rule('nullable|string')]
    public $street = '';

    #[Rule('nullable|numeric')]
    public $street_number = '';

    #[Rule('nullable|string')]
    public $blood_group = 'Aucun';

    #[Rule('nullable|numeric')]
    public $agent_service_id ='';

    #[Rule('nullable|string')]
    public $registration_number ='';

    #[Rule('required|numeric',message: 'Type patient obligatoire')]
    public $type_patient_id;

    #[Rule('required|numeric',message: 'Type consultation obligatoire')]
    public $consultation_id='';
}
