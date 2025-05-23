<?php namespace App\Http\Controllers;

	use Session;
	use DB;
	use CRUDBooster;
	use Illuminate\Http\Request;

	class AdminToAssignController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "last_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = false;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "returns_header";
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
			if (CRUDBooster::myPrivilegeId() == 8) {
				$this->addaction[] = [
					'title'   => 'Assign Technician',
					'icon'    => 'fa fa-user',
					'url'     => 'javascript:handleSwal([id], '.json_encode("[reference_no]").',[branch],[technician_id])', 
					'color'   => 'success',
				];
			}

			
	        $this->index_button = array();
			if(CRUDBooster::myPrivilegeId() == 4){
				$this->index_button[] = ["title"=>"Assigned To You","label"=>"Show Your Works","icon"=>"fa fa-list","url"=>CRUDBooster::mainpath('AssignedTechnician')];
			}


			$this->script_js = "
				function handleSwal(id, reference_no, branch_id, technician_id) {
					assignTechnician(id, reference_no,branch_id, technician_id);
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


		public function hook_query_index(&$query) {
			$query->whereIn('repair_status', [1,9,13,15,16,18,19,24])->where('print_receive_form', 'YES')->orderBy('id', 'ASC'); 
	    }
 
		public function hook_row_index($column_index,&$column_value) 
		{	        
			//Your code here
			$pending = DB::table('transaction_status')->where('id','1')->first();
			$ongoing_diagnosis = DB::table('transaction_status')->where('id','9')->first();
			$ongoing_repair = DB::table('transaction_status')->where('id','13')->first();
			$spare_sparts_received = DB::table('transaction_status')->where('id','15')->first();
			$shipped_mail_in = DB::table('transaction_status')->where('id','16')->first();
			$replacement_parts_paid = DB::table('transaction_status')->where('id','18')->first();
			$for_parts_ordering = DB::table('transaction_status')->where('id','19')->first();
			$to_assign = DB::table('transaction_status')->where('id','24')->first();

			if($column_index == 1){
				if($column_value == $pending->id){
					$column_value = '<span class="label label-warning">'.$pending->status_name.'</span>';
				}elseif($column_value == $ongoing_diagnosis->id){
					$column_value = '<span class="label label-warning">'.$ongoing_diagnosis->status_name.'</span>';
				}elseif($column_value == $ongoing_repair->id){
					$column_value = '<span class="label label-warning">'.$ongoing_repair->status_name.'</span>';
				}elseif($column_value == $spare_sparts_received->id){
					$column_value = '<span class="label label-warning">'.$spare_sparts_received->status_name.'</span>';
				}elseif($column_value == $shipped_mail_in->id){
					$column_value = '<span class="label label-warning">'.$shipped_mail_in->status_name.'</span>';
				}elseif($column_value == $replacement_parts_paid->id){
					$column_value = '<span class="label label-warning">'.$replacement_parts_paid->status_name.'</span>';
				}elseif($column_value == $for_parts_ordering->id){
					$column_value = '<span class="label label-warning">'.$for_parts_ordering->status_name.'</span>';
				}elseif($column_value == $to_assign->id){
					$column_value = '<span class="label label-warning" style="background-color: #00c0ef !important">'.$to_assign->status_name.'</span>';
				}
			}

            if($column_index == 3){
				$models = DB::table('model')->where('id',$column_value)->first();
				if($models){
					$model_group = DB::table('model_group')->where('id',$models->model_group)->first();
					$column_value = '<span class="label label-info">'.$model_group->model_group_name.'</span>';
				}
			}

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

		public function GetTechnicians() {
			$technicians = DB::table('cms_users')->whereIn('id_cms_privileges', [4,8])->where('status', 'ACTIVE')->get();
			return response()->json($technicians);
		}

		public function AssignTechnician(Request $request){
			try {
				$technicianId = DB::table('returns_header')
					->where('id', $request->id)
					->value('technician_id');
			
				if (!$technicianId) {
					// No existing technician, insert new assignment
					DB::table('case_assignments')->insert([
						'returns_header_id'   => $request->id,
						'lead_technician_id'  => CRUDBooster::myId(),
						'technician_id'       => $request->technician_id,
						'start_date'          => now(),
					]);

				DB::table('returns_header')->where('id', $request->id)->update([
					'repair_status'				=> 1,
				]);
				
				} else {
					// Get the latest assignment
					$latestAssignment = DB::table('case_assignments')
						->where('returns_header_id', $request->id)
						->latest('id') // Gets the latest entry based on ID
						->first();
			
					if ($latestAssignment) {
						// Update the latest assignment by setting end_date
						DB::table('case_assignments')
							->where('id', $latestAssignment->id)
							->update(['end_date' => now()]);
					}
			
					// Insert the new assignment with start_date
					DB::table('case_assignments')->insert([
						'returns_header_id'   => $request->id,
						'lead_technician_id'  => CRUDBooster::myId(),
						'technician_id'       => $request->technician_id,
						'start_date'          => now(),
					]);
				}

				DB::table('returns_header')->where('id', $request->id)->update([
					'lead_technician_id'		=> CRUDBooster::myId(),
					'technician_id'				=> $request->technician_id,
					'technician_assigned_at'    => date('Y-m-d H:i:s'),
					'updated_by'				=> CRUDBooster::myId(),
				]);
				
				return response()->json(['success' => true]);
			
			} catch (\Exception $e) {
				
				\Log::error('Error updating case_assignments: ' . $e->getMessage());
				return response()->json(['success' => false]);
			}
		}


	}