<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminStockDisposalRequestController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = false;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "stock_disposal_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		$this->col[] = ["label" => "Branch", "name" => "branch_id", "join" => "branch,branch_name"];
		$this->col[] = ["label" => "Disposal Memo", "name" => "disposal_memo"];
		$this->col[] = ["label" => "Total Qty", "name" => "total_qty"];
		$this->col[] = ["label" => "Status", "name" => "status"];
		$this->col[] = ["label" => "Created By", "name" => "created_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Created At", "name" => "created_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE
	}

	public function hook_query_index(&$query)
	{
		$query->where('stock_disposal_header.status', '=', 'Pending');
	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}

	public function getEdit($id)
	{
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data['stock_disposal_header'] = DB::table('stock_disposal_header')
			->leftJoin('stock_disposal_lines', 'stock_disposal_lines.stock_disposal_header_id', '=', 'stock_disposal_header.id')
			->leftJoin('parts_item_master', 'parts_item_master.id', '=', 'stock_disposal_lines.parts_item_master_id')
			->select('stock_disposal_header.*', 'stock_disposal_header.id as header_id', 'stock_disposal_lines.*', 'stock_disposal_lines.id as lines_id', 'stock_disposal_lines.created_at as requested_date', 'stock_disposal_lines.qty as request_qty', 'parts_item_master.*')
			->where('stock_disposal_header.id', $id)->get();

		return $this->view('inventory.stock_disposal_approval_view', $data);
	}

	public function rejectDisposalRequest(Request $request)
	{
		DB::beginTransaction();

		try {
			DB::table('stock_disposal_header')
				->where('id', $request->header_id)
				->update([
					'status' => 'Rejected',
					'rejection_reason' => $request->rejection_reason,
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			DB::table('stock_disposal_lines')
				->where('stock_disposal_header_id', $request->header_id)
				->update([
					'disposal_status' => 'Rejected',
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			DB::commit();

			return response()->json(['success' => true, 'message' => 'Disposal request rejected successfully.']);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('Failed to reject disposal request: ' . $e->getMessage());

			return response()->json(['success' => false, 'message' => 'Failed to reject disposal request.'], 500);
		}
	}

	public function approveDisposalRequest(Request $request)
	{
		DB::beginTransaction();

		try {
			// Update header status
			DB::table('stock_disposal_header')
				->where('id', $request->header_id)
				->update([
					'status' => 'Approved',
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			// Update line items status
			DB::table('stock_disposal_lines')
				->where('stock_disposal_header_id', $request->header_id)
				->update([
					'disposal_status' => 'Approved',
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			// Fetch disposal parts related to the header
			$get_parts = DB::table('stock_disposal_lines')
				->where('stock_disposal_header_id', $request->header_id)
				->get();

			$get_header = DB::table('stock_disposal_header')
				->where('id', $request->header_id)
				->first();

			foreach ($get_parts as $part) {
				$disposeQty = $part->qty;

				$currentQty = DB::table('branch_item_stocks')
					->where('parts_item_master_id', $part->parts_item_master_id)
					->value('stock_qty');

				if ($currentQty === null) {
					throw new \Exception("Part ID {$part->parts_item_master_id} not found.");
				}

				if ($disposeQty > $currentQty) {
					throw new \Exception("Insufficient quantity for part ID {$part->parts_item_master_id}.");
				}

				// Update inventory
				DB::table('branch_item_stocks')
					->where('parts_item_master_id', $part->parts_item_master_id)
					->where('branch_id', $get_header->branch_id)
					->update([
						'stock_qty' => $currentQty - $disposeQty,
						'updated_by' => CRUDBooster::myId(),
						'updated_at' => now(),
					]);
			}

			DB::commit();

			return response()->json(['success' => true, 'message' => 'Disposal request approved successfully.']);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('Failed to approve disposal request: ' . $e->getMessage());

			return response()->json(['success' => false, 'message' => 'Failed to approve disposal request.'], 500);
		}
	}
}
