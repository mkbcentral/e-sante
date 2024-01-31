<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hospital;
use App\Models\Product;
use App\Models\Source;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        $hospital= Hospital::create(['name' => 'SHUKRANI']);
        $source= Source::create([
            'name'=>'GOLF',
            'hospital_id'=>$hospital->id
        ]);
        $user=User::create([
            'name'=>'admmin',
            'email'=>'admin@afia.app',
            'password'=>Hash::make('password')
        ]);
        UserSetting::create([
            'user_id' => $user->id
        ]);
        */

        Product::factory(50)->create();
    }

}
