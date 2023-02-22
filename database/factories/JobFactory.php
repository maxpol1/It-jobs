<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' =>User::all()->random()->id,
            'company_id'=>Company::all()->random()->id,
            'title'=>$title=fake()->text,
            'slug'=>Str::slug($title),
            'position'=>fake()->jobTitle,
            'address'=>fake()->address,
            'category_id'=> rand(1,5),
            'type'=>'fulltime',
            'status'=>rand(0,1),
            'description'=>fake()->text(),
            'roles'=>fake()->text,
            'last_date'=>fake()->DateTime,
        ];
    }
}
