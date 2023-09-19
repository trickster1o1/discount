<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminSetting = Menu::create([
            'name' => 'Admin Settings',
            'position' => 2,
            'icon_class' => 'mdi mdi-settings',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $cms = Menu::create([
            'name' => 'CMS',
            'position' => 8,
            'icon_class' => 'mdi mdi-package',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $site_manager = Menu::create([
            'name' => 'Site Manager',
            'position' => 23,
            'icon_class' => 'mdi mdi-book',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'User',
            'route' => 'users.index',
            'parent' => $adminSetting->id,
            'menu_code' => 'USER',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Internal Links',
            'route' => 'internal_links.index',
            'parent' => $adminSetting->id,
            'menu_code' => 'INTERNALLINK',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Role',
            'route' => 'roles.index',
            'parent' => $adminSetting->id,
            'menu_code' => 'ROLE',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Menu::create([
            'name' => 'Permission',
            'route' => 'permissions.index',
            'parent' => $adminSetting->id,
            'menu_code' => 'PERMISSION',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Site Settings',
            'route' => 'site_settings.index',
            'parent' => $site_manager->id,
            'menu_code' => 'SITESETTING',
            'position' => '4',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Menu',
            'route' => 'menus.index',
            'parent' => $adminSetting->id,
            'menu_code' => 'MENU',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Site Menus',
            'route' => 'site_menus.index',
            'parent' => $site_manager->id,
            'menu_code' => 'SITEMENU',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Categories',
            'route' => 'categories.index',
            'parent' => $cms->id,
            'menu_code' => 'CATEGORY',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Sub-Categories',
            'route' => 'sub_categories.index',
            'parent' => $cms->id,
            'menu_code' => 'SUB_CATEGORY',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Banners',
            'route' => 'banners.index',
            'parent' => $cms->id,
            'menu_code' => 'BANNER',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Blogs',
            'route' => 'blogs.index',
            'parent' => $cms->id,
            'menu_code' => 'BLOG',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Media',
            'route' => 'media.index',
            'parent' => $site_manager->id,
            'menu_code' => 'MEDIA',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Pages',
            'route' => 'pages.index',
            'parent' => $cms->id,
            'menu_code' => 'PAGE',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Menu::create([
            'name' => 'Albums',
            'route' => 'albums.index',
            'parent' => $cms->id,
            'menu_code' => 'ALBUM',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Menu::create([
            'name' => 'Popup',
            'route' => 'popups.index',
            'parent' => $cms->id,
            'menu_code' => 'POPUP',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Notice',
            'route' => 'notices.index',
            'parent' => $cms->id,
            'menu_code' => 'NOTICE',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Service',
            'route' => 'services.index',
            'parent' => $cms->id,
            'menu_code' => 'SERVICE',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Team Members',
            'route' => 'team-members.index',
            'parent' => $cms->id,
            'menu_code' => 'TEAMMEMBER',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'FAQs',
            'route' => 'faqs.index',
            'parent' => $cms->id,
            'menu_code' => 'FAQ',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Counter Information',
            'route' => 'counter_infos.index',
            'parent' => $cms->id,
            'menu_code' => 'COUNTERINFO',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Event',
            'route' => 'events.index',
            'parent' => $cms->id,
            'menu_code' => 'EVENT',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // hya tala xa change
        Menu::create([
            'name' => 'Donner',
            'route' => 'donner.index',
            'parent' => $cms->id,
            'menu_code' => 'DONNER',
            'position' => 20,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Supporters',
            'route' => 'supporter.index',
            'parent' => $cms->id,
            'menu_code' => 'SUPPORTER',
            'position' => 21,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Payment Methods',
            'route' => 'paymentmethod.index',
            'parent' => $cms->id,
            'menu_code' => 'PAYMENT',
            'position' => 22,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Contacts',
            'route' => 'contact.index',
            'parent' => $cms->id,
            'menu_code' => 'CONTACT',
            'position' => 23,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Volunteer',
            'route' => 'volunteer.index',
            'parent' => $cms->id,
            'menu_code' => 'VOL',
            'position' => 24,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Newsletter',
            'route' => 'newsletter.index',
            'parent' => $cms->id,
            'menu_code' => 'NEWS',
            'position' => 25,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Testimonial',
            'route' => 'testimonial.index',
            'parent' => $cms->id,
            'menu_code' => 'TESTI',
            'position' => 26,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Menu::create([
            'name' => 'Email Templates',
            'route' => 'email_templates.index',
            'parent' => $cms->id,
            'menu_code' => 'EMAILTEMPLATE',
            'position' => '',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
