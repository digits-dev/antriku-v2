<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminSparePartsReceivingController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "last_name";
		$this->limit = "20";
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
		$this->table = "returns_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Repair Status", "name" => "repair_status"];
		$this->col[] = ["label" => "Reference No", "name" => "reference_no"];
		$this->col[] = ["label" => "Model Group", "name" => "model"];
		# END COLUMNS DO NOT REMOVE THIS LINE

	}

	public function hook_query_index(&$query)
	{
		//Your code here

	}

	public function hook_row_index($column_index, &$column_value)
	{
		$for_spare_parts_release_carry_in = DB::table('transaction_status')->where('id', '29')->first();

		if ($column_index == 1) {
			if ($column_value == $for_spare_parts_release_carry_in->id) {
				$column_value = '<span class="label label-warning">' . $for_spare_parts_release_carry_in->status_name . '</span>';
			}
		}

		if ($column_index == 3) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}
	}
}
