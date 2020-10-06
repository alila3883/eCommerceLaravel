<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Language;
use App\Models\MainCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Admin::create(['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('alijumaan')]);

        Language::create(['id' => 1, 'abbr' => 'ar', 'name' => 'العربية', 'direction' => 'rtl', 'status' => 1]);
        Language::create(['id' => 2, 'abbr' => 'en', 'name' => 'English', 'direction' => 'ltr', 'status' => 1]);
        Language::create(['id' => 3, 'abbr' => 'es', 'name' => 'Spain',   'direction' => 'ltr', 'status' => 1]);


        MainCategory::create(['id' => 1, 'translation_lang' => 'ar', 'translation_of' => 0, 'name' => 'ملابس', 'slug' => 'ملابس', 'status' => 1 ]);
        MainCategory::create(['id' => 2, 'translation_lang' => 'en', 'translation_of' => 1, 'name' => 'clothes', 'slug' => 'clothes', 'status' => 1 ]);
        MainCategory::create(['id' => 3, 'translation_lang' => 'ar', 'translation_of' => 0, 'name' => 'أحذية', 'slug' => 'أحذية', 'status' => 1]);
        MainCategory::create(['id' => 4, 'translation_lang' => 'en', 'translation_of' => 3, 'name' => 'shoes', 'slug' => 'shoes', 'status' => 1]);
        MainCategory::create(['id' => 5, 'translation_lang' => 'ar', 'translation_of' => 0, 'name' => 'اجهزة الكترونية', 'slug' => 'اجهزة الكترونية', 'status' => 1]);
        MainCategory::create(['id' => 6, 'translation_lang' => 'en', 'translation_of' => 5, 'name' => 'Electronic Devices', 'slug' => 'electronic-devices', 'status' => 1]);



    }
}
