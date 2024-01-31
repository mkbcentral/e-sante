<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hospital;
use App\Models\Product;
use App\Models\Role;
use App\Models\Source;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $hospital= Hospital::create(['name' => 'SHUKRANI']);
        $source= Source::create([
            'name'=>'GOLF',
            'hospital_id'=>$hospital->id
        ]);
        $role=Role::create(['name'=>'Admin']);
        $user=User::create([
            'name'=>'admmin',
            'email'=>'admin@afia.app',
            'password'=>Hash::make('password'),
            'source_id'=>$source->id
        ]);
        //$user->sync($role->id);
        UserSetting::create([
            'user_id' => $user->id
        ]);

        //Product::factory(50)->create();
    }

}
