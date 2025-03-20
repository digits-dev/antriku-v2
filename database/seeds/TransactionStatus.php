<?php

use Illuminate\Database\Seeder;

class TransactionStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaction_statuses = [
            [
                'status_name' => 'TO DIAGNOSE',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'TO PAY PARTS',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'CANCELLED',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'REPAIR IN PROCESS',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'CANCELLED / CLOSED',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'COMPLETE',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'TO PICK UP',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'TO PAY DIAGNOSTIC',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'ONGOING DIAGNOSIS',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'FOR CALL-OUT MAIL-IN',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'PENDING MAIL-IN SHIPMENT',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'MAIL-IN SHIPPED',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'ONGOING REPAIR',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'PENDING SPARE PARTS',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'SPARE PARTS RECEIVED / AWAITING REPAIR',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'SHIPPED MAIL-IN',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => "PENDING CUSTOMER'S PAYMENT",
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'REPLACEMENT PARTS PAID',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'FOR PARTS ORDERING',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'REPLACEMENT PARTS RECEIVED',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'FOR CALL-OUT (GOOD UNIT)',
                'status' => 'ACTIVE',
            ],
            [
                'status_name' => 'PENDING FOR GOOD UNIT',
                'status' => 'ACTIVE',
            ],
          
        ];

        foreach ($transaction_statuses as $transaction_status) {
            DB::table('transaction_status')->updateOrInsert(
                ['status_name' => $transaction_status['status_name']], 
                $transaction_status
            );
        }

        $this->command->info('Seeder finished seeding Transaction Status.');
    }
}