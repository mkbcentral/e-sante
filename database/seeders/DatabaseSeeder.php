<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BloodGoup;
use App\Models\CategoryTarif;
use App\Models\Consultation;
use App\Models\ConsultationSheet;
use App\Models\Diagnostic;
use App\Models\Gender;
use App\Models\Hospital;
use App\Models\MedicalOffice;
use App\Models\Municipality;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFamily;
use App\Models\Rate;
use App\Models\RuralArea;
use App\Models\Subscription;
use App\Models\Tarif;
use App\Models\TypePatient;
use App\Models\User;
use App\Models\VitalSign;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    public function run(): void
    {

        Hospital::create(['name' => 'SHUKRANI']);
        //$this->call(ProductUpdateSpecilityColumnSeeder::class);
        //User::factory(10)->create();
        /*
        ProductFamily::insert([
            ['name' => 'ANTI TOUSSIF'],
            ['name' => 'ANTI PALU'],
            ['name' => 'ANTI BIOTIQUE'],
        ]);

        ProductCategory::insert([
            [
                'name' => 'Comrimé',
                'abbreviation' => 'CE'
            ],
            [
                'name' => 'INJECTABLE',
                'abbreviation' => 'INJ'
            ],
            [
                'name' => 'SIROP',
                'abbreviation' => 'SP'
            ],
        ]);

        Product::factory(300)->create();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',

        // ]);

        $hospital=Hospital::create(['name'=>'Test hospital']);
        $municipalities=[
            ['name'=>'LUBUMBASSHI','hospital_id'=>1],
            ['name'=>'KENYA','hospital_id'=>1],
            ['name'=>'KATUBUBA','hospital_id'=>1],
            ['name'=>'RWASHI','hospital_id'=>1],
        ];
        $rurals=[
            [
                'name'=>'GAMBELA',
                'municipality_id'=>1
            ],
            [
                'name'=>'MAKUTANO',
                'municipality_id'=>1
            ],
            [
                'name'=>'MAKOMANO',
                'municipality_id'=>1
            ],
            [
                'name'=>'QUART 1',
                'municipality_id'=>2
            ],
            [
                'name'=>'QUART 2',
                'municipality_id'=>2
            ],
            [
                'name'=>'QUART 3',
                'municipality_id'=>2
            ],
            [
                'name'=>'QUART 1',
                'municipality_id'=>3
            ],
            [
                'name'=>'QUART 2',
                'municipality_id'=>3
            ],
            [
                'name'=>'QUART 3',
                'municipality_id'=>3
            ],
            [
                'name'=>'QUART 1',
                'municipality_id'=>4
            ],
            [
                'name'=>'QUART 2',
                'municipality_id'=>4
            ],
            [
                'name'=>'QUART 3',
                'municipality_id'=>4
            ],
        ];
        $blood_groups=[
            ['name'=>'O+','hospital_id'=>1],
            ['name'=>'A+','hospital_id'=>1],
            ['name'=>'B+','hospital_id'=>1],
            ['name'=>'O-','hospital_id'=>1]
        ];
        BloodGoup::insert($blood_groups);
        Municipality::insert($municipalities);
        RuralArea::insert($rurals);

        $genders=[

            ['slug'=>'M','name'=>'Masculin','hospital_id'=>1],
            ['slug'=>'F','name'=>'Féminin','hospital_id'=>1]
        ];
        Gender::insert($genders);
        $types=[
            ['name'=>'Adult','hospital_id'=>1],
            ['name'=>'Enfant','hospital_id'=>1],
        ];
        TypePatient::insert($types);
        $subscriptions=[
            [
                'name'=>'PRIVE',
                'hospital_id'=>$hospital->id,
                'is_private'=>true,
                'is_subscriber'=>false,
                'is_personnel'=>false
            ],
            [
                'name'=>'OCC',
                'hospital_id'=>$hospital->id,
                'is_private'=>false,
                'is_subscriber'=>true,
                'is_personnel'=>false
            ],
            [
                'name'=>'CNSS',
                'hospital_id'=>$hospital->id,
                'is_private'=>false,
                'is_subscriber'=>true,
                'is_personnel'=>false
            ],
            [
                'name'=>'IFS',
                'hospital_id'=>$hospital->id,
                'is_private'=>false,
                'is_subscriber'=>true,
                'is_personnel'=>false
            ],
            [
                'name'=>'PERSONNEL',
                'hospital_id'=>1,
                'is_private'=>false,
                'is_subscriber'=>false,
                'is_personnel'=>true
            ]
        ];
        Subscription::insert($subscriptions);
        \App\Models\AgentService::insert([
           [ 'name'=>'INFORMATIQUE','hospital_id'=>1],
           [ 'name'=>'MARKETING','hospital_id'=>1],
            ['name'=>'INFIRMERIE','hospital_id'=>1]
        ]);
        ConsultationSheet::factory(7000)->create();
        ConsultationSheet::factory(7000)->create();
        CategoryTarif::insert([
            ['name'=>'ACTES','hospital_id'=>1],
            ['name'=>'LABORATOIRE','hospital_id'=>1],
            ['name'=>'ECHOGRAPHIE','hospital_id'=>1],
            ['name'=>'AUTRES','hospital_id'=>1]
        ]);
        Tarif::factory(50)->create();

        Rate::create(['rate'=>2500,'hospital_id'=>1]);
        Consultation::insert([
            [
                'name'=>'CONSULTATION GENERAL',
                'price_private'=>10,
                'subscriber_price'=>20,
                'hospital_id'=>1
            ],
            [
                'name'=>'CONSULTATION SPECIAL',
                'price_private'=>20,
                'subscriber_price'=>25,
                'hospital_id'=>1
            ]
        ]);

        VitalSign::insert([
            ['name'=>'Poids','unit'=>'Kg','hospital_id'=>1],
            ['name'=>'Taille','unit'=>'m','hospital_id'=>1],
            ['name'=>'Tension','unit'=>'md','hospital_id'=>1],
        ]);

        MedicalOffice::insert([
            ['name'=>"CAB 1",'hospital_id'=>1],
            ['name'=>"CAB 2",'hospital_id'=>1],
            ['name'=>"CAB 3",'hospital_id'=>1],
        ]);

        Diagnostic::insert([
            ['name'=>'Maux de tête','hospital_id'=>1],
            ['name'=>'Bullure estomac','hospital_id'=>1],
            ['name'=>'Courbature','hospital_id'=>1],
            ['name'=>'Nausé','hospital_id'=>1],
            ['name'=>'','hospital_id'=>1],
        ]);
        */
    }

}
