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
		if (CRUDBooster::myPrivilegeId() == 3) {
			$query->whereIn('repair_status', [12, 33, 35, 19,21,47])->where('branch', CRUDBooster::me()->branch_id);
		} else {
			$query->whereIn('repair_status', [12, 33, 35, 19,21,47]);
		}
	}

	 
	    public function hook_row_index($column_index,&$column_value) {	 
			$callout_awaiting_customer_approval_mail_in = DB::table('transaction_status')->where('id','12')->first();
			$for_spare_parts_release_carry_in = DB::table('transaction_status')->where('id','18')->first();
			$awaiting_customer_pick_up_good_for_unit = DB::table('transaction_status')->where('id','19')->first();
			$callout_awaiting_customer_approval_mail_in_oow = DB::table('transaction_status')->where('id','21')->first();
			$for_tech_assessment_iw = DB::table('transaction_status')->where('id', '47')->first();
			$callout_additional_spare_part_carry_in = DB::table('transaction_status')->where('id', '35')->first();
			$callout_ordering_spare_part = DB::table('transaction_status')->where('id', '33')->first();

	    
			if($column_index == 1){
				if($column_value == $callout_awaiting_customer_approval_mail_in->id){
					$column_value = '<span class="label label-info">'.$callout_awaiting_customer_approval_mail_in->status_name.'</span>';
				}
				if($column_value == $for_spare_parts_release_carry_in->id){
					$column_value = '<span class="label label-info">'.$for_spare_parts_release_carry_in->status_name.'</span>';
				}
				if($column_value == $callout_awaiting_customer_approval_mail_in_oow->id){
					$column_value = '<span class="label label-info">'.$callout_awaiting_customer_approval_mail_in_oow->status_name.'</span>';
				}
				if($column_value == $for_tech_assessment_iw->id){
					$column_value = '<span class="label label-info">'.$for_tech_assessment_iw->status_name.'</span>';
				}
				if($column_value == $callout_additional_spare_part_carry_in->id){
					$column_value = '<span class="label label-info">'.$callout_additional_spare_part_carry_in->status_name.'</span>';
				}
				if($column_value == $awaiting_customer_pick_up_good_for_unit->id){
					$column_value = '<span class="label label-info">'.$awaiting_customer_pick_up_good_for_unit->status_name.'</span>';
				}
				if($column_value == $callout_ordering_spare_part->id){
					$column_value = '<span class="label label-info">'.$callout_ordering_spare_part->status_name.'</span>';
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

			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
			$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			$data['CallOutCount'] = DB::table('call_out_recorder')->where('returns_header_id', $id)->where('status_id', $data['transaction_details']->repair_status)->count();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function callOut(Request $request)
	{
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
}