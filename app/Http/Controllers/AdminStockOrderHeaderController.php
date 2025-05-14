<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminStockOrderHeaderController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->table = "stock_order_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		$this->col[] = ["label" => "Total Qty", "name" => "total_qty"];
		$this->col[] = ["label" => "Total Cost", "name" => "total_cost"];
		$this->col[] = ["label" => "Order Status", "name" => "order_status"];
		$this->col[] = ["label" => "Created By", "name" => "created_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Created At", "name" => "created_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

	}


	public function hook_query_index(&$query)
	{
		//Your code here

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

		$data['stock_order_data'] = DB::table('stock_order_header')
			->leftJoin('stock_order_lines', 'stock_order_lines.stock_order_header_id', '=', 'stock_order_header.id')
			->leftJoin('parts_item_master', 'parts_item_master.id', '=', 'stock_order_lines.parts_item_master_id')
			->select('stock_order_header.*', 'stock_order_lines.*', 'stock_order_lines.id as lines_id', 'stock_order_lines.created_at as ordered_date', 'stock_order_lines.qty as ordered_qty', 'parts_item_master.*')
			->where('stock_order_header.id', $id)->get();

		return $this->view('inventory.stock_order_receiving_view', $data);
	}
}
