<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminStockReservationsController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "company_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = false;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "returns_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "JO Status", "name" => "repair_status", "join" => "transaction_status,status_name"];
		$this->col[] = ["label" => "JO Reference Number", "name" => "reference_no"];
		$this->col[] = ["label" => "JO Model Group", "name" => "model"];
		$this->col[] = ["label" => "Total Reservations", "name" => "id"];
		$this->col[] = ["label" => "Total Pending Reservations", "name" => "id"];
		# END COLUMNS DO NOT REMOVE THIS LINE
	}

	public function hook_query_index(&$query)
	{

		$query->join('inventory_reservations', 'returns_header.id', '=', 'inventory_reservations.return_header_id')
			->whereNotNull('inventory_reservations.return_header_id')
			->groupBy('returns_header.id')
			->select('returns_header.*');
	}

	public function hook_row_index($column_index, &$column_value)
	{
		if ($column_index == 2) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}

		if ($column_index == 3) {

			$count = DB::table('inventory_reservations')
				->where('return_header_id', $column_value)
				->count();

			$column_value = $count;
		}

		if ($column_index == 4) {

			$count = DB::table('inventory_reservations')
				->where('return_header_id', $column_value)
				->where('status', '=', 'Pending')
				->count();

			$column_value = $count;
		}
	}

	public function getDetail($id)
	{
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data['get_jo_reference'] = DB::table('returns_header')
			->where('id', $id)->pluck('reference_no')->first();

		$data['stock_reservations_data'] = DB::table('inventory_reservations')
			->leftJoin('parts_item_master', 'parts_item_master.id', '=', 'inventory_reservations.parts_item_master_id')
			->select('inventory_reservations.created_at as reserve_date', 'parts_item_master.*', 'inventory_reservations.*')
			->where('return_header_id', $id)->get();

		return $this->view('inventory.stock_reservations_view', $data);
	}
}
