<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pet;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pet = new Pet;
        $pet->name        = 'Mitarisu';
        $pet->kind        = 'Pig';
        $pet->weight      = 4.5;
        $pet->age         = 1;
        $pet->breed       = 'Native';
        $pet->location    = 'Colombia';
        $pet->description = 'Es alergico al cuido';
        $pet->save();

        $pet = new Pet;
        $pet->name        = 'Luna';
        $pet->kind        = 'Dog';
        $pet->weight      = 9.4;
        $pet->age         = 6;
        $pet->breed       = 'Salchicha';
        $pet->location    = 'Colombia';
        $pet->description = 'Es extremadamente gorda y por eso hay que ayudarla a hacer sus necesidades';
        $pet->save();


        $pet = new Pet;
        $pet->name        = 'Jasper';
        $pet->kind        = 'Cat';
        $pet->weight      = 5 ;
        $pet->age         = 2;
        $pet->breed       = 'Native';
        $pet->location    = 'Colombia';
        $pet->description = 'Completamente sano y funcional';
        $pet->save();
    }
}
