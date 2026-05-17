<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
    ['name' => 'Fiction',    'slug' => 'fiction'],
    ['name' => 'Science',    'slug' => 'science'],
    ['name' => 'History',    'slug' => 'history'],
    ['name' => 'Comics',     'slug' => 'comics'],
    ['name' => 'Education',  'slug' => 'education'],
    ['name' => 'Technology', 'slug' => 'technology'],
    ['name' => 'Self Help',  'slug' => 'self-help'],
];
        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
        }
    }
}