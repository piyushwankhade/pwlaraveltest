<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Interaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin', 
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin@123'),
            'is_admin' => true
        ]);
        
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('Admin@123')
        ]);
        
        User::factory()->create([
            'name' => 'Blake Larson',
            'email' => 'blakelarson@example.com',
            'password' => bcrypt('Admin@123')
        ]);

        Customer::factory()->count(100)->create()->each(function ($customer) {
            $customer->update([
                'company_id' => Company::factory()->create()->id,
                'sales_rep_id' => random_int(2,3),
            ]);

            $customer->interactions()->saveMany(Interaction::factory()->count(500)->make());
        });
        
    }
}
