<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'TV & Home Theather'],
            ['name' => 'Tablets & E-Readers'],
            ['name' => 'Computers', 'children' => [
                [
                    'name' => 'Laptops', 'children' => [
                    ['name' => 'PC Laptops'],
                    ['name' => 'Macbooks (Air/Pro)']
                ]
                ],
                ['name' => 'Desktops', 'children' => [
                    // These will be created
                    ['name' => 'Towers Only'],
                    ['name' => 'Desktop Packages'],
                    ['name' => 'All-in-One Computers'],
                    ['name' => 'Gaming Desktops']
                ]],
                ['name' => 'Monitors'],
            ]],
            ['name' => 'Cell Phones']
        ];
        foreach ($categories as $category)
            \App\Store\Models\Category::create($category);
    }
}
