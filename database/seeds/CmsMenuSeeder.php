<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'              => 'Call Out',
                'type'              => 'Route',
                'path'              => 'AdminCallOutControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-glass',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 12
            ],
        ];
    
        foreach ($menus as $menu) {
            DB::table('cms_menus')->updateOrInsert(
                ['name' => $menu['name']], 
                $menu
            );
        }
        
        $this->command->info('Seeder finished seeding menus.');
    }
}