<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
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
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "parts_item_master";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Spare Parts", "name" => "spare_parts"];
		$this->col[] = ["label" => "Item Description", "name" => "item_description"];
		$this->col[] = ["label" => "Qty", "name" => "qty"];
		$this->col[] = ["label" => "Cost", "name" => "cost"];
		$this->col[] = ["label" => "GSX Item Status", "name" => "gsx_item_status"];
		# END COLUMNS DO NOT REMOVE THIS LINE  
		
		if (CRUDBooster::isCreate()) {
			if (in_array(CRUDBooster::myPrivilegeId(), [8])) {
				$orderingUrl = CRUDBooster::mainpath('stock_ordering');
				$currentUrl = url()->current();
		
				if ($currentUrl != $orderingUrl) {
					$this->index_button[] = [
						"label" => "Order Stocks",
						"icon" => "fa fa-cart-plus",
						"url" => $orderingUrl,
						"color" => "warning"
					];
				}
			}
		}
		
	}

	public function hook_query_index(&$query)
	{
		$query->where('gsx_item_status', '=', 'ACTIVE');

	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}

	public function stockOrder(){
		$data['inventory_data'] = DB::table('parts_item_master')->where('gsx_item_status', '=', 'ACTIVE')->get();

		return $this->view('inventory.stock_ordering', $data);
	}
}
