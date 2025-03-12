<?php

use Illuminate\Database\Seeder;

class CmsModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            [
                'name'         => 'Call Out',
                'icon'         => 'fa fa-glass',
                'path'         => 'call_out',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminCallOutController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
        ];

        foreach ($modules as $module) {
            CmsModule::updateOrInsert(['name' => $module['name']], $module);
        }

        $this->command->info('Seeder finished seeding modules.');
    }
}