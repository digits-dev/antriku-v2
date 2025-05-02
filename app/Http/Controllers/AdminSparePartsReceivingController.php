<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
		$this->col[] = ["label" => "Status", "name" => "repair_status"];
		$this->col[] = ["label" => "Reference No", "name" => "reference_no"];
		$this->col[] = ["label" => "Model Group", "name" => "model"];
		$this->col[] = ["label" => "Warranty Status", "name" => "warranty_status"];
		$this->col[] = ["label" => "Case Status", "name" => "case_status"];
		$this->col[] = ["label" => "Technician Assigned", "name" => "technician_id", 'join' => 'cms_users,name'];
		$this->col[] = ["label" => "Date Received", "name" => "technician_accepted_at"];
		$this->col[] = ["label" => "Branch", "name" => "branch", 'join' => 'branch,branch_name'];
		# END COLUMNS DO NOT REMOVE THIS LINE

	}

	public function hook_query_index(&$query)
	{
		$query->whereIn('repair_status', [26,33, 47])->orderBy('id', 'ASC');
	}

	public function hook_row_index($column_index, &$column_value)
	{
		$awaiting_apple_repair = DB::table('transaction_status')->where('id', '26')->first();
		$callout_ordering_spare_part = DB::table('transaction_status')->where('id', '33')->first();
		$for_tech_assessment_iw = DB::table('transaction_status')->where('id', '47')->first();

		if ($column_index == 1) {
			if ($column_value == $callout_ordering_spare_part->id) {
				$column_value = '<span class="label label-warning">' . $callout_ordering_spare_part->status_name . '</span>';
			}
			if ($column_value == $for_tech_assessment_iw->id) {
				$column_value = '<span class="label label-warning">' . $for_tech_assessment_iw->status_name . '</span>';
			}
			if ($column_value == $awaiting_apple_repair->id) {
				$column_value = '<span class="label label-warning">' . $awaiting_apple_repair->status_name . '</span>';
			}
		}

		if ($column_index == 3) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}
		if($column_index == 4){
			if($column_value == 'IN WARRANTY'){
				$column_value = '<span style="color: #00B74A"><strong>'.$column_value.'</strong></span>';
			}elseif($column_value == 'OUT OF WARRANTY'){
				$column_value = '<span style="color: #F93154"><strong>'.$column_value.'</strong></span>';
			}
		}

		if($column_index == 5){
			$column_value = '<span style="color: #1266F1"><strong>'.$column_value.'</strong></span>';
		}
		
	}

	public function cbView($template, $data)
	{
		$this->cbLoader();
		echo view($template, $data)->with('data', $data);
	}

	public function getDetail($id)
	{
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = [];
		$data['page_title'] = "Diagnose Transactions";
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group')
			->where('returns_header.id', $id)->first();

		$data['Comment'] = DB::table('returns_comments')
			->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			->where('returns_comments.returns_header_id', $id)->orderBy('comment_date', 'ASC')->get();

		$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			->select('returns_diagnostic_test.*', 'tech_testing.description as diagnostic_desc')
			->where('returns_diagnostic_test.returns_header_id', $id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();
		$data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			->where('returns_body_item.returns_header_id', $id)->get();

		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function getEdit($id)
	{
		if (!CRUDBooster::isUpdate() && $this->global_privilege == FALSE || $this->button_edit == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = [];
		$data['page_title'] = "Diagnose Transactions";
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group')
			->where('returns_header.id', $id)->first();

		$data['Comment'] = DB::table('returns_comments')
			->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			->where('returns_comments.returns_header_id', $id)->orderBy('comment_date', 'ASC')->get();

		$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			->select('returns_diagnostic_test.*', 'tech_testing.description as diagnostic_desc')
			->where('returns_diagnostic_test.returns_header_id', $id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();
		$data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			->where('returns_body_item.returns_header_id', $id)->get();

		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();
		$data['CallOutCount'] = DB::table('call_out_recorder')->where('returns_header_id', $id)->where('status_id', $data['transaction_details']->repair_status)->count();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function receiveSparePart(Request $request)
	{
		$spare_parts_id = $request->spare_parts_id;
		$header_id = $request->header_id;

		$get_item_if_exist = DB::table('returns_body_item')
			->where('returns_header_id', $header_id)
			->where('item_parts_id', $spare_parts_id)
			->where('qty_status', '!=', 'Available-DOA')
			->orderBy('id', 'DESC')
			->first();

		DB::beginTransaction();

		try {
			DB::table('parts_item_master')->where('id', $get_item_if_exist->item_parts_id)
				->update([
					'qty' => DB::raw('qty + 1'),
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);
			
				
			DB::table('returns_body_item')->where('id', $get_item_if_exist->id)
				->update([
					'qty' => DB::raw('qty + 1'),
					'qty_status' => 'Available',
					'item_spare_additional_type' => $get_item_if_exist->item_spare_additional_type == 'Additional-Standard-DOA' 
						? 'Additional-Standard-DOA-Yes' 
						: 'Additional-Required-Yes',
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			DB::table('inventory_reservations')->insert([
				'parts_item_master_id' => $spare_parts_id,
				'return_header_id' => $header_id,
				'reserved_qty' => 1,
				'created_by' => CRUDBooster::myId(),
				'created_at' => now(),
				'updated_at' => now(),
			]);

			DB::commit();
			return response()->json(['success' => true, 'message' => 'Spare part received successfully.']);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('Error receiving spare part: ' . $e->getMessage());
			return response()->json(['success' => false, 'message' => 'Failed to receive spare part.'], 500);
		}
	}
}