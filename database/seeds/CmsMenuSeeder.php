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
            [
                'name'              => 'Pending Mail-In Shipment',
                'type'              => 'Route',
                'path'              => 'AdminPendingMailInShipmentControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-glass',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 13
            ],
            [
                'name'              => 'Pending Repair',
                'type'              => 'Route',
                'path'              => 'AdminPendingRepairControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-gears',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 15
            ],
            [
                'name'              => 'Pending Spare Parts',
                'type'              => 'Route',
                'path'              => 'AdminPendingSparePartsControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-circle-o',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 16
            ],
            [
                'name'              => 'Escalated',
                'type'              => 'Route',
                'path'              => 'AdminEscalatedReturnsHeaderControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-circle-o',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 12
            ],
            [
                'name'              => 'Pending Good Unit',
                'type'              => 'Route',
                'path'              => 'AdminPendingGoodUnitControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-inbox',
                'parent_id'         => 0,
                'is_active'         => 1,
                'is_dashboard'      => 0,
                'id_cms_privileges' => 1,
                'sorting'           => 18
            ],
            [
                'name'              => 'To Assign',
                'type'              => 'Route',
                'path'              => 'AdminToAssignControllerGetIndex',
                'color'             => 'normal',
                'icon'              => 'fa fa-gear',
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