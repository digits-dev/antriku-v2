<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;

class AdminPartsItemMasterController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "10";
		$this->orderby = "id,asc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = true;
		$this->table = "parts_item_master";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Spare Parts", "name" => "spare_parts"];
		$this->col[] = ["label" => "Item Description", "name" => "item_description"];
		$this->col[] = ["label" => "Status", "name" => "gsx_item_status"];
		$this->col[] = ["label" => "Date Created", "name" => "created_at"];
		$this->col[] = ["label" => "Date Updated", "name" => "updated_at"];
		$this->col[] = ["label" => "Created By", "name" => "created_by"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Spare Parts', 'name' => 'spare_parts', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'Item Description', 'name' => 'item_description', 'type' => 'text', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'Status', 'name' => 'gsx_item_status', 'type' => 'select', 'validation' => 'required', 'width' => 'col-sm-7', 'dataenum' => 'ACTIVE;INACTIVE'];
		# END FORM DO NOT REMOVE THIS LINE

		if (CRUDBooster::isCreate() && in_array(CRUDBooster::myPrivilegeId(), [1])) {
			$currentUrl = url()->current();
			$partsCustomSync = CRUDBooster::mainpath('parts_manual_sync');

			// Only show buttons if we are NOT on either of these pages
			if ($currentUrl != $partsCustomSync) {
				$this->index_button[] = [
					"label" => "Sync Spare Parts",
					"icon" => "fa fa-spinner",
					"url" => $partsCustomSync,
					"color" => "warning"
				];
			}
		}
	}

	public function hook_query_index(&$query) {}

	public function hook_row_index($column_index, &$column_value)
	{
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

	public function partsManualSync()
	{
		$data = [];

		return $this->view('inventory.parts_manual_sync', $data);
	}
}
