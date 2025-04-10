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
            [
                'name'         => 'Pending Repair',
                'icon'         => 'fa fa-gears',
                'path'         => 'pending_repair',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminPendingRepairController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
            [
                'name'         => 'Pending Spare Parts',
                'icon'         => 'fa fa-circle-o',
                'path'         => 'pending_spare_parts',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminPendingSparePartsController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
            [
                'name'         => 'Escalated',
                'icon'         => 'fa fa-times-circle',
                'path'         => 'escalated_returns_header',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminEscalatedReturnsHeaderController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
            [
                'name'         => 'Pending Good Unit',
                'icon'         => 'fa fa-inbox',
                'path'         => 'pending_good_unit',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminPendingGoodUnitController',
                'is_protected' => 0,
                'is_active'    => 0,
            ],
            [
                'name'         => 'To Assign',
                'icon'         => 'fa fa-gear',
                'path'         => 'to_assign',
                'table_name'   => 'returns_header',
                'controller'   => 'AdminToAssignController',
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