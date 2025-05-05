<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminTransactionStatusController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "status_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "transaction_status";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Status Name", "name" => "status_name"];
		$this->col[] = ["label" => "Warranty Status", "name" => "warranty_status"];
		$this->col[] = ["label" => "Status", "name" => "status"];
		$this->col[] = ["label" => "Date Created", "name" => "created_at"];
		$this->col[] = ["label" => "Date Updated", "name" => "updated_at"];
		$this->col[] = ["label" => "Created By", "name" => "created_by"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Status Name', 'name' => 'status_name', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7', 'dataenum' => 'ACTIVE;INACTIVE'];
		$this->form[] = ['label' => 'Warranty Status', 'name' => 'warranty_status', 'type' => 'select', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7', 'dataenum' => 'IN WARRANTY;OUT OF WARRANTY'];
		# END FORM DO NOT REMOVE THIS LINE

	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		if ($column_index == 1) {
			if ($column_value == 'TO DIAGNOSE') {
				$column_value = '<span class="label label-warning">' . $column_value . '</span>';
			} elseif ($column_value == 'TO PAY PARTS') {
				$column_value = '<span class="label label-primary">' . $column_value . '</span>';
			} elseif ($column_value == 'CANCELLED') {
				$column_value = '<span class="label label-danger">' . $column_value . '</span>';
			} elseif ($column_value == 'REPAIR IN PROCESS') {
				$column_value = '<span class="label label-success">' . $column_value . '</span>';
			} elseif ($column_value == 'CANCELLED / CLOSED') {
				$column_value = '<span class="label label-danger">' . $column_value . '</span>';
			} elseif ($column_value == 'TO PICK UP') {
				$column_value = '<span class="label label-success">' . $column_value . '</span>';
			} elseif ($column_value == 'COMPLETE') {
				$column_value = '<span class="label label-success">' . $column_value . '</span>';
			} elseif ($column_value == 'TO PAY DIAGNOSTIC') {
				$column_value = '<span class="label label-primary">' . $column_value . '</span>';
			} elseif ($column_value == 'TO ASSIGN') {
				$column_value = '<span class="label label-primary">' . $column_value . '</span>';
			}
		}

		if ($column_index == 2) {
			if ($column_value == 'OUT OF WARRANTY') {
				$column_value = '<span style="color: #F93154"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'IN WARRANTY') {
				$column_value = '<span style="color: #00B74A"><strong>' . $column_value . '</strong></span>';
			}
		}

		if ($column_index == 3) {
			if ($column_value == 'INACTIVE') {
				$column_value = '<span style="color: #F93154"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'ACTIVE') {
				$column_value = '<span style="color: #00B74A"><strong>' . $column_value . '</strong></span>';
			}
		}

		if ($column_index == 4 || $column_index == 5) {
			$column_value = date('F j, Y H:i:s', strtotime($column_value));
		}

		if ($column_index == 6 || $column_index == 7) {
			$name = DB::table('cms_users')->where('id', $column_value)->value('name');
			$column_value = $name;
		}
	}

	public function hook_before_add(&$postdata)
	{
		$postdata['created_by'] = CRUDBooster::myId();
	}

	public function hook_before_edit(&$postdata, $id)
	{
		$postdata['updated_by'] = CRUDBooster::myId();
	}
}
