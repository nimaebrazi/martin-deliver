<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{

    protected $model = Customer::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fake = fake('fa_IR');

        return [
            'name' => $fake->company,
            'legal_name' => $fake->company,
            'company_identity' => $fake->isbn10(),
            'access_token' => 'CU-' . $fake->unique()->uuid(),
        ];
    }
}
