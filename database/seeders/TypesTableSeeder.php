<?php

namespace Database\Seeders;

use App\Models\Type;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $types = [
            [
                'name'  => 'Undefined',
                'description' =>$faker->words(rand(20, 50), true),
            ],
            [
                'name'  => 'Php',
                'description' =>$faker->words(rand(20, 50), true),
            ],
            [
                'name' => 'JavaScript',
                'description' => $faker->words(rand(20, 50), true),
            ],
            [
                'name' => 'Html',
                'description' => $faker->words(rand(20, 50), true),
            ],
            [
                'name' => 'C#',
                'description' => $faker->words(rand(20, 50), true),
            ],
            [
                'name' => 'Java',
                'description' => $faker->words(rand(20, 50), true),
            ],
            [
                'name' => 'C++',
                'description' => $faker->words(rand(20, 50), true),
            ],

        ];

        foreach($types as $type){
            Type::create($type);
        }
        
    }
}
