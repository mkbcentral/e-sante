<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hospital;
use App\Models\MainMenu;
use App\Models\Product;
use App\Models\Role;
use App\Models\Source;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        /*
        $hospital = Hospital::create(['name' => 'SHUKRANI']);
        $source = Source::create([
            'name' => 'GOLF',
            'hospital_id' => $hospital->id
        ]);
        $role = Role::create(['name' => 'Admin']);
        $user = User::create([
            'name' => 'admmin',
            'email' => 'admin@afia.app',
            'password' => Hash::make('password'),
            'source_id' => $source->id
        ]);
        //$user->sync($role->id);
        UserSetting::create([
            'user_id' => $user->id
        ]);

        //Product::factory(50)->create();
         $mainMenus = [
            [
                'name' => 'Dashboad',
                'icon' => 'fas fa-chart-bar',
                'link' => 'dashboard',
                'bg' => 'bg-primary',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Gestionnaire des fiches',
                'icon' => 'fas fas fa-folder-plus',
                'link' => 'sheet',
                'bg' => 'bg-danger',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Patients hospitalisés',
                'icon' => 'fa fa-bed',
                'link' => 'consultation.hospitalize',
                'bg' => 'bg-secondary',
                'hospital_id' => 1,
            ],
            [
                'name' => 'List consultation',
                'icon' => 'fas fas fa-folder-open',
                'link' => 'consultation.req',
                'bg' => 'bg-success',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Tarification',
                'icon' => 'fas fa-coins',
                'link' => 'tarification',
                'bg' => 'bg-warning',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Facturation',
                'icon' => 'fas fa-money-check-alt',
                'link' => 'bill.outpatient',
                'bg' => 'bg-info',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Stock product',
                'icon' => 'fas fa-capsules',
                'link' => 'product.list',
                'bg' => 'bg-dark',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Catalogue produits',
                'icon' => 'fas fa-tablets',
                'link' => 'product.list',
                'bg' => 'bg-primary',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Appro & Requisition produits',
                'icon' => 'fas fa-tablets',
                'link' => 'product.supplies',
                'bg' => 'bg-danger',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Navigation',
                'icon' => 'fa fa-link',
                'link' => 'navigation',
                'bg' => 'bg-success',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Administration',
                'icon' => 'fas fa-users-cog',
                'link' => 'admin',
                'bg' => 'bg-primary',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Configuration',
                'icon' => 'fas fa-tools',
                'link' => 'configuration',
                'bg' => 'bg-secondary',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Localisation',
                'icon' => 'fas fa-globe',
                'link' => 'configuration',
                'bg' => 'bg-info',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Fichiers',
                'icon' => 'files',
                'link' => 'files',
                'bg' => 'bg-warning',
                'hospital_id' => 1,
            ]
        ];

        MainMenu::insert($mainMenus);
        $subMenus = [
            [
                'name' => 'Dashboad',
                'icon' => 'fas fa-chart-bar',
                'link' => 'dashboard',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Fiches de consultation',
                'icon' => 'fas fas fa-folder-plus',
                'link' => 'sheet',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Patients hospitalisés',
                'icon' => 'fa fa-bed',
                'link' => 'consultation.hospitalize',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Listes consultation',
                'icon' => 'fas fas fa-folder-open',
                'link' => 'consultation.req',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Tarification',
                'icon' => 'fas fa-coins',
                'link' => 'tarification',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Factures ambulatoires',
                'icon' => 'fas fa-money-check-alt',
                'link' => 'bill.outpatient',
                'hospital_id' => 1,
            ],

            [
                'name' => 'Factures amb. pharma',
                'icon' => 'fas fa-money-check-alt',
                'link' => 'product.invoice',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Stock principale',
                'icon' => 'fas fa-capsules',
                'link' => 'product.list',
                'hospital_id' => 1,
            ],

            [
                'name' => 'Appro médicaments',
                'icon' => 'fas fa-tablets',
                'link' => 'product.supplies',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Navigation',
                'icon' => 'fa fa-link',
                'link' => 'navigation',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Administration',
                'icon' => 'fas fa-users-cog',
                'link' => 'admin',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Configuration',
                'icon' => 'fas fa-tools',
                'link' => 'configuration',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Localisation',
                'icon' => 'fas fa-globe',
                'link' => 'configuration',
                'hospital_id' => 1,
            ],
            [
                'name' => 'Gestionnaire des fichier',
                'icon' => 'files',
                'link' => 'files',
                'hospital_id' => 1,
            ]
        ]
        SubMenu::insert($subMenus);
        */
    }
}
