<?php

use Illuminate\Database\Seeder;

class ParentCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parent_categories')->insert([
            'category' => 'Ventas',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Agricultor',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Almacenista',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Auxiliar',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Campo',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Cambaceo',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Chofer',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Administrativo',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Mesero',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Mesera',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Cajera',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Enfermeras',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Guardias',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Alimentos',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Mecanico',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Albañil',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Costurera Modista',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Jardinero',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Medio Tiempo',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Obrero',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Obrera',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Otros',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Practicas',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Profesionista',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Servicio social',
        ]);
        DB::table('parent_categories')->insert([
            'category' => 'Técnico',
        ]);
    }
}
