<?php

namespace Database\Factories;

use App\Models\Customer;
use Faker\Provider\en_US\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer = Customer::all()->pluck('id');

        return [
            'country' => $this->faker->country(),
            'state' => Address::state(),
            'city' => $this->faker->optional()->city(),
            'address' => $this->faker->optional()->address(),
            'customer_id' => $this->faker->randomElement($customer)
        ];
    }
}
