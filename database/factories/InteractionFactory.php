<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeThisDecade;

        return [
            'type' => $this->faker->randomElement([
            'Phone',
            'Email',
            'SMS',
            'Meeting',
            'Breakfast',
            'Lunch',
            'Dinner',
            'Twitter',
            'Facebook',
            'LinkedIn',
            'Viewed Invoice',
            'Paid Invoice',
        ]),
        'created_at' => $date,
        'updated_at' => $date,
        ];
    }
}
