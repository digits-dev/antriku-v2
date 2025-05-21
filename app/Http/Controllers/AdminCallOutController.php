<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminCallOutController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table 			   = "returns_header";
		$this->title_field         = "last_name";
		$this->limit               = 20;
		$this->orderby             = "id,desc";
		$this->show_numbering      = FALSE;
		$this->global_privilege    = FALSE;
		$this->button_table_action = TRUE;
		$this->button_action_style = "button_icon";
		$this->button_add          = FALSE;
		$this->button_delete       = TRUE;
		$this->button_edit         = TRUE;
		$this->button_detail       = TRUE;
		$this->button_show         = TRUE;
		$this->button_filter       = TRUE;
		$this->button_export       = FALSE;
		$this->button_import       = FALSE;
		$this->button_bulk_action  = TRUE;
		$this->sidebar_mode		   = "normal"; //normal,mini,collapse,collapse-mini
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Status", "name" => "repair_status", 'join' => 'transaction_status,status_name'];
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
		if (CRUDBooster::myPrivilegeId() == 3) {
			$query->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48])->where('branch', CRUDBooster::me()->branch_id);
		} else {
			$query->whereIn('repair_status', [12, 13, 19, 21, 22, 26, 28, 33, 35, 38, 43, 45, 47, 48]);
		}
	}

	 
		public function hook_row_index($column_index, &$column_value) {
			if ($column_index == 1) {

				$cancelled = [
					'CALLOUT: FOR PICK UP BY CUSTOMER (CANCELLED – MAIL IN)',
					'CALLOUT: FOR PICK UP BY CUSTOMER (CANCELLED – CARRY IN)'
				];

				$labelClass = in_array($column_value, $cancelled) ? 'label-danger' : 'label-info';
				$column_value = '<span class="label ' . $labelClass . '">' . $column_value . '</span>';
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

		$data['defective_serial_numbers'] = DB::table('defective_serial_number')->where('returns_header_id', $id)->get();

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

		$data['defective_serial_numbers'] = DB::table('defective_serial_number')->where('returns_header_id', $id)->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
		$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
		$data['CallOutCount'] = DB::table('call_out_recorder')->where('returns_header_id', $id)->where('status_id', $data['transaction_details']->repair_status)->count();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function callOut(Request $request)
	{

		$returns_header = DB::table('returns_header')->where('id', $request->returns_header_id)->first();
		$branch = DB::table('branch')->where('id', CRUDBooster::me()->branch_id)->value('branch_name');
		$call_out = DB::table('call_out_recorder')->where('returns_header_id', $request->returns_header_id)->where('status_id', $request->status_id)->first();
		
		$data = [];
		$data['reference_no'] = $returns_header->reference_no;
		$data['frontliner'] = CRUDBooster::me()->name;
		$data['branch'] = $branch;
		$data['amount'] = $returns_header->parts_total_cost + $returns_header->diagnostic_cost;
		$email = $returns_header->email;
		
		if (in_array($request->status_id, [12,21])) {
		$template = $call_out ? 'waiting_for_approval_update' : 'waiting_for_approval';

			CRUDBooster::sendEmail([
				'to' => $email,
				'data' => $data,
				'template' => $template,
				'attachments' => []
			]);
		}else if ($request->status_id == 47) {
		$template = $call_out ? 'mail_in_awaiting_parts_update' : 'mail_in_awaiting_parts';

			CRUDBooster::sendEmail([
				'to' => $email,
				'data' => $data,
				'template' => $template,
				'attachments' => []
			]);
		}
		//  else {
		// 	CRUDBooster::sendEmail(['to'=>$email,'data'=>$data, 'template'=>'under_monitoring','attachments'=>[]]);
		// }
		
		$callOut = DB::table('call_out_recorder')->insert([
			'status_id' => $request->status_id,
			'returns_header_id' => $request->returns_header_id,
			'call_out_by' => CRUDBooster::myId(),
			'call_out_at' => now(),
		]);


		
		if ($callOut) {
			return response()->json(['message' => 'Call out recorded successfully'], 200);
		} else {
			return response()->json(['message' => 'Failed to record call out'], 500);
		}
	}

	public function refund($id)
	{
		$header = DB::table('returns_header')->where('id', $id)->first();
		$items = DB::table('returns_body_item')->where('returns_header_id', $id)->get();

		return response()->json([
			'diagnostic_cost' => $header->diagnostic_cost,
			'items' => $items
		]);
	}

		public function updateRefund(Request $request)
		{
			// Update diagnostic_cost by subtracting the refunded value
			DB::table('returns_header')
				->where('id', $request->header_id)
				->decrement('diagnostic_cost', $request->diagnostic_cost);

			// Subtract refunded cost from each item's cost
			foreach ($request->items as $item) {
				$original = DB::table('returns_body_item')
					->where('id', $item['id'])
					->value('cost');

				$newCost = $original - $item['cost'];

				DB::table('returns_body_item')
					->where('id', $item['id'])
					->update(['cost' => $newCost]);
			}

			return response()->json(['status' => 'success']);
		}


}