<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Interaction;
use App\Models\Transaction;
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
        // User::factory()->create([
        //     'name' => 'Admin', 
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('Admin@123'),
        //     'is_admin' => true
        // ]);
        
        // User::factory()->create([
        //     'name' => 'John Doe',
        //     'email' => 'johndoe@example.com',
        //     'password' => bcrypt('Admin@123')
        // ]);
        
        // User::factory()->create([
        //     'name' => 'Blake Larson',
        //     'email' => 'blakelarson@example.com',
        //     'password' => bcrypt('Admin@123')
        // ]);

        Account::factory()->count(50)->create();
        Transaction::factory()->count(500)->create();

        // 'first_name' => $this->faker->firstName,
        // 'last_name' => $this->faker->lastName,
        // 'name' => $this->faker->company,

        // Company::factory()->count(10)->create();

        // Customer::factory()->count(100)->create()->each(function ($customer) {
        //     $customer->update([
        //         'company_id' => Company::inRandomOrder()->first()->id,
        //         'sales_rep_id' => random_int(2,3),
        //     ]);

        //     $customer->interactions()->saveMany(Interaction::factory()->count(50)->make());
        // });
        
    }
}
