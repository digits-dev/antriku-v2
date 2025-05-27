<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AdminToDiagnoseController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->button_edit         = FALSE;
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

		$this->addaction = array();

		if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])) {
			$this->addaction[] = [
				'title'   => 'Accept Job',
				'icon'    => 'fa fa-check',
				'url'     => 'javascript:handleAcceptJob([id])',
				'color'   => 'success',
				'showIf'  => '[repair_status] == 1',
			];
			$this->addaction[] = [
				'title'   => 'Edit Data',
				'url'   => CRUDBooster::mainpath('edit/[id]'),
				'icon'  => 'fa fa-pencil',
				'color' => 'success',
				'showIf'  => '[repair_status] != 1',
			];
		}


		// $this->button_selected = array();
		// $this->button_selected[] = ['label' => 'Print Receive Form', 'icon' => 'fa fa-print', 'name' => 'print_receive_form'];
		// $this->button_selected[] = ['label' => 'Print Technical Report', 'icon' => 'fa fa-print', 'name' => 'print_technical_report'];
		// $this->button_selected[] = ['label' => 'Print Same Day Release Form', 'icon' => 'fa fa-print', 'name' => 'print_sameday_release_form'];

		$this->index_button = array();
		if (CRUDBooster::myPrivilegeId() == 4) {
			$this->index_button[] = ["title" => "Assigned To You", "label" => "Show Your Works", "icon" => "fa fa-list", "url" => CRUDBooster::mainpath('AssignedTechnician')];
		}

		$this->script_js = "
			function handleSwal(id, reference_no, technician_id) {
				assignTechnician(id, reference_no, technician_id);
			}
			function handleAcceptJob(id) {
				acceptJob(id);
			}
		";

		$this->post_index_html = '
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script src="' . asset('js/jobActions.js') . '"></script>
		';

		$this->style_css = "
			.swal2-popup {
				font-size: 1.3rem !important;
			}
		";
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

	public function hook_query_index(&$query)
	{
		//Your code here

		if (CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6) {
			$query->whereIn('repair_status', [1, 10, 14, 17, 18, 20,23,27])->where('print_receive_form', 'YES')->orderBy('id', 'ASC');
		} else if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])) {
			$query->whereIn('repair_status', [1, 10, 14, 17, 18, 20,23,27])->where('print_receive_form', 'YES')->where('technician_id', CRUDBooster::myId())->orderBy('id', 'ASC');
		} 
	}

	public function hook_row_index($column_index, &$column_value)
	{
		if ($column_index == 1) {

			$column_value = '<span class="label label-warning">' . $column_value . '</span>';
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

	// CHANGE TRANSACTION STATUS
	public function changeTransactionStatus(Request $request)
	{
		$all_data = array();
		parse_str($request->all_data, $all_data);

		$transaction_details = DB::table('returns_header')->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status')
			->where('returns_header.id', $all_data['header_id'])->get();
		if (CRUDBooster::getModulePath() == 'to_diagnose') {
			$all_cost = explode(",", $all_data['cost']);
			$total_cost = 0;
			foreach ($all_cost as $ac) {
				$total_cost += intval($ac);
			}

			$parts_total_cost = $total_cost;

			DB::table('returns_header')->where('id', $all_data['header_id'])->update([
				'parts_total_cost'			=> number_format($parts_total_cost, 2, '.', ''),
				'updated_by' 				=> CRUDBooster::myId()
			]);
		}

		if ($transaction_details[0]->repair_status == 10) {
			$ProblemDetails = implode(",", $all_data['problem_details']);
			DB::table('returns_header')->where('id', $all_data['header_id'])->update([
				'warranty_expiration_date' 	=> date('Y-m-d', strtotime($all_data['warranty_expiration_date'])),
				'problem_details'			=> $ProblemDetails,
				'problem_details_other'		=> $all_data['problem_details_other'],
				'other_remarks'		        => $all_data['other_remarks'],
				'case_status'				=> $all_data['case_status'],
				'warranty_status' 			=> $all_data['warranty_status'],
				'findings' 					=> $all_data['findings'],
				'resolution' 				=> $all_data['resolution'],
				'other_diagnostic'			=> $all_data['other_diagnostic'],
				'updated_by'            	=> CRUDBooster::myId()
			]);

			// ******************************For Diagnostic Test*******************************
			$diagnosticTest = "";
			$diagnosticId = implode(",", $all_data['test_result_id']);
			for ($b = 0; $b < count($all_data['test_result_id']); $b++) {
				$testId = 'test_result_' . $all_data['test_result_id'][$b];
				if ($b == count($all_data['test_result_id']) - 1) {
					$diagnosticTest .= $all_data[$testId];
				} else {
					$diagnosticTest .= $all_data[$testId] . ",";
				}
			}

			$Test_Type = DB::table('returns_diagnostic_test')->where('returns_header_id', $all_data['header_id'])->first();
			if (!empty($Test_Type)) {
				DB::table('returns_diagnostic_test')->where('returns_header_id', $all_data['header_id'])->update([
					'returns_header_id' 		=> $all_data['header_id'],
					'test_type'					=> $diagnosticId,
					'test_result' 				=> $diagnosticTest,
					'updated_by' 				=> CRUDBooster::myId()
				]);
			} else {
				DB::table('returns_diagnostic_test')->insert([
					'returns_header_id' 		=> $all_data['header_id'],
					'test_type'					=> $diagnosticId,
					'test_result' 				=> $diagnosticTest,
					'created_by' 				=> CRUDBooster::myId(),
					'updated_by' 				=> CRUDBooster::myId()
				]);
			}
			
			DB::table('defective_serial_number')->where('returns_header_id', $all_data['header_id'])->delete();

			foreach ($all_data['kbb_name'] as $key => $kbb) {
				$kbb = trim($kbb);
				$serial = trim($all_data['serial_number'][$key]);
			
				if ($kbb === '' && $serial === '') {
					continue;
				}
			
				DB::table('defective_serial_number')->insert([
					'returns_header_id'        => $all_data['header_id'],
					'defective_kbb_name'       => $kbb,
					'defective_serial_number'  => $serial,
				]);
			}
			

		}

		if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])) {

			$ProblemDetails = implode(",", $all_data['problem_details']);
			DB::table('returns_header')->where('id', $all_data['header_id'])->update([
				'problem_details'			=> $ProblemDetails,
				'problem_details_other'		=> $all_data['problem_details_other'],
				'other_remarks'		        => $all_data['other_remarks'],
				'findings' 					=> $all_data['findings'],
				'resolution' 				=> $all_data['resolution'],
				'updated_by'            	=> CRUDBooster::myId()
			]);
	
		}
		
			// *********************************************************************************
		

		// ***************************************For Quotation*********************************
		$row_id = explode(",", $all_data['row_id']);
		$service_code = explode(",", $all_data['service_code']);
		$gsx_ref = explode(",", $all_data['gsx_ref']);
		$cs_code = explode(",", $all_data['cs_code']);
		$serial_no = explode(",", $all_data['serial_no']);
		$item_desc = explode(",", $all_data['item_desc']);
		$cost = explode(",", $all_data['cost']);

		if (in_array(!null, $gsx_ref)) {
			$gsx_status = 'YES';
		} else {
			$gsx_status = 'NO';
		}

		if (in_array(!null, $serial_no)) {
			$serial_status = 'YES';
		} else {
			$serial_status = 'NO';
		}

		DB::table('returns_header')->where('id', $all_data['header_id'])->update([
			'gsx_status'		=> $gsx_status,
			'serial_status'		=> $serial_status,
			'updated_by'		=> CRUDBooster::myId()
		]);

		for ($i = 0; $i <= $all_data['number_of_rows']; $i++) {
			if (!empty($service_code[$i]) || !empty($gsx_ref[$i]) || !empty($cs_code[$i]) || !empty($serial_no[$i]) || !empty($item_desc[$i]) || !empty($cost[$i])) {
				$bodyItem = DB::table('returns_body_item')->where('returns_header_id', $all_data['header_id'])->where('service_code', $service_code[$i])->first();
				$returnsHeader = DB::table('returns_header')->where('id', $all_data['header_id'])->first();
				$parts_item_description = DB::table('parts_item_master')
					->select('parts_item_master.*', 'bis.stock_qty')
					->leftJoin('branch_item_stocks as bis', 'bis.parts_item_master_id', '=', 'parts_item_master.id')
					->where('bis.branch_id', $returnsHeader->branch)
					->where('spare_parts', trim($service_code[$i]))
					->get();
				$item_spare_additional_type = (!empty($all_data['new_spare_req']) && $all_data['new_spare_req'] == 'Additional-Required-Pending') ? 'Additional-Required-Pending' : 'Additional-Standard';

				if (!empty($bodyItem->id) && !empty($service_code[$i])) {

					DB::table('returns_body_item')->where('id', $row_id[$i])->update([
						'service_code'		=> $service_code[$i],
						'gsx_ref'			=> $gsx_ref[$i],
						'cs_code'			=> $cs_code[$i],
						'item_description'	=> $parts_item_description[0]->item_description,
						'item_parts_id'		=> $parts_item_description[0]->id,
						'cost'				=> $cost[$i],
						'updated_by'		=> CRUDBooster::myId()
					]);

					$existing = DB::table('returns_serial')
						->where('returns_header_id', $all_data['header_id'])
						->where('returns_body_item_id', $row_id[$i])
						->first();

					if ($existing) {
						// Update if exists
						DB::table('returns_serial')
							->where('returns_header_id', $all_data['header_id'])
							->where('returns_body_item_id', $row_id[$i])
							->update([
								'serial_number' => $serial_no[$i],
								'updated_by'    => CRUDBooster::myId()
							]);
					} else {
						// Insert if not exists
						DB::table('returns_serial')->insert([
							'returns_header_id'    => $all_data['header_id'],
							'returns_body_item_id'=> $row_id[$i],
							'serial_number'        => $serial_no[$i],
							'created_by'           => CRUDBooster::myId(),
							'updated_by'           => CRUDBooster::myId()
						]);
					}

				} else if (empty($bodyItem->id) && !empty($service_code[$i])) {
					$bodyItemID = DB::table('returns_body_item')->insertGetId([
						'returns_header_id'	=> $all_data['header_id'],
						'service_code'		=> $service_code[$i],
						'gsx_ref'			=> $gsx_ref[$i],
						'cs_code'			=> $cs_code[$i],
						'item_description'	=> $parts_item_description[0]->item_description,
						'qty'				=> $parts_item_description[0]->stock_qty,
						'qty_status'		=> $parts_item_description[0]->stock_qty > 0 ? 'Available' : 'Unavailable',
						'item_parts_id'		=> $parts_item_description[0]->id,
						'item_spare_additional_type' => $item_spare_additional_type,
						'cost'				=> $cost[$i],
						'created_by'		=> CRUDBooster::myId(),
						'updated_by'		=> CRUDBooster::myId()
					]);
					DB::table('returns_serial')->insert([
						'returns_header_id'   	=> $all_data['header_id'],
						'returns_body_item_id'	=> $bodyItemID,
						'serial_number'			=> $serial_no[$i],
						'created_by'			=> CRUDBooster::myId(),
						'updated_by'			=> CRUDBooster::myId()
					]);
				}
			}
		}

		// *********************************************************************************************

		$status_array = [1, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 33, 34, 35, 38, 39, 40, 41, 42, 43, 45, 47, 48];
		    if(in_array($request->status_id, $status_array)){
			DB::table('returns_header')->where('id', $request->header_id)->update([
				'repair_status' 			=> $request->status_id,
				'updated_by'            	=> CRUDBooster::myId()
			]);
			DB::table('job_order_logs')->insert([
			'returns_header_id' 		=> $request->header_id,
			'status_id'            		=> $request->current_status,
			'transacted_by'            	=>  CRUDBooster::myId(),
			'transacted_at'            	=>  now()
			]);

		}

		if (in_array($request->status_id, [16, 25])) {
			DB::table('returns_header')->where('id', $request->header_id)->update([
				'airwaybill_tn'   => $all_data['airwaybill_tn'],
			]);
		}

		if (in_array($request->status_id, [17, 26])) {
			if ($request->hasFile('waybill')) {
				$file = $request->file('waybill');
				$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName();
				$path = $file->storeAs('public/waybill_upload', $filename);

				DB::table('returns_header')->where('id', $request->header_id)->update([
					'airwaybill_upload'   => $filename,
				]);
			}
		}

		if (in_array($request->status_id, [19, 28])) {
			$header_data = DB::table('returns_header')->where('id', $request->header_id)->first();

			if ($header_data && $header_data->case_status == 'CARRY-IN') {
				$get_jo_body_item = DB::table('returns_body_item')
					->where('returns_header_id', $request->header_id)
					->whereIn('item_spare_additional_type', ['Additional-Required-Pending', 'Additional-Standard-DOA'])
					->get();

					
					foreach ($get_jo_body_item as $per_item) {
						DB::table('returns_body_item')->where('id', $per_item->id)
						->update([
							'item_spare_additional_type' => $per_item->item_spare_additional_type == 'Additional-Required-Pending' 
							? 'Additional-Required-No' : 'Additional-Standard-DOA-No',
							'cost' => '0.00',
							'updated_by' => CRUDBooster::myId(),
							'updated_at' => now(),
						]);
						
					$get_existing_jo_body_item = DB::table('returns_body_item')
						->where('returns_header_id', $per_item->returns_header_id)
						->where('item_parts_id', $per_item->item_parts_id)
						->where('qty_status', '=', 'DOA')
						->get();

					foreach ($get_existing_jo_body_item as $existing_item) {
						DB::table('returns_body_item')->where('id', $existing_item->id)
							->update([
								'cost' => $per_item->cost,
								'updated_by' => CRUDBooster::myId(),
								'updated_at' => now(),
							]);
					}
				}
			}

		}

		if ($request->status_id == 21) {
			
			DB::table('returns_header')->where('id', $request->header_id)->update([
				'warranty_status'   => $all_data['warranty_status'],
				'warranty_changed_at' => now(),
			]);
		
		}

		if (in_array($request->status_id, [22, 23, 39, 40]) && !in_array($all_data['recent_treansaction_status'], [45, 43, 42])) {
			if ($request->hasFile('rpf_invoice')) {
				$file = $request->file('rpf_invoice');
				$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName() ;
				$path = $file->storeAs('public/rpf_invoice', $filename);
				
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'rpf_invoice'   => $filename,
				]);
			}
		}

		if (in_array($request->status_id, [29,30,39,40]) && !in_array($all_data['recent_treansaction_status'], [33, 45])) {

			$get_order_branch = DB::table('returns_header')->where('id', $request->header_id)->first();

			if(in_array($all_data['recent_treansaction_status'], [34, 35, 42, 43])){
				$get_jo = DB::table('returns_body_item')
					->where('returns_header_id', $request->header_id)
					->whereIn('item_spare_additional_type', ['Additional-Required-Pending', 'Additional-Standard-DOA'])
					->get();
			} else {
				$get_jo = DB::table('returns_body_item')
					->where('returns_header_id', $request->header_id)
					->get();
			}
		
			$additionalStandard = [];
			$additionalPending = [];
			$additionalStandardDOA = [];
		
			foreach ($get_jo as $item) {
				if ($item->qty_status == 'Available') {
					if ($item->item_spare_additional_type == 'Additional-Standard') {
						$additionalStandard[] = $item;
					} elseif ($item->item_spare_additional_type == 'Additional-Required-Pending') {
						$additionalPending[] = $item;
					} elseif ($item->item_spare_additional_type == 'Additional-Standard-DOA') {
						$additionalStandardDOA[] = $item;
					}
				}
			}
		
			if (count($additionalPending) > 0) {
				// Reserve "Additional-Required-Pending" only
				foreach ($additionalPending as $item) {
					DB::table('inventory_reservations')->insert([
						'branch_id' 		   => $get_order_branch->branch,
						'parts_item_master_id' => $item->item_parts_id,
						'return_header_id'     => $request->header_id,
						'reserved_qty'         => 1,
						'created_by'           => CRUDBooster::myId(),
						'created_at'           => now(),
					]);
		
					DB::table('returns_body_item')->where('id', $item->id)->update([
						'item_spare_additional_type' => 'Additional-Required-Yes',
						'updated_by' => CRUDBooster::myId(),
						'updated_at' => now(),
					]);
				}
			} elseif (count($additionalStandardDOA) > 0) {
				// Corrected loop: reserve "Additional-Standard-DOA"
				foreach ($additionalStandardDOA as $item) {
					DB::table('inventory_reservations')->insert([
						'branch_id' 		   => $get_order_branch->branch,
						'parts_item_master_id' => $item->item_parts_id,
						'return_header_id'     => $request->header_id,
						'reserved_qty'         => 1,
						'created_by'           => CRUDBooster::myId(),
						'created_at'           => now(),
					]);
		
					DB::table('returns_body_item')->where('id', $item->id)->update([
						'item_spare_additional_type' => 'Additional-Standard-DOA-Yes',
						'updated_by' => CRUDBooster::myId(),
						'updated_at' => now(),
					]);
				}
			} else {
				// Reserve all the available qty with "Additional-Standard"
				foreach ($additionalStandard as $item) {
					DB::table('inventory_reservations')->insert([
						'branch_id' 		   => $get_order_branch->branch,
						'parts_item_master_id' => $item->item_parts_id,
						'return_header_id'     => $request->header_id,
						'reserved_qty'         => 1,
						'created_by'           => CRUDBooster::myId(),
						'created_at'           => now(),
					]);
				}
			}
		}			

		if (in_array($request->status_id, [31,41])) {

			
			DB::beginTransaction();
			
			try {
				$get_order_branch = DB::table('returns_header')->where('id', $request->header_id)->first();
				$get_reservation_per_jo = DB::table('inventory_reservations')
					->where('return_header_id', $request->header_id)
					->where('status', '=', 'Pending')
					->get();

				foreach ($get_reservation_per_jo as $item) {
					DB::table('branch_item_stocks')
						->where('parts_item_master_id', $item->parts_item_master_id)
						->where('branch_id', $get_order_branch->branch)
						->update([
							'stock_qty' => DB::raw('stock_qty - ' . $item->reserved_qty),
							'updated_by' => CRUDBooster::myId(),
							'updated_at' => now(),
						]);

					DB::table('inventory_reservations')
						->where('id', $item->id)
						->where('branch_id', $get_order_branch->branch)
						->update([
							'status' => 'Confirmed / Deducted',
							'updated_at' => now(),
						]);
				}

				DB::commit();
			} catch (\Exception $e) {
				DB::rollBack();
			}
		}
		

		return ($all_data);
	}

	public function saveFinalInvoice(Request $request)
	{
		if ($request->hasFile('final_invoice')) {
			$file = $request->file('final_invoice');
			$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName();
			$path = $file->storeAs('public/final_invoice', $filename);

			DB::table('returns_header')->where('id', $request->header_id)->update([
				'final_invoice'   => $filename,
			]);
		}

		return response()->json(['success' => true, 'message' => 'Final invoice saved successfully.']);
	}


	// ADD ROW IN QUOTATION
	public function AddQuotation(Request $request)
	{
		$data = array();
		if (!empty($request->service_code)) {
			$service_code = $request->service_code;
		} else {
			$service_code = '';
		}
		if (!empty($request->gsx_ref)) {
			$gsx_ref = $request->gsx_ref;
		} else {
			$gsx_ref = '';
		}
		if (!empty($request->cs_code)) {
			$cs_code = $request->cs_code;
		} else {
			$cs_code = '';
		}
		if (!empty($request->serial_no)) {
			$serial_no = $request->serial_no;
		} else {
			$serial_no = '';
		}
		if (!empty($request->item_desc)) {
			$item_desc = $request->item_desc;
		} else {
			$item_desc = '';
		}
		if (!empty($request->qty)) {
			$qty = $request->qty;
		} else {
			$qty = '0';
		}
		if (!empty($request->item_parts_id)) {
			$item_parts_id = $request->item_parts_id;
		} else {
			$item_parts_id = '999999999';
		}
		if (!empty($request->cost)) {
			$cost = $request->cost;
		} else {
			$cost = '';
		}
		if (!empty($request->transaction_status)) {
			$transaction_status = $request->transaction_status;
		} else {
			$transaction_status = '';
		}

		if($request->doa_jo == 'yes') {
			DB::table('returns_body_item')->where('returns_header_id', $request->id)
			->where('item_parts_id', $item_parts_id)->update([
				'qty_status' => 'DOA',
				'cost'		 => '0.00',
				'updated_by' => CRUDBooster::myId(),
				'updated_at' => now(),
			]);
		}

		$bodyItemID = DB::table('returns_body_item')->insertGetId([
			'returns_header_id'	=> $request->id,
			'service_code'		=> $service_code,
			'gsx_ref'			=> $gsx_ref,
			'cs_code'			=> $cs_code,
			'item_description'	=> $item_desc,
			'qty'				=> $qty,
			'qty_status'		=> $qty > 0 ? 'Available' : 'Unavailable',
			'item_parts_id'		=> $item_parts_id,
			'item_spare_additional_type' => in_array($transaction_status, [34, 42]) ? ($request->doa_jo == 'yes' ? 'Additional-Standard-DOA' : 'Additional-Required-Pending'): 'Additional-Standard',
			'cost'				=> $cost,
			'created_by'		=> CRUDBooster::myId(),
			'updated_by'		=> CRUDBooster::myId()
		]);

		DB::table('returns_serial')->insert([
			'returns_header_id'   	=> $request->id,
			'returns_body_item_id'	=> $bodyItemID,
			'serial_number'			=> $serial_no,
			'created_by'			=> CRUDBooster::myId(),
			'updated_by'			=> CRUDBooster::myId()
		]);

		$data['quotation'] = DB::table('returns_body_item')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			->where('returns_body_item.returns_header_id', $request->id)->where('returns_serial.returns_header_id', $request->id)
			->where('returns_serial.returns_body_item_id', $bodyItemID)->first();

		return ($data);
	}

	// DELETE ROW IN QUOTATION
	public function DeleteQuotation(Request $request)
	{
		$data = array();

		DB::beginTransaction();

		try {
			$item = DB::table('returns_body_item')->where('id', $request->id)->first();

			if ($item && $item->item_spare_additional_type === 'Additional-Standard-DOA') {
				$item_to_update = DB::table('returns_body_item')
					->where('returns_header_id', $item->returns_header_id)
					->where('item_parts_id', $item->item_parts_id)
					->where('item_spare_additional_type', '!=', 'Additional-Standard-DOA')
					->orderBy('id', 'DESC')
					->first();

				$item_to_return = DB::table('returns_body_item')
					->where('returns_header_id', $item->returns_header_id)
					->where('item_parts_id', $item->item_parts_id)
					->where('item_spare_additional_type', '=', 'Additional-Standard-DOA')
					->orderBy('id', 'DESC')
					->first();

				DB::table('returns_body_item')
					->where('id', $item_to_update->id)
					->update([
						'qty_status' => 'Available',
						'doa_problem_desc' => null,
						'cost' => $item_to_return->cost,
						'updated_by' => CRUDBooster::myId(),
						'updated_at' => now(),
					]);
			}

			DB::table('returns_body_item')->where('id', $request->id)->delete();
			DB::table('returns_serial')->where('returns_body_item_id', $request->id)->delete();

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('DeleteQuotation failed: ' . $e->getMessage());
		}

		return ($data);
	}

	// checking if gsx is existing
	public function CheckGSX(Request $request)
	{
		$getJO = DB::table('returns_header')->where('id', $request->header_id)->first();

		$data = DB::table('parts_item_master as pim')
			->select('pim.*', 'bis.stock_qty')
			->leftJoin('branch_item_stocks as bis', 'bis.parts_item_master_id', '=', 'pim.id')
			->where('bis.branch_id', $getJO->branch)
			->where('bis.status', '=', 'ACTIVE')
			->where('pim.spare_parts', $request->gsx)
			->get()
			->map(function ($item) use ($getJO) {
				// Get total "Pending" reservation qty
				$pendingReservedQty = DB::table('inventory_reservations')
					->where('branch_id', $getJO->branch)
					->where('parts_item_master_id', $item->id)
					->where('status', 'Pending')
					->sum('reserved_qty');

				// Subtract pending reserved qty from current qty
				$item->stock_qty = max(0, $item->stock_qty - $pendingReservedQty);

				return $item;
			});

		return $data;
	}

	// checking if search spare part number
	public function SearchSparePartNo(Request $request)
	{
		$get_jo = DB::table('returns_header')->where('id', $request->header_id)->first();

		$data = DB::table('parts_item_master as pim')
			->leftJoin('branch_item_stocks as bis', 'bis.parts_item_master_id', '=', 'pim.id')
			->where('pim.spare_parts', 'like', '%' . $request->spare_part . '%')
			->where('bis.branch_id', $get_jo->branch)
			->where('bis.status', '=', 'ACTIVE')
			->get();
		return ($data);
	}

	public function AcceptJob(Request $request)
	{
		try {
			DB::table('returns_header')->where('id', $request->id)->update([
				// to ongoing diagnosis
				'repair_status' => 10,
				'technician_accepted_at' => date('Y-m-d H:i:s'),
			]);

			$latestAssignment = DB::table('case_assignments')
				->where('returns_header_id', $request->id)
				->latest('id') // Gets the latest entry based on ID
				->first();

			if ($latestAssignment) {
				// Update the latest assignment by setting end_date
				DB::table('case_assignments')
					->where('id', $latestAssignment->id)
					->update(['accepted_date' => now()]);
			}
		} catch (\Exception $e) {
			Log::error('Error Accepting Job: ' . $e->getMessage());
			return response()->json(['success' => false]);
		}

		return response()->json(['success' => true]);
	}
}