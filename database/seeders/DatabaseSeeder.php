<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Language;
use App\Models\MainCategory;
use App\Models\Vendor;
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
        MainCategory::create(['id' => 7, 'translation_lang' => 'ar', 'translation_of' => 0, 'name' => 'اكسسوارات', 'slug' => 'اكسسوارات', 'status' => 1]);
        MainCategory::create(['id' => 8, 'translation_lang' => 'en', 'translation_of' => 7, 'name' => 'Accessories', 'slug' => 'accessories', 'status' => 1]);

        Vendor::create(['id' => 1, 'name' => 'علي القحطاني', 'category_id' => 1, 'email' => 'ali@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503883', 'status' => 1, 'address' => 'الحمدانية']);
        Vendor::create(['id' => 2, 'name' => 'علي الهباش', 'category_id' => 3, 'email' => 'ali1@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503881', 'status' => 1, 'address' => 'خميس مشيط']);
        Vendor::create(['id' => 3, 'name' => 'سعد القحطاني', 'category_id' => 5, 'email' => 'ali2@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503882', 'status' => 1, 'address' => 'ابها']);
        Vendor::create(['id' => 4, 'name' => 'أحمد جمعان', 'category_id' => 7, 'email' => 'ali3@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503884', 'status' => 1, 'address' => 'الرياض']);
        Vendor::create(['id' => 5, 'name' => 'عبدالهادي الشهري', 'category_id' => 1, 'email' => 'ali4@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503885', 'status' => 1, 'address' => 'الروضة']);
        Vendor::create(['id' => 6, 'name' => 'محمد منصور', 'category_id' => 3, 'email' => 'ali5@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503886', 'status' => 1, 'address' => 'التحلية']);
        Vendor::create(['id' => 7, 'name' => 'ياسر علي', 'category_id' => 5, 'email' => 'ali6@ali.com', 'password' => bcrypt('alijumaan'), 'mobile' => '0500503887', 'status' => 1, 'address' => 'السلامة']);



    }
}
