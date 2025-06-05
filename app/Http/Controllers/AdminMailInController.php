<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Carbon\Carbon;

class AdminMailInController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->col[] = ["label" => "Tech Accepted Date", "name" => "technician_accepted_at"];
		$this->col[] = ["label" => "Branch", "name" => "branch", 'join' => 'branch,branch_name'];
		# END COLUMNS DO NOT REMOVE THIS LINE

			$this->addaction = array();

			$this->addaction[] = [
				'title'   => 'Download Technical Report',
				'icon'    => 'fa fa-download',
				'url'     => CRUDBooster::mainpath('DownloadTechnicalReport/[id]'),
				'color'   => 'info',
			];

	}

	public function hook_query_index(&$query)
	{
		if (CRUDBooster::myPrivilegeId() == 3) {
			$query->whereIn('repair_status', [12, 21, 26, 47])->where('branch', CRUDBooster::me()->branch_id);
		} else {
			$query->whereIn('repair_status', [12, 21, 26 , 47 ]);
		}
	}

	 
		public function hook_row_index($column_index, &$column_value) {
		if ($column_index == 1) {

			$column_value = '<span class="label label-info">' . $column_value . '</span>';
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
			->leftJoin('cms_users as frontliner', 'frontliner.id', '=', 'returns_header.created_by')
			->leftJoin('cms_users as technician', 'technician.id', '=', 'returns_header.technician_id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group', 'frontliner.name as fl_name', 'technician.name as tech_name')
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
			->where('returns_body_item.returns_header_id', $id)
			->whereNotIn('returns_body_item.item_spare_additional_type', ['Additional-Required-No', 'Additional-Standard-DOA-No'])
			->get();

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
			->leftJoin('cms_users as frontliner', 'frontliner.id', '=', 'returns_header.created_by')
			->leftJoin('cms_users as technician', 'technician.id', '=', 'returns_header.technician_id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group', 'frontliner.name as fl_name', 'technician.name as tech_name')
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
			->where('returns_body_item.returns_header_id', $id)
			->whereNotIn('returns_body_item.item_spare_additional_type', ['Additional-Required-No', 'Additional-Standard-DOA-No'])
			->get();

		$data['defective_serial_numbers'] = DB::table('defective_serial_number')->where('returns_header_id', $id)->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
		$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
		$data['CallOutCount'] = DB::table('call_out_recorder')->where('returns_header_id', $id)->where('status_id', $data['transaction_details']->repair_status)->count();
		
		$latestCallOut = DB::table('call_out_recorder')
		->where('returns_header_id', $id)
		->where('status_id', $data['transaction_details']->repair_status)
		->orderBy('call_out_at', 'desc')
		->first();

		$lastCallOutDate = $latestCallOut ? Carbon::parse($latestCallOut->call_out_at) : null;

		if ($lastCallOutDate && $lastCallOutDate->diffInDays(Carbon::now()) >= 3) {
			$data['lastCallOutNotice'] = "Last call-out was " . $lastCallOutDate->diffInDays(Carbon::now()) . " days ago.";
		}

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

		// PRINT TECHNICAL REPORT FORM
	public function PrintTechnicalReport($id)
	{
		$data = array();
		$data['page_title'] = 'Print Technical Report';
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
			->leftJoin('cms_users', 'returns_header.updated_by', '=', 'cms_users.id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'cms_users.name as name', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'model_group')
			->where('returns_header.id', $id)->first();

		$data['diagnostic_result'] = DB::table('returns_diagnostic_test')
			->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			->where('returns_header_id', $data['transaction_details']->header_id)->get();

		$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			->select('returns_diagnostic_test.*', 'tech_testing.description as diagnostic_desc')
			->where('returns_diagnostic_test.returns_header_id', $data['transaction_details']->header_id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();
		$data['TechTestingResult'] = DB::table('tech_testing_result')->where('test_result_status', 'ACTIVE')->get();

		$data['Quotation'] = DB::table('returns_body_item')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->where('returns_body_item.cost', '!=', '0.00')
			->whereNotIn('returns_body_item.item_spare_additional_type', ['Additional-Required-No', 'Additional-Standard-DOA-No'])
			->where('returns_body_item.returns_header_id', $data['transaction_details']->header_id)->get();

		$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$this->cbView("print_form.fl_print_technical_report", $data);
	}


}