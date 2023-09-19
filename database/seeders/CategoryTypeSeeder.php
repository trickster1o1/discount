<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $category_types = [
            [
                'title' => 'Blog',
                'slug' => 'blog',
                'status' => 'active'
            ],
            [
                'title' => 'Pages',
                'slug' => 'pages',
                'status' => 'active'
            ],

            [
                'title' => 'FAQs',
                'slug' => 'faqs',
                'status' => 'active'
            ],
            [
                'title' => 'Gallery',
                'slug' => 'gallery',
                'status' => 'active'
            ],
            
            [
                'title' => 'Event',
                'slug' => 'event',
                'status' => 'active'
            ],
            [
                'title' => 'Program',
                'slug' => 'program',
                'status' => 'active'
            ],
            [
                'title' => 'Service',
                'slug' => 'service',
                'status' => 'active'
            ],
        ];
        DB::table('category_types')->insert($category_types);
    }
}
