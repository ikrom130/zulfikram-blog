<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        Category::factory()->create([
            'name' => 'Data Science',
            'slug' => 'data-science',
            'color' => 'bg-blue-200'
        ]);
        
        Category::factory()->create([
            'name' => 'Design Grafis',
            'slug' => 'design-grafis',
            'color' => 'bg-red-200'
        ]);
        
        Category::factory()->create([
            'name' => 'Mobile Development',
            'slug' => 'mobile-development',
            'color' => 'bg-green-200'
        ]);
        
        Category::factory()->create([
            'name' => 'Artificial Intelligence',
            'slug' => 'ai',
            'color' => 'bg-yellow-200'
        ]);
    }
}
