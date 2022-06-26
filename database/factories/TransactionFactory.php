<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fromAccount = Account::inRandomOrder()->where('balance','>',10)->first();
        $toAccount = Account::where('id','!=',$fromAccount->id)->inRandomOrder()->first();

        $amount = $this->faker->numberBetween($min = 10, $max = $fromAccount->balance);

        $fromAccount->update(['balance' => $fromAccount->balance - $amount]);
        $toAccount->update(['balance' => $toAccount->balance + $amount]);

        return [
            'from_account_id' => $fromAccount->id,
            'to_account_id' => $toAccount->id,
            'amount' => $amount,
        ];
    }
}
