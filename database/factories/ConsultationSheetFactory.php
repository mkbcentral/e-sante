<?php

namespace Database\Factories;

use App\Models\BloodGoup;
use App\Models\Municipality;
use App\Models\RuralArea;
use App\Models\Subscription;
use App\Models\TypePatient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ConsultationSheet>
 */
class ConsultationSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number_sheet'=>fake()->numberBetween(0,5000),
            'name'=>fake()->name,
            'date_of_birth'=>fake()->date,
            'phone'=>fake()->phoneNumber,
            'other_phone'=>fake()->phoneNumber,
            'email'=>fake()->email,
            'gender'=>fake()->randomElement(['M','F']),
            'blood_group'=>BloodGoup::all()->random()->name,
            'municipality'=>Municipality::all()->random()->name,
            'rural_area'=>RuralArea::all()->random()->name,
            'street'=>fake()->streetName(),
            'street_number'=>fake()->numberBetween(1,1000),
            'type_patient_id'=>TypePatient::all()->random()->id,
            'subscription_id'=>Subscription::all()->random()->id,
            'hospital_id'=>1,
        ];
    }
}
