<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'name'         => 'Pending Mail-In Shipment',
                'icon'         => 'fa fa-glass',
                'path'         => 'pending_mail_in_shipment',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminPendingMailInShipmentController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
        ];

        foreach ($modules as $module) {
            DB::table('cms_moduls')->updateOrInsert(
                ['name' => $module['name']], 
                $module
            );
        }

        $this->command->info('Seeder finished seeding modules.');
    }
}