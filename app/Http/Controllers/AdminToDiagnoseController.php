<?php namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
	

	class AdminToDiagnoseController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->col[] = ["label"=>"Status","name"=>"repair_status"];
			$this->col[] = ["label"=>"Reference No","name"=>"reference_no"];
			$this->col[] = ["label"=>"Model Group","name"=>"model"];
			$this->col[] = ["label"=>"Technician Assigned","name"=>"technician_id", 'join' => 'cms_users,name'];
			$this->col[] = ["label"=>"Date Received","name"=>"technician_accepted_at"];
			$this->col[] = ["label"=>"Branch","name"=>"branch", 'join' => 'branch,branch_name' ];
	        $this->addaction = array();

			if (in_array(CRUDBooster::myPrivilegeId(), [4,8])) {
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
					'showIf'  => '[repair_status] == 9 or [repair_status] == 16',
				];
			}

			$this->button_selected = array();
			$this->button_selected[] = ['label'=>'Print Receive Form', 'icon'=>'fa fa-print', 'name'=>'print_receive_form'];
			$this->button_selected[] = ['label'=>'Print Technical Report', 'icon'=>'fa fa-print', 'name'=>'print_technical_report'];
 			//$this->button_selected[] = ['label'=>'Print Release Form', 'icon'=>'fa fa-print', 'name'=>'print_release_form'];
			$this->button_selected[] = ['label'=>'Print Same Day Release Form', 'icon'=>'fa fa-print', 'name'=>'print_sameday_release_form'];


	        $this->index_button = array();
			if(CRUDBooster::myPrivilegeId() == 4){
				$this->index_button[] = ["title"=>"Assigned To You","label"=>"Show Your Works","icon"=>"fa fa-list","url"=>CRUDBooster::mainpath('AssignedTechnician')];
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
				<script src="'.asset('js/jobActions.js').'"></script>
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
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE) {    
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = "Diagnose Transactions";
			$data['transaction_details'] = DB::table('returns_header')
				->leftJoin('model', 'returns_header.model', '=', 'model.id')
				->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
				->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group')
				->where('returns_header.id',$id)->first();

			$data['Comment'] = DB::table('returns_comments')
				->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
				->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
				->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
				->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'ASC')->get();

			$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
				->where('returns_diagnostic_test.returns_header_id',$id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			$data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
				->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
				->where('returns_body_item.returns_header_id',$id)->get();

			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
			$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			
			$this->cbView('transaction_details.view_created_transaction_detail',$data);
		}

		public function getEdit($id) 
		{
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			  	CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = "Diagnose Transactions";
			$data['transaction_details'] = DB::table('returns_header')
				->leftJoin('model', 'returns_header.model', '=', 'model.id')
				->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
				->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'software_fee', 'model_group')
				->where('returns_header.id',$id)->first();

			$data['Comment'] = DB::table('returns_comments')
				->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
				->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
				->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
				->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'ASC')->get();

			$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
				->where('returns_diagnostic_test.returns_header_id',$id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			$data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
				->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
				->where('returns_body_item.returns_header_id',$id)->get();

			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
			$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();

			$this->cbView('transaction_details.view_created_transaction_detail',$data);
		}

	    public function hook_query_index(&$query) {
			//Your code here
		
			if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6){
			    $query->whereIn('repair_status', [1,9,16,23])->where('print_receive_form', 'YES')->orderBy('id', 'ASC'); 
			}else if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])){
				$query->whereIn('repair_status', [1,9,16,23])->where('print_receive_form', 'YES')->where('technician_id', CRUDBooster::myId())->orderBy('id', 'ASC');
			}
			else{
			    $query->where('repair_status', 1)->where('branch', CRUDBooster::me()->branch_id); 
				if(!empty(Session::get('toggle')) && Session::get('toggle') == "ON")
				{
					$query->where('updated_by', CRUDBooster::me()->id)->orderBy('id', 'ASC'); 
				}else{
					// $query->where('branch', CRUDBooster::me()->branch_id)->orderBy('id', 'ASC'); 
					$query->orderBy('id', 'ASC'); 
				}
			}
		
	    }
 
		public function hook_row_index($column_index,&$column_value) 
		{	        
			//Your code here
			$pending = DB::table('transaction_status')->where('id','1')->first();
			$to_pay = DB::table('transaction_status')->where('id','2')->first();
			$rejected = DB::table('transaction_status')->where('id','3')->first();
			$repair_in_process = DB::table('transaction_status')->where('id','4')->first();
			$void = DB::table('transaction_status')->where('id','5')->first();
			$complete = DB::table('transaction_status')->where('id','6')->first();
			$pick_up = DB::table('transaction_status')->where('id','7')->first();
			$ongoing_diagnosis = DB::table('transaction_status')->where('id','9')->first();
			$shipped_mail_in = DB::table('transaction_status')->where('id','16')->first();

			if($column_index == 1){
				if($column_value == $pending->id){
					$column_value = '<span class="label label-warning">'.$pending->status_name.'</span>';
				}elseif($column_value == $to_pay->id){
					$column_value = '<span class="label label-warning">'.$to_pay->status_name.'</span>';
				}elseif($column_value == $rejected->id){
					$column_value = '<span class="label label-danger">'.$rejected->status_name.'</span>';
				}elseif($column_value == $repair_in_process->id){
					$column_value = '<span class="label label-success">'.$repair_in_process->status_name.'</span>';
				}elseif($column_value == $void->id){
					$column_value = '<span class="label label-danger">'.$void->status_name.'</span>';
				}elseif($column_value == $pick_up->id){
					$column_value = '<span class="label label-success">'.$pick_up->status_name.'</span>';
				}elseif($column_value == $ongoing_diagnosis->id){
					$column_value = '<span class="label label-warning">'.$ongoing_diagnosis->status_name.'</span>';
				}elseif($column_value == $shipped_mail_in->id){
					$column_value = '<span class="label label-warning">'.$shipped_mail_in->status_name.'</span>';
				}
			}

            if($column_index == 3){
				$models = DB::table('model')->where('id',$column_value)->first();
				if($models){
					$model_group = DB::table('model_group')->where('id',$models->model_group)->first();
					$column_value = '<span class="label label-info">'.$model_group->model_group_name.'</span>';
				}
			}

			// if($column_index == 4){
			// 	if($column_value == 'YES'){
			// 		$column_value = '<span class="label label-success">'.$column_value.'</span>';
			// 	}elseif($column_value == 'NO'){
			// 		$column_value = '<span class="label label-danger">'.$column_value.'</span>';
			// 	}
			// }

			// if($column_index == 5){
			// 	if($column_value == 'UNPAID'){
			// 		$column_value = '<span style="color: #F93154"><strong>'.$column_value.'</strong></span>';
			// 	}elseif($column_value == 'PAID'){
			// 		$column_value = '<span style="color: #00B74A"><strong>'.$column_value.'</strong></span>';
			// 	}elseif($column_value == 'IN WARRANTY'){
			// 		$column_value = '<span style="color: #1266F1"><strong>'.$column_value.'</strong></span>';
			// 	}elseif($column_value == 'SPECIAL'){
			// 		$column_value = '<span style="color: #FFA900"><strong>'.$column_value.'</strong></span>';
			// 	}
			// }

			// if($column_index == 6){
			// 	$payments = DB::table('returns_payments')->where('id',$column_value)->first();
			// 	if(!empty($payments->downpayment_id)){
			// 		$column_value = "<a href='".$payments->downpayment_id."'>".$payments->downpayment_id."</a>";
			// 	}else{
			// 		$column_value = "";
			// 	}
			// }

	    }

		// CHANGE TRANSACTION STATUS
		public function changeTransactionStatus(Request $request)
		{
	    	$all_data = array();
            parse_str($request->all_data, $all_data);
			
			$transaction_details = DB::table('returns_header')->leftJoin('model', 'returns_header.model', '=', 'model.id')
				->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status')
				->where('returns_header.id',$all_data['header_id'])->get();

			if(CRUDBooster::getModulePath() == 'to_diagnose'){
				$all_cost = explode(",", $all_data['cost']);
				$total_cost = 0;
				foreach($all_cost as $ac){
					$total_cost += intval($ac);
				}

				// $parts_total_cost = $total_cost + $all_data['software_cost'];
				$parts_total_cost = $total_cost;
				// $downpayment = ($parts_total_cost)*0.5;
				// $finalpayment = $parts_total_cost - $downpayment;

				DB::table('returns_header')->where('id',$all_data['header_id'])->update([
					// 'downpayment_cost'			=> number_format($downpayment, 2, '.', ''),
					// 'final_payment_cost'		=> number_format($finalpayment, 2, '.', ''),
					'parts_total_cost'			=> number_format($parts_total_cost, 2, '.', ''),
					// 'software_cost'				=> $all_data['software_cost'],
					'updated_by' 				=> CRUDBooster::myId()
				]);
			}

			// if(!empty($transaction_details[0]->diagnostic_fee_payment_url))
			// {
			// 	$status_diagnostic_fee = 'PAID';
			// }else{
			// 	if($all_data['warranty_status'] == "OUT OF WARRANTY"){
			// 		$status_diagnostic_fee = 'PAID';
			// 	}else{
			// 		$status_diagnostic_fee = $all_data['warranty_status'];
			// 	}
			// }
					
			// if(!empty($transaction_details[0]->down_payment_url)){
			// 	$status_down_payment = 'PAID';
			// }else{
			// 	if($all_data['warranty_status'] == "OUT OF WARRANTY"){
			// 		$status_down_payment = 'UNPAID';
			// 	}else{
			// 		$status_down_payment = $all_data['warranty_status'];
			// 	}
			// }

			// if(!empty($transaction_details[0]->final_payment_url)){
			// 	$status_final_payment = 'PAID';
			// }else{
			// 	if($all_data['warranty_status'] == "OUT OF WARRANTY"){
			// 		$status_final_payment = 'UNPAID';
			// 	}else{
			// 		$status_final_payment = $all_data['warranty_status'];
			// 	}
			// }
            if($transaction_details[0]->repair_status == 9)
			{
				$ProblemDetails = implode(",", $all_data['problem_details']);
                DB::table('returns_header')->where('id',$all_data['header_id'])->update([
                    // 'diagnostic_fee_status'		=> $status_diagnostic_fee,
                    // 'downpayment_status' 		=> $status_down_payment,
                    // 'final_payment_status' 		=> $status_final_payment,
                    'warranty_expiration_date' 	=> date('Y-m-d', strtotime($all_data['warranty_expiration_date'])),		
                    'problem_details'			=> $ProblemDetails,
                    'problem_details_other'		=> $all_data['problem_details_other'],    
                    'other_remarks'		        => $all_data['other_remarks'],
					'parts_replacement_cost'	=> $all_data['replacement_cost'],
					'case_status'						=> $all_data['case_status'],
                    'warranty_status' 			=> $all_data['warranty_status'],
					// 'memo_no' 					=> $all_data['memo_number'],
                    // 'device_issue_description' 	=> $all_data['device_issue_description'],
                    'findings' 					=> $all_data['findings'],
                    'resolution' 				=> $all_data['resolution'],
                    'other_diagnostic'			=> $all_data['other_diagnostic'],
                    'updated_by'            	=> CRUDBooster::myId()
                ]);

				// *******************************For Diagnostic Test******************************
				$diagnosticTest = "";
				$diagnosticId = implode(",", $all_data['test_result_id']);
				for($b=0; $b < count($all_data['test_result_id']); $b++)
				{
					$testId = 'test_result_'.$all_data['test_result_id'][$b];
					if($b == count($all_data['test_result_id'])-1)
					{
						$diagnosticTest .= $all_data[$testId];
					}else{
						$diagnosticTest .= $all_data[$testId].",";
					}
				}

				$Test_Type = DB::table('returns_diagnostic_test')->where('returns_header_id', $all_data['header_id'])->first(); 
				if(!empty($Test_Type))
				{
					DB::table('returns_diagnostic_test')->where('returns_header_id', $all_data['header_id'])->update([
						'returns_header_id' 		=> $all_data['header_id'],
						'test_type'					=> $diagnosticId,
						'test_result' 				=> $diagnosticTest,
						'updated_by' 				=> CRUDBooster::myId()
					]);
				}else{
					DB::table('returns_diagnostic_test')->insert([
						'returns_header_id' 		=> $all_data['header_id'],
						'test_type'					=> $diagnosticId,
						'test_result' 				=> $diagnosticTest,
						'created_by' 				=> CRUDBooster::myId(),
						'updated_by' 				=> CRUDBooster::myId()
					]);
				}
				// *********************************************************************************
			}

			// ***************************************For Quotation*********************************
			$row_id = explode(",", $all_data['row_id']);  
			$service_code = explode(",", $all_data['service_code']);
			$gsx_ref = explode(",", $all_data['gsx_ref']);
			$cs_code = explode(",", $all_data['cs_code']);
			$serial_no = explode(",", $all_data['serial_no']);
			$item_desc = explode(",", $all_data['item_desc']); 
			$cost = explode(",", $all_data['cost']);

			if(in_array(!null, $gsx_ref)){
			    $gsx_status = 'YES';
			}else{
			    $gsx_status = 'NO';
			}
			
			if(in_array(!null, $serial_no)){
			    $serial_status = 'YES';
			}else{
			    $serial_status = 'NO';
			}

			DB::table('returns_header')->where('id',$all_data['header_id'])->update([
				'gsx_status'		=> $gsx_status,
				'serial_status'		=> $serial_status,
				'updated_by'		=> CRUDBooster::myId()
			]);

            for($i=0; $i<=$all_data['number_of_rows']; $i++)
            {	
                if(!empty($service_code[$i]) || !empty($gsx_ref[$i]) || !empty($cs_code[$i]) || !empty($serial_no[$i]) || !empty($item_desc[$i]) || !empty($cost[$i]))
                {
					$bodyItem = DB::table('returns_body_item')->where('returns_header_id',$all_data['header_id'])->where('service_code',$service_code[$i])->first();
                    $parts_item_description = DB::table('parts_item_master')->where('spare_parts',trim($service_code[$i]))->get();
					if(!empty($bodyItem->id) && !empty($service_code[$i])){
						DB::table('returns_body_item')->where('id',$row_id[$i])->update([
							'service_code'		=> $service_code[$i],
							'gsx_ref'			=> $gsx_ref[$i],
							'cs_code'			=> $cs_code[$i],
							'item_description'	=> $parts_item_description[0]->item_description,
							'qty' 				=> $parts_item_description[0]->qty > 0 ? 'Available' : 'Unavailable',
							'item_id'           => $parts_item_description[0]->id,
							'cost'				=> $cost[$i],
							'updated_by'		=> CRUDBooster::myId()
						]);
						DB::table('returns_serial')->where('returns_header_id',$all_data['header_id'])->where('returns_body_item_id',$row_id[$i])->update([
							'serial_number'		=> $serial_no[$i],
							'updated_by'		=> CRUDBooster::myId()
						]);

                    }else if(empty($bodyItem->id) && !empty($service_code[$i])){
                        $bodyItemID = DB::table('returns_body_item')->insertGetId([
                            'returns_header_id'	=> $all_data['header_id'],
                            'service_code'		=> $service_code[$i],
                            'gsx_ref'			=> $gsx_ref[$i],
                            'cs_code'			=> $cs_code[$i],
                            'item_description'	=> $parts_item_description[0]->item_description,
							'qty' 				=> $parts_item_description[0]->qty > 0 ? 'Available' : 'Unavailable',
							'item_id'           => $parts_item_description[0]->id,
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

		    $status_array = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
		    if(in_array($request->status_id, $status_array)){
		    	DB::table('returns_header')->where('id',$request->header_id)->update([
				'repair_status' 			=> $request->status_id,
				'updated_by'            	=> CRUDBooster::myId()
				]);
			}
			
			if(URL::to('/') == "https://antriku.beyondthebox.ph"){
				$email = $transaction_details[0]->email;
			}else{
				$email = "lewieadona@digits.ph";
			}

			// To Pay Diagnostic
			if($request->status_id == 8){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'level3_personnel'          => CRUDBooster::myId(),
					'level3_personnel_edited'   => date('Y-m-d H:i:s')
				]);
			}
		
			// To Pay Parts and Sending of Quotations
			if($request->status_id == 2)
			{	
				$all_cost = explode(",", $request->all_cost);
				$all_item_desc = explode(",", $request->all_item_desc);
				$total_cost = 0;
				foreach($all_cost as $ac){
					$total_cost += intval($ac);
				}

				// $parts_total_cost = $total_cost + $request->software_cost;
				$parts_total_cost = $total_cost;
				$downpayment = ($parts_total_cost)*0.5;
				$finalpayment = $parts_total_cost - $downpayment;
				
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'parts_total_cost'			=> number_format($parts_total_cost, 2, '.', ''),
					'downpayment_cost'			=> number_format($downpayment, 2, '.', ''),
					'final_payment_cost'		=> number_format($finalpayment, 2, '.', ''),
					// 'software_cost'				=> $request->software_cost,
					'level3_personnel'          => CRUDBooster::myId(),
					'level3_personnel_edited'   => date('Y-m-d H:i:s')
				]);

				$data = array();
				$data['id'] = $request->header_id;
				$data['reference_no'] = $transaction_details[0]->reference_no;
				// $data['software_cost'] = number_format($request->software_cost, 2, '.', ',');
				$data['downpayment_cost'] = number_format($downpayment, 2, '.', ',');
				$data['main_url'] = URL::to('/');

				$allparts = DB::table('returns_body_item')->where('returns_header_id',$request->header_id)->get();
				$parts_cost = "";
				foreach($all_cost as $key=>$ac){
					if(!empty($ac)){
						$parts_cost .= "<tr>
						<td style='text-align: left; padding: 10px; border: 1px solid rgb(184, 184, 184) !important;width: 20%;'>
							<font face='Tahoma'>".$all_item_desc[$key].":<br></font>
						</td>
						<td style='border: 1px solid #B8B8B8 !important;padding: 5px;width: 55%;'>
							<font face='Tahoma'>₱".number_format($ac, 2, '.', ',')."</font>
						</td>
						</tr>";
					}
				}
				$data['parts_cost'] = $parts_cost;
				
				if($request->warranty_status == 'OUT OF WARRANTY'){
					// CRUDBooster::sendEmail(['to'=>$email,'data'=>$data, 'template'=>'send_payment_link_for_downpayment_email','attachments'=>[]]);
					// DB::table('returns_header')->where('id',$request->header_id)->update([
					// 	'send_down_payment_link' => 'YES'
					// ]);
				}
			}

			// Cancelled
			if($request->status_id == 3){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'cancelled_by'          => CRUDBooster::myId(),
					'cancelled_at'   => date('Y-m-d H:i:s')
				]);
			}

			// Repair In Process
			if($request->status_id == 4)
			{
				if(!empty($transaction_details[0]->down_payment_url)){
					$status_down_payment = 'PAID';
				}else{
					if($request->warranty_status == "OUT OF WARRANTY"){
						$status_down_payment = 'UNPAID';
					}else{
						$status_down_payment = $request->warranty_status;
					}
				}
	
				if(!empty($transaction_details[0]->final_payment_url)){
					$status_final_payment = 'PAID';
				}else{
					if($request->warranty_status == "OUT OF WARRANTY"){
						$status_final_payment = 'UNPAID';
					}else{
						$status_final_payment = $request->warranty_status;
					}
				}

				DB::beginTransaction();
				try {
					DB::table('returns_header')->where('id',$request->header_id)->update([
						'downpayment_status' 		=> $status_down_payment,
						'final_payment_status' 		=> $status_final_payment,
						'level4_personnel'          => CRUDBooster::myId(),
						'level4_personnel_edited'   => date('Y-m-d H:i:s')
					]);	

					DB::commit();
				} catch (\Exception $e) {
					DB::rollback();
				}
				// CRUDBooster::sendEmail(['to'=>$email, 'data'=>$transaction_details[0], 'template'=>'repair_in_process_email','attachments'=>[]]);
			}

			//To Pick Up
			if($request->status_id == 7){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'level5_personnel'          => CRUDBooster::myId(),
					'level5_personnel_edited'   => date('Y-m-d H:i:s')
				]);
			}

			// To Close For Complete
			if($request->status_id == 6)
			{
				if($request->warranty_status == "OUT OF WARRANTY")
				{ 
					if(!empty($transaction_details[0]->final_payment_url)){
						$status_final_payment = 'PAID';
					}else{
						$status_final_payment = 'PAID';
					}
				}elseif($request->warranty_status == "IN WARRANTY" || $request->warranty_status == "SPECIAL"){
					if(!empty($data->final_payment_url)){
						$status_final_payment = 'PAID';
					}else{
						$status_final_payment = $request->warranty_status;
					}
				}

				DB::table('returns_header')->where('id',$request->header_id)->update([
					'final_payment_status' => $status_final_payment,
				]);
				
				$datalink = [];
				if ($transaction_details[0]->branch == 1) {
					$datalink['link'] = 'https://g.page/r/CX9SRYpaPiT5EBM/review';
				}else {
					$datalink['link'] = 'https://g.page/r/CUspcdS4LAekEBM/review';
				}
				
				$email = $transaction_details[0]->email;
				// CRUDBooster::sendEmail(['to'=> $email  ,'data' => $datalink, 'template'=>'customer_feedback','attachments'=>[]]);
			}
	
			// To Close For Complete or To Close For Cancel
			if($request->status_id == 6 || $request->status_id == 5){
				$total_time = time() - strtotime($data->created_at);
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'level6_personnel'          => CRUDBooster::myId(),
					'level6_personnel_edited'   => date('Y-m-d H:i:s'),
					'closed_by'					=>	CRUDBooster::myId(),
					'close_at'					=>	date('Y-m-d H:i:s'),
					'service_time'   			=> date('H:i:s', $total_time)
				]);
			}

			// Sending Link for To Close
			if($request->status_id == 'send')
			{
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'send_final_payment_link' 		=> 'YES'
				]);

				$data = array();
				$data['id'] = $request->header_id;
				$data['reference_no'] = $transaction_details[0]->reference_no;
				// $data['software_cost'] = number_format($transaction_details[0]->software_cost, 2, '.', ',');
				$data['downpayment_cost'] = number_format($transaction_details[0]->downpayment_cost, 2, '.', ',');
                $data['main_url'] = URL::to('/');
    
				$allparts = DB::table('returns_body_item')->where('returns_header_id',$request->header_id)->get();

				$parts_cost = "";
				foreach($allparts as $key=>$ap){
					$parts_cost .= "<tr>
									<td style='text-align: left; padding: 10px; border: 1px solid rgb(184, 184, 184) !important;width: 20%;'>
										<font face='Tahoma'>".$ap->item_description.":<br></font>
									</td>
									<td style='border: 1px solid #B8B8B8 !important;padding: 5px;width: 55%;'>
										<font face='Tahoma'>₱".number_format($ap->cost, 2, '.', ',')."</font>
									</td>
									</tr>";
				}
				$data['parts_cost'] = $parts_cost;
				if($request->warranty_status == 'OUT OF WARRANTY'){
					// CRUDBooster::sendEmail(['to'=>$email,'data'=>$data, 'template'=>'send_payment_link_for_final_payment_email','attachments'=>[]]);
				}
			}

			//  FOR CALL-OUT MAIL-IN
			if(in_array($request->status_id, [10,13,14,17])){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'diagnose_by'   => CRUDBooster::myId(),
					'diagnose_at'   => date('Y-m-d H:i:s'),
				]);
			}

			// FOR PENDING MAIL-IN SHIPMENT
			if($request->status_id == 11){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'approved_by'   => CRUDBooster::myId(),
					'approved_at'   => date('Y-m-d H:i:s'),
				]);
				
			}

			// MAIL-IN SHIPPED
			if($request->status_id == 12){

				if ($request->hasFile('waybill')) {
					$file = $request->file('waybill');
					$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName() ;
					$path = $file->storeAs('public/waybill_upload', $filename);
					
					DB::table('returns_header')->where('id',$request->header_id)->update([
						'airwaybill_tn'   => $all_data['airwaybill_tn'],
						'airwaybill_upload'   => $filename,
						'mail_in_shipped_by'   => CRUDBooster::myId(),
						'mail_in_shipped_at'   => date('Y-m-d H:i:s'),
					]);
				}
			}

			if($request->status_id == 13){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'ongoing_repair_by'   => CRUDBooster::myId(),
					'ongoing_repair_at'   => date('Y-m-d H:i:s'),
				]);

				$get_body_items = DB::table('returns_body_item')->where('returns_header_id', $request->header_id)->get();
				if(!$get_body_items->isEmpty()){
					foreach($get_body_items as $per_item){
						if($per_item->qty == 'Available'){
							DB::table('parts_item_master')->where('id', $per_item->item_id)->update([
								'qty' => DB::raw('qty - 1'),
								'updated_by' => CRUDBooster::myId(),
								'updated_at' => now()
							]);
						}
					}
				}

			}

			if($request->status_id == 14){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'pending_spare_parts_by'   => CRUDBooster::myId(),
					'pending_spare_parts_at'   => date('Y-m-d H:i:s'),
				]);
			}

			if($request->status_id == 16){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'shipped_by'   => CRUDBooster::myId(),
					'shipped_at'   => date('Y-m-d H:i:s'),
				]);
			}
			if($request->status_id == 17){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'for_customer_payment_by'   => CRUDBooster::myId(),
					'for_customer_payment_at'   => date('Y-m-d H:i:s'),
				]);

				DB::table('returns_header')->where('id',$request->header_id)->update([
					'send_final_payment_link' 		=> 'YES'
				]);

				$customer_email = $transaction_details[0]->email;
				$data = array();
				$data['id'] = $request->header_id;
				$data['reference_no'] = $transaction_details[0]->reference_no;
				// $data['software_cost'] = number_format($all_data['software_cost'], 2, '.', ',');
				$data['parts_total_cost'] = number_format($parts_total_cost, 2, '.', ',');
                $data['main_url'] = URL::to('/');
    
				$allparts = DB::table('returns_body_item')->where('returns_header_id',$request->header_id)->get();

				$parts_cost = "";
				foreach($allparts as $key=>$ap){
					$parts_cost .= "<tr>
									<td style='text-align: left; padding: 10px; border: 1px solid rgb(184, 184, 184) !important;width: 20%;'>
										<font face='Tahoma'>".$ap->item_description.":<br></font>
									</td>
									<td style='border: 1px solid #B8B8B8 !important;padding: 5px;width: 55%;'>
										<font face='Tahoma'>₱".number_format($ap->cost, 2, '.', ',')."</font>
									</td>
									</tr>";
				}
				$data['parts_cost'] = $parts_cost;
				if($request->warranty_status == 'OUT OF WARRANTY'){
					try {
						if((float) str_replace(',', '', $data['parts_total_cost']) <= 2000.00){
							CRUDBooster::sendEmail(['to'=>$customer_email,'data'=>$data, 'template'=>'send_payment_link_below_2k','attachments'=>[]]);
						} else{
							CRUDBooster::sendEmail(['to'=>$customer_email,'data'=>$data, 'template'=>'send_payment_link','attachments'=>[]]);
						}
					} catch (\Exception $e) {
						\Log::error('Email sending failed: '.$e->getMessage());
					}
					
				}

				
			}
			if($request->status_id == 18){

				if ($request->hasFile('input_file')) {
					$file = $request->file('input_file');
					$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName() ;
					$path = $file->storeAs('public/receipts', $filename);
					
					DB::table('returns_header')->where('id',$request->header_id)->update([
						'receipt'   => $filename,
						'final_payment_status' => 'PAID',
						'replacement_part_paid_by'   => CRUDBooster::myId(),
						'replacement_part_paid_at'   => date('Y-m-d H:i:s'),
					]);
				}
				
			}
			if($request->status_id == 19){

				if ($request->hasFile('input_file')) {
					$file = $request->file('input_file');
					$filename =    time() .  '_' . $request->header_id . '_' . $file->getClientOriginalName() ;
					$path = $file->storeAs('public/receipts', $filename);
					
					DB::table('returns_header')->where('id',$request->header_id)->update([
						'receipt'   => $filename,
						'final_payment_status' => 'PAID',
						'for_parts_ordering_by'   => CRUDBooster::myId(),
						'for_parts_ordering_at'   => date('Y-m-d H:i:s'),
					]);
				}
			}
			
			// FOR PENDING GOOD UNIT
			if($request->status_id == 22){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'ongoing_repair_by'   => CRUDBooster::myId(),
					'ongoing_repair_at'   => date('Y-m-d H:i:s'),
				]);
			}

			if($request->status_id == 23){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'escalated_by'   => CRUDBooster::myId(),
					'escalated_at'   => date('Y-m-d H:i:s'),
				]);
			}
			
			if($request->status_id == 21){
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'for_call_out_good_unit_by'   => CRUDBooster::myId(),
					'for_call_out_good_unit_at'   => date('Y-m-d H:i:s'),
				]);
			
				$latestAssignment = DB::table('case_assignments')
				->where('returns_header_id', $request->header_id)
				->where('technician_id', $transaction_details[0]->technician_id)
				->latest('id') 
				->first();
	
				if ($latestAssignment) {
				// Update the latest assignment by setting end_date
				DB::table('case_assignments')
					->where('id', $latestAssignment->id)
					->update(['end_date' => now()]);
				}
			}

			// if($request->status_id == 15){
			// 	DB::table('returns_header')->where('id',$request->header_id)->update([
			// 		'updated_by'   => CRUDBooster::myId(),
			// 		'updated_at'   => date('Y-m-d H:i:s'),
			// 	]);
			// }

			return ($all_data);
		}

		// ADD ROW IN QUOTATION
		public function AddQuotation(Request $request)
		{
			$data = array();
			if(!empty($request->service_code)){ $service_code = $request->service_code; }else{ $service_code = ''; }
			if(!empty($request->gsx_ref)){ $gsx_ref = $request->gsx_ref; }else{ $gsx_ref = ''; }
			if(!empty($request->cs_code)){ $cs_code = $request->cs_code; }else{ $cs_code = ''; }
			if(!empty($request->serial_no)){ $serial_no = $request->serial_no; }else{ $serial_no = ''; }
			if(!empty($request->item_desc)){ $item_desc = $request->item_desc; }else{ $item_desc = ''; }
			if(empty($request->item_qty) || $request->item_qty == 0){ $item_qty = 'Unavailable'; }else{ $item_qty = 'Available'; }
			if(!empty($request->item_id)){ $item_id = $request->item_id; }else{ $item_id = ''; }
			if(!empty($request->cost)){ $cost = $request->cost; }else{ $cost = ''; }
			
			$bodyItemID = DB::table('returns_body_item')->insertGetId([
				'returns_header_id'	=> $request->id,
				'service_code'		=> $service_code,
				'gsx_ref'			=> $gsx_ref,
				'cs_code'			=> $cs_code,
				'item_description'	=> $item_desc,
				'qty'				=> $item_qty,
				'item_id'			=> $item_id,
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

			// $spare_parts_item = DB::table('parts_item_master')
			// 	->where('id', $item_id)
			// 	->lockForUpdate()
			// 	->first();

			// if ($spare_parts_item && $spare_parts_item->qty > 0) {
			// 	DB::table('parts_item_master')->where('id', $item_id)
			// 		->update([
			// 			'qty' => $spare_parts_item->qty - 1,
			// 			'updated_by' => CRUDBooster::myId(),
			// 			'updated_at' => now()
			// 		]);
			// }

			$data['quotation'] = DB::table('returns_body_item')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			->where('returns_body_item.returns_header_id',$request->id)->where('returns_serial.returns_header_id',$request->id)
			->where('returns_serial.returns_body_item_id',$bodyItemID)->first();

			return($data);
		}

		// DELETE ROW IN QUOTATION
		public function DeleteQuotation(Request $request)
		{
			$data = array();
			$body_item = DB::table('returns_body_item')->where('id',$request->id)->first();

			if ($body_item && $body_item->qty == 'Available') {
				$added = DB::table('parts_item_master')->where('id', $body_item->item_id)
					->update([
						'qty' => DB::raw('qty + 1'), 
						'updated_by' => CRUDBooster::myId(),
						'updated_at' => now()
					]);
				
					if($added){
						DB::table('returns_body_item')->where('id',$request->id)->delete();	
						DB::table('returns_serial')->where('returns_body_item_id',$request->id)->delete();
					}
					
			} else {
				DB::table('returns_body_item')->where('id',$request->id)->delete();	
				DB::table('returns_serial')->where('returns_body_item_id',$request->id)->delete();
			}

			return($data);
		}

		// checking if gsx is existing
		public function CheckGSX(Request $request)
		{
			$data = DB::table('parts_item_master')->where('spare_parts', $request->gsx)->get();
			return($data);
		}

        // checking if search spare part number
		public function SearchSparePartNo(Request $request)
		{
			$data = DB::table('parts_item_master')->where('spare_parts', 'like', '%'.$request->spare_part.'%')->get();
			return($data);
		}



		 public function AcceptJob (Request $request) {
			try {
				DB::table('returns_header')->where('id', $request->id)->update([
					// to ongoing diagnosis
					'repair_status' => 9,
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

			}  catch (\Exception $e) {
				\Log::error('Error Accepting Job: ' . $e->getMessage());
				return response()->json(['success' => false]);
			}
		

			return response()->json(['success' => true]);
		 }
	}