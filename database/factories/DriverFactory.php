<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{

    protected $model = Driver::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake = fake('fa_IR');

        return [
            'first_name' => $fake->firstName,
            'last_name' => $fake->lastName,
            'national_code' => $fake->isbn10(),
            'access_token' => 'DRV-' . $fake->unique()->uuid(),
        ];
    }
}
