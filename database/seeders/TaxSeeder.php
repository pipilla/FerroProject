<?php

namespace Database\Seeders;

use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxes = [
            'IVA' => 21,
            'IVA (10%)' => 10,
            'IVA (5%)' => 5,
            'IVA (4%)' => 4,
            'IVA (0%)' => 0,
        ];
        foreach ($taxes as $name => $value){
            Tax::create(compact('name', 'value'));
        }
    }
}
