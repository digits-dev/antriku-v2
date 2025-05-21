<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPartsItemMasterStocksController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "10";
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
		$this->table = "branch_item_stocks";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		if(!in_array(CRUDBooster::myPrivilegeId(), [9])){
			$this->col[] = ["label" => "Branch", "name" => "branch_id", "join" => "branch,branch_name"];
		}
		$this->col[] = ["label" => "Spare Parts", "name" => "parts_item_master_id", "join" => "parts_item_master,spare_parts"];
		$this->col[] = ["label" => "Item Description", "name" => "parts_item_master_id", "join" => "parts_item_master,item_description"];
		$this->col[] = ["label" => "Stock Qty", "name" => "stock_qty"];
		$this->col[] = ["label" => "Cost", "name" => "parts_item_master_id", "join" => "parts_item_master,cost"];
		$this->col[] = ["label" => "Stock Status", "name" => "status"];
		# END COLUMNS DO NOT REMOVE THIS LINE  

		if (CRUDBooster::isCreate() && in_array(CRUDBooster::myPrivilegeId(), [9])) {
			$currentUrl = url()->current();
			$orderingUrl = CRUDBooster::mainpath('stock_ordering');
			$addStockUrl = CRUDBooster::mainpath('stock_in_manual');
			$disposeStockUrl = CRUDBooster::mainpath('dispose_stocks');

			// Only show buttons if we are NOT on either of these pages
			if ($currentUrl != $orderingUrl && $currentUrl != $addStockUrl && $currentUrl != $disposeStockUrl) {

				// $this->index_button[] = [
				// 	"label" => "Order Stocks",
				// 	"icon" => "fa fa-cart-plus",
				// 	"url" => $orderingUrl,
				// 	"color" => "warning"
				// ];

				$this->index_button[] = [
					"label" => "Add Stocks",
					"icon" => "fa fa-plus",
					"url" => $addStockUrl,
					"color" => "info"
				];

				$this->index_button[] = [
					"label" => "Dispose Stocks",
					"icon" => "fa fa-trash",
					"url" => $disposeStockUrl,
					"color" => "danger"
				];
			}
		}
	}

	public function hook_query_index(&$query)
	{
		if(in_array(CRUDBooster::myPrivilegeId(), [9])){
			$query->where('branch_id', CRUDBooster::me()->branch_id)
				  ->where('status', '=', 'ACTIVE');
		} else {
			$query->where('status', '=', 'ACTIVE');
		}
	}

	public function hook_row_index($column_index, &$column_value) {}

	public function stockOrder()
	{
		$data['inventory_data'] = DB::table('parts_item_master')->where('gsx_item_status', '=', 'ACTIVE')->get();

		return $this->view('inventory.stock_ordering', $data);
	}

	public function stockInManual()
	{
		$data['inventory_data'] = DB::table('parts_item_master')->where('gsx_item_status', '=', 'ACTIVE')->get();

		return $this->view('inventory.stock_in_manual', $data);
	}

	public function disposeStocks()
	{
		$data['inventory_data'] = DB::table('parts_item_master')->where('gsx_item_status', '=', 'ACTIVE')->get();

		return $this->view('inventory.stock_disposal', $data);
	}

	public function storePartsManual(Request $request)
	{
		$parts = $request->input('parts');

		if (is_array($parts)) {
			DB::beginTransaction();

			try {
				foreach ($parts as $part) {
					$latestId = DB::table('inventory_stock_in')->max('id');
					$nextId = $latestId ? $latestId + 1 : 1;

					$reference_number = str_pad($nextId, 9, "0", STR_PAD_LEFT);
					$stock_in_reference_no = 'REF-' . $reference_number;

					DB::table('inventory_stock_in')->insert([
						'parts_item_master_id' => $part['id'],
						'reference_number' => $stock_in_reference_no,
						'qty' => $part['qty'],
						'stock_in_type' => 'Manual Stock In',
						'stock_in_status' => 'Received',
						'created_by' => CRUDBooster::myId(),
						'created_at' => now(),
					]);

					$existing = DB::table('branch_item_stocks')
						->where('branch_id', CRUDBooster::me()->branch_id)
						->where('parts_item_master_id', $part['id'])
						->first();

					if ($existing) {
						DB::table('branch_item_stocks')
							->where('id', $existing->id)
							->update([
								'stock_qty' => $existing->stock_qty + $part['qty'],
								'updated_at' => now(),
								'updated_by' => CRUDBooster::myId(),
							]);
					} else {
						DB::table('branch_item_stocks')->insert([
							'branch_id' => CRUDBooster::me()->branch_id,
							'parts_item_master_id' => $part['id'],
							'stock_qty' => $part['qty'],
							'status' => 'ACTIVE',
							'created_by' => CRUDBooster::myId(),
							'created_at' => now(),
						]);
					}
				}

				DB::commit();

				return response()->json(['success' => true, 'message' => 'Parts saved successfully.']);
			} catch (\Exception $e) {
				DB::rollback();

				return response()->json([
					'success' => false,
					'message' => 'An error occurred while saving parts.',
					'error' => $e->getMessage(),
				], 500);
			}
		}

		return response()->json(['success' => false, 'message' => 'Invalid data.'], 400);
	}

	public function saveDisposeStocks(Request $request)
	{
		$disposal_memo = $request->input('disposal_memo');
		$parts = $request->input('parts');

		if (!is_array($parts) || empty($parts)) {
			return response()->json(['success' => false, 'message' => 'Invalid or empty parts data.'], 400);
		}

		DB::beginTransaction();

		try {
			// Generate next reference number
			$latestId = DB::table('stock_disposal_header')->max('id');
			$nextId = $latestId ? $latestId + 1 : 1;
			$reference_number = str_pad($nextId, 9, "0", STR_PAD_LEFT);
			$stock_in_reference_no = 'DS-' . $reference_number;
			$totalQty = collect($parts)->sum('qty');

			// Insert header
			$headerId = DB::table('stock_disposal_header')->insertGetId([
				'reference_number' => $stock_in_reference_no,
				'branch_id' => CRUDBooster::me()->branch_id,
				'disposal_memo' => $disposal_memo,
				'total_qty' => $totalQty,
				'created_by' => CRUDBooster::myId(),
				'created_at' => now(),
			]);

			// Insert lines and update stock
			foreach ($parts as $part) {
				$partId = $part['id'];
				$disposeQty = $part['qty'];

				// Insert line
				DB::table('stock_disposal_lines')->insert([
					'stock_disposal_header_id' => $headerId,
					'parts_item_master_id' => $partId,
					'qty' => $disposeQty,
					'disposal_status' => 'Pending',
					'created_by' => CRUDBooster::myId(),
					'created_at' => now(),
				]);
			}

			DB::commit();

			return response()->json(['success' => true, 'message' => 'Parts disposed successfully.']);
		} catch (\Exception $e) {
			DB::rollback();

			return response()->json([
				'success' => false,
				'message' => 'An error occurred while disposing parts.',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function saveStockOrder(Request $request)
	{
		$total_cost = $request->input('total_cost');
		$parts = $request->input('parts');

		if (!is_array($parts) || empty($parts)) {
			return response()->json(['success' => false, 'message' => 'Invalid or empty parts data.'], 400);
		}

		DB::beginTransaction();

		try {
			// Generate next reference number
			$latestId = DB::table('stock_order_header')->max('id');
			$nextId = $latestId ? $latestId + 1 : 1;
			$reference_number = str_pad($nextId, 9, "0", STR_PAD_LEFT);
			$stock_in_reference_no = 'SO-' . $reference_number;
			$totalQty = collect($parts)->sum('qty');

			// Insert header
			$headerId = DB::table('stock_order_header')->insertGetId([
				'reference_number' => $stock_in_reference_no,
				'total_cost' => $total_cost,
				'total_qty' => $totalQty,
				'order_status' => 'Awaiting Apple Stock (Buffer)',
				'created_by' => CRUDBooster::myId(),
				'created_at' => now(),
			]);

			// Insert lines and update stock
			foreach ($parts as $part) {
				$partId = $part['id'];
				$orderQty = $part['qty'];

				// Insert line
				DB::table('stock_order_lines')->insert([
					'stock_order_header_id' => $headerId,
					'parts_item_master_id' => $partId,
					'qty' => $orderQty,
					'order_status' => 'Awaiting Apple Stock (Buffer)',
					'created_by' => CRUDBooster::myId(),
					'created_at' => now(),
				]);
			}

			DB::commit();

			return response()->json(['success' => true, 'message' => 'Parts ordered successfully.']);
		} catch (\Exception $e) {
			DB::rollback();

			return response()->json([
				'success' => false,
				'message' => 'An error occurred while ordering parts.',
				'error' => $e->getMessage(),
			], 500);
		}
	}
}
