<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminStockDisposalRequestController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = false;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "stock_disposal_lines";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Reference Number", "name" => "stock_disposal_header_id", "join" => "stock_disposal_header,reference_number"];
		$this->col[] = ["label" => "Parts Item", "name" => "parts_item_master_id", "join" => "parts_item_master,spare_parts"];
		$this->col[] = ["label" => "Qty", "name" => "qty"];
		$this->col[] = ["label" => "Qty", "name" => "disposal_status"];
		$this->col[] = ["label" => "Created By", "name" => "created_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Created At", "name" => "created_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		$this->button_selected = array();
		$this->button_selected[] = [
			'label' => 'Approve Request',
			'icon' => 'bi bi-hand-thumbs-up-fill text-success',
			'name' => 'approve_request',
			'color' => 'success'
		];

		$this->button_selected[] = [
			'label' => 'Reject Request',
			'icon' => 'bi bi-hand-thumbs-down text-danger',
			'name' => 'reject_request',
			'color' => 'danger'
		];
	}

	public function actionButtonSelected($id_selected, $button_name)
	{
		if ($button_name == 'approve_request') {

			try {
				DB::beginTransaction();

				$get_parts = DB::table('stock_disposal_lines')->whereIn('id', $id_selected)->get();

				foreach ($get_parts as $part) {
					$disposeQty = $part->qty;

					$currentQty = DB::table('parts_item_master')
						->where('id', $part->parts_item_master_id)
						->value('qty');

					if ($currentQty === null) {
						throw new \Exception("Part ID {$part->parts_item_master_id} not found.");
					}

					if ($disposeQty > $currentQty) {
						throw new \Exception("Insufficient quantity for part ID {$part->parts_item_master_id}.");
					}

					// Update inventory
					DB::table('parts_item_master')
						->where('id', $part->parts_item_master_id)
						->update([
							'qty' => $currentQty - $disposeQty,
							'updated_at' => now(),
						]);
				}

				// Update disposal line status in bulk
				DB::table('stock_disposal_lines')->whereIn('id', $id_selected)->update([
					'disposal_status' => 'Approved',
					'updated_at' => now(),
				]);

				DB::commit();
				CRUDBooster::redirectBack("Successfully approved selected requests!");
			} catch (\Exception $e) {
				DB::rollBack();
				CRUDBooster::redirectBack("Failed: " . $e->getMessage());
			}
		}


		if ($button_name == 'reject_request') {
			DB::table('stock_disposal_lines')->whereIn('id', $id_selected)->update([
				'disposal_status' => 'Rejected',
			]);
			CRUDBooster::redirectBack("Successfully rejected selected requests!");
		}
	}

	public function hook_query_index(&$query)
	{
		$query->whereIn('disposal_status', ['Pending']);
	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}
}
