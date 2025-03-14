<?php

namespace App\Http\Controllers;

use Session;
use Request;
use CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminPendingRepairController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "company_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "returns_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Status", "name" => "repair_status", "join" => "transaction_status,status_name"];
		$this->col[] = ["label" => "Reference No", "name" => "reference_no"];
		$this->col[] = ["label" => "Model Group", "name" => "model"];
		$this->col[] = ["label" => "Print Technical Report", "name" => "print_technical_report"];
		$this->col[] = ["label" => "Downpayment Status", "name" => "downpayment_status"];
		$this->col[] = ["label" => "Downpayment URL", "name" => "down_payment_url"];
		$this->col[] = ["label" => "Date Received", "name" => "level2_personnel_edited"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by", 'join' => 'cms_users,name'];
		$this->col[] = ["label" => "Technician", "name" => "technician_id", 'join' => 'cms_users,name'];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];

		$this->sub_module = array();
		$this->addaction = array();
		$this->button_selected = array();
		$this->alert        = array();
		$this->index_button = array();
		$this->table_row_color = array();
		$this->index_statistic = array();
		$this->script_js = NULL;
		$this->pre_index_html = null;
		$this->post_index_html = null;
		$this->load_js = array();
		$this->style_css = NULL;
		$this->load_css = array();
	}

	public function hook_query_index(&$query)
	{
		$query->whereIn('repair_status', [13])
			->where('branch', CRUDBooster::me()->branch_id);
	}

	public function hook_row_index($column_index, &$column_value)
	{
		if ($column_index == 3) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}
	}
}
