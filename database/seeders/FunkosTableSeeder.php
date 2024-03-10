<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FunkosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funkos = [
            [
                'uuid' => Str::uuid(),
                'modelo' => 'Batman',
                'descripcion' => 'Descripción 1',
                'precio' => 40.99,
                'stock' => 20,
                'categoria_id' => 1,
            ],
            [
                'uuid' => Str::uuid(),
                'modelo' => 'Superman',
                'descripcion' => 'Descripción 2',
                'precio' => 40.99,
                'stock' => 20,
                'categoria_id' => 1,
            ],
            
        ];
        
    }
}
