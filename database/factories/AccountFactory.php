<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $bank = Arr::random($this->bankNames(),1);
        return [
            'user_name' => $this->faker->firstName.' '.$this->faker->lastName,
            'bank_name' => $bank[0]['bank_name'],
            'bank_address' => $bank[0]['bank_address'],
            'balance' => 500,
        ];
    }

    public function bankNames()
    {
        return [
          [
            "bank_name"=> "Rolfson Ltd",
            "bank_address"=> "61788 Estrella Lake\nNorth Gloria, SC 97584-1449"
          ],
          [
            "bank_name"=> "O Hara Stanton",
            "bank_address"=> "253 Floy Lane Suite 710\nStephaniamouth, DC 79209"
          ],
          [
            "bank_name"=> "Lowe Armstrong and Thiel",
            "bank_address"=> "91664 Loraine Estate Suite 065\nPort Sharon, AZ 56581"
          ],
          [
            "bank_name"=> "Crooks PLC",
            "bank_address"=> "2053 Spencer Rapids\nOceaneborough, CT 11889-4765"
          ],
          [
            "bank_name"=> "Ryan McGlynn",
            "bank_address"=> "87917 Janet Key Apt. 328\nAbrahamside, WY 61274"
          ],
          [
            "bank_name"=> "Kub and Sons",
            "bank_address"=> "374 Lowe Mission\nHegmannstad, MD 76187"
          ],
          [
            "bank_name"=> "Zboncak Schroeder and Doyle",
            "bank_address"=> "72706 Carissa Mountain\nSouth Evanborough, AR 66505"
          ],
          [
            "bank_name"=> "Grant and Sons",
            "bank_address"=> "938 Schamberger Stream\nPort Vellashire, WY 78240-4492"
          ],
          [
            "bank_name"=> "Welch Inc",
            "bank_address"=> "27258 Hegmann Stream\nCarterside, ID 13029"
          ],
          [
            "bank_name"=> "Waelchi Group",
            "bank_address"=> "69210 Muriel Greens\nBlockport, IA 04482-6720"
          ]
        ];
    }
}
