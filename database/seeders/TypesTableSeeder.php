<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'  => 'Undefined',
                'description' =>'Lorem picsum',
            ],
            [
                'name'  => 'Php',
                'description' =>'Lorem picsum',
            ],
            [
                'name' => 'JavaScript',
                'description' => 'Lorem picsum',
            ],
            [
                'name' => 'Html',
                'description' =>'Lorem picsum',
            ],
            [
                'name' => 'C#',
                'description' =>'Lorem picsum',
            ],
            [
                'name' => 'Java',
                'description' =>'Lorem picsum',
            ],
            [
                'name' => 'C++',
                'description' =>'Lorem picsum',
            ],

        ];

        foreach($types as $type){
            Type::create($type);
        }
        
    }
}
