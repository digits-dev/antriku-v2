<?php namespace App\Http\Controllers;

	use Luigel\Paymongo\Facades\Paymongo;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Session;
	use DB;
	use URL;
	use CRUDBooster;

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
            $this->col[] = ["label"=>"Print Technical Report","name"=>"print_technical_report"];
			$this->col[] = ["label"=>"Downpayment Status","name"=>"downpayment_status"];
			$this->col[] = ["label"=>"Downpayment URL","name"=>"down_payment_url"];
			$this->col[] = ["label"=>"Date Received","name"=>"level2_personnel_edited"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by"];
			$this->col[] = ["label"=>"Technician","name"=>"technician_id", 'join' => 'cms_users,name'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Reference No","name"=>"reference_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Returns Status","name"=>"repair_status","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Print Receive Form","name"=>"print_receive_form","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Print Technical Report","name"=>"print_technical_report","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Print Release Form","name"=>"print_release_form","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Diagnostic Fee Status","name"=>"diagnostic_fee_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Diagnostic Cost","name"=>"diagnostic_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Last Name","name"=>"last_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"First Name","name"=>"first_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:returns_header","placeholder"=>"Please enter a valid email address"];
			//$this->form[] = ["label"=>"Address","name"=>"address","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact No","name"=>"contact_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Company Name","name"=>"company_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Company Contact No","name"=>"company_contact_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Purchase Date","name"=>"purchase_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Warranty Expiration Date","name"=>"warranty_expiration_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Warranty Status","name"=>"warranty_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Memo No","name"=>"memo_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Software Cost","name"=>"software_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mode Of Payment","name"=>"mode_of_payment","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Model","name"=>"model","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Summary Of Concern","name"=>"summary_of_concern","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Header Digits Code","name"=>"header_digits_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Header Item Description","name"=>"header_item_description","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Header Serial No","name"=>"header_serial_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Device Issue Description","name"=>"device_issue_description","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Findings","name"=>"findings","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Resolution","name"=>"resolution","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Other Diagnostic","name"=>"other_diagnostic","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Problem Details","name"=>"problem_details","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Problem Details Other","name"=>"problem_details_other","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Created By","name"=>"created_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Updated By","name"=>"updated_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level1 Personnel","name"=>"level1_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level1 Personnel Edited","name"=>"level1_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level2 Personnel","name"=>"level2_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level2 Personnel Edited","name"=>"level2_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
			if (CRUDBooster::myPrivilegeId() == 8) {
				$this->addaction[] = [
					'title'   => 'Assign Technician',
					'icon'    => 'fa fa-user',
					'url'     => 'javascript:handleSwal([id], '.json_encode("[reference_no]").', [technician_id])', 
					'color'   => 'success',
					'showIf'  => '[repair_status] == 1',
				];
			}
			if (CRUDBooster::myPrivilegeId() == 4) {
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
					'showIf'  => '[repair_status] == 9',
				];
			}



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
			$this->button_selected = array();
			$this->button_selected[] = ['label'=>'Print Receive Form', 'icon'=>'fa fa-print', 'name'=>'print_receive_form'];
			$this->button_selected[] = ['label'=>'Print Technical Report', 'icon'=>'fa fa-print', 'name'=>'print_technical_report'];
// 			$this->button_selected[] = ['label'=>'Print Release Form', 'icon'=>'fa fa-print', 'name'=>'print_release_form'];
			$this->button_selected[] = ['label'=>'Print Same Day Release Form', 'icon'=>'fa fa-print', 'name'=>'print_sameday_release_form'];

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			if(CRUDBooster::myPrivilegeId() == 4){
				$this->index_button[] = ["title"=>"Assigned To You","label"=>"Show Your Works","icon"=>"fa fa-list","url"=>CRUDBooster::mainpath('AssignedTechnician')];
			}

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();

	        /*
			/admin/to_diagnose/GetTechnicians
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        // $this->script_js = NULL;
			$this->script_js = "
			function handleSwal(id, reference_no, technician_id) {
			assignTechnician(id, reference_no, technician_id);
			}
			function handleAcceptJob(id) {
			acceptJob(id);
			}
			";

            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
			$this->post_index_html = '
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script src="'.asset('js/jobActions.js').'"></script>
		';
		
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
			$this->style_css = "
			.swal2-popup {
				font-size: unset !important;
			}
			";

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
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
				->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'DESC')->get();

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
				->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'DESC')->get();

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

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
			//Your code here
		
			if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6 || CRUDBooster::myPrivilegeId() == 8){
			    $query->where('repair_status', 1)->orderBy('id', 'asc'); 
			}else if (CRUDBooster::myPrivilegeId() == 4){
				$query->whereIn('repair_status', [1,9])->where('technician_id', CRUDBooster::myId())->orderBy('id', 'asc');
			}
			else{
			    $query->where('repair_status', 1)->where('branch', CRUDBooster::me()->branch_id); 

				if(!empty(Session::get('toggle')) && Session::get('toggle') == "ON")
				{
					$query->where('updated_by', CRUDBooster::me()->id)->orderBy('id', 'asc'); 
				}else{
					// $query->where('branch', CRUDBooster::me()->branch_id)->orderBy('id', 'desc'); 
					$query->orderBy('id', 'asc'); 
				}
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
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
				}
			}

            if($column_index == 3){
				$models = DB::table('model')->where('id',$column_value)->first();
				if($models){
					$model_group = DB::table('model_group')->where('id',$models->model_group)->first();
					$column_value = '<span class="label label-info">'.$model_group->model_group_name.'</span>';
				}
			}

			if($column_index == 4){
				if($column_value == 'YES'){
					$column_value = '<span class="label label-success">'.$column_value.'</span>';
				}elseif($column_value == 'NO'){
					$column_value = '<span class="label label-danger">'.$column_value.'</span>';
				}
			}

			if($column_index == 5){
				if($column_value == 'UNPAID'){
					$column_value = '<span style="color: #F93154"><strong>'.$column_value.'</strong></span>';
				}elseif($column_value == 'PAID'){
					$column_value = '<span style="color: #00B74A"><strong>'.$column_value.'</strong></span>';
				}elseif($column_value == 'IN WARRANTY'){
					$column_value = '<span style="color: #1266F1"><strong>'.$column_value.'</strong></span>';
				}elseif($column_value == 'SPECIAL'){
					$column_value = '<span style="color: #FFA900"><strong>'.$column_value.'</strong></span>';
				}
			}

			if($column_index == 6){
				$payments = DB::table('returns_payments')->where('id',$column_value)->first();
				if(!empty($payments->downpayment_id)){
					$column_value = "<a href='".$payments->downpayment_id."'>".$payments->downpayment_id."</a>";
				}else{
					$column_value = "";
				}
			}

			if($column_index == 8){
				$name = DB::table('cms_users')->where('id',$column_value)->value('name');
				$column_value = $name;
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here
	    }

		//By the way, you can still create your own method in here... :) 

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

				$parts_total_cost = $total_cost + $all_data['software_cost'];
				$downpayment = ($parts_total_cost)*0.5;
				$finalpayment = $parts_total_cost - $downpayment;

				DB::table('returns_header')->where('id',$all_data['header_id'])->update([
					'downpayment_cost'			=> number_format($downpayment, 2, '.', ''),
					'final_payment_cost'		=> number_format($finalpayment, 2, '.', ''),
					'parts_total_cost'			=> number_format($parts_total_cost, 2, '.', ''),
					'software_cost'				=> $all_data['software_cost'],
					'updated_by' 				=> CRUDBooster::myId()
				]);
			}

			if(!empty($transaction_details[0]->diagnostic_fee_payment_url))
			{
				$status_diagnostic_fee = 'PAID';
			}else{
				if($all_data['warranty_status'] == "OUT OF WARRANTY"){
					$status_diagnostic_fee = 'PAID';
				}else{
					$status_diagnostic_fee = $all_data['warranty_status'];
				}
			}
					
			if(!empty($transaction_details[0]->down_payment_url)){
				$status_down_payment = 'PAID';
			}else{
				if($all_data['warranty_status'] == "OUT OF WARRANTY"){
					$status_down_payment = 'UNPAID';
				}else{
					$status_down_payment = $all_data['warranty_status'];
				}
			}

			if(!empty($transaction_details[0]->final_payment_url)){
				$status_final_payment = 'PAID';
			}else{
				if($all_data['warranty_status'] == "OUT OF WARRANTY"){
					$status_final_payment = 'UNPAID';
				}else{
					$status_final_payment = $all_data['warranty_status'];
				}
			}
            if($transaction_details[0]->repair_status == 9)
			{
				$ProblemDetails = implode(",", $all_data['problem_details']);
                DB::table('returns_header')->where('id',$all_data['header_id'])->update([
                    'diagnostic_fee_status'		=> $status_diagnostic_fee,
                    'downpayment_status' 		=> $status_down_payment,
                    'final_payment_status' 		=> $status_final_payment,
                    'warranty_expiration_date' 	=> date('Y-m-d', strtotime($all_data['warranty_expiration_date'])),		
                    'problem_details'			=> $ProblemDetails,
                    'problem_details_other'		=> $all_data['problem_details_other'],    
                    'other_remarks'		        => $all_data['other_remarks'],
					'case'						=> $all_data['case'],
                    'warranty_status' 			=> $all_data['warranty_status'],
					'memo_no' 					=> $all_data['memo_number'],
                    'device_issue_description' 	=> $all_data['device_issue_description'],
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

		    $status_array = [1,2,3,4,5,6,7,8,9];
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

				$parts_total_cost = $total_cost + $request->software_cost;
				$downpayment = ($parts_total_cost)*0.5;
				$finalpayment = $parts_total_cost - $downpayment;
				
				DB::table('returns_header')->where('id',$request->header_id)->update([
					'parts_total_cost'			=> number_format($parts_total_cost, 2, '.', ''),
					'downpayment_cost'			=> number_format($downpayment, 2, '.', ''),
					'final_payment_cost'		=> number_format($finalpayment, 2, '.', ''),
					'software_cost'				=> $request->software_cost,
					'level3_personnel'          => CRUDBooster::myId(),
					'level3_personnel_edited'   => date('Y-m-d H:i:s')
				]);

				$data = array();
				$data['id'] = $request->header_id;
				$data['reference_no'] = $transaction_details[0]->reference_no;
				$data['software_cost'] = number_format($request->software_cost, 2, '.', ',');
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
				$data['software_cost'] = number_format($transaction_details[0]->software_cost, 2, '.', ',');
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
			if(!empty($request->cost)){ $cost = $request->cost; }else{ $cost = ''; }
			
			$bodyItemID = DB::table('returns_body_item')->insertGetId([
				'returns_header_id'	=> $request->id,
				'service_code'		=> $service_code,
				'gsx_ref'			=> $gsx_ref,
				'cs_code'			=> $cs_code,
				'item_description'	=> $item_desc,
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
			->where('returns_body_item.returns_header_id',$request->id)->where('returns_serial.returns_header_id',$request->id)
			->where('returns_serial.returns_body_item_id',$bodyItemID)->first();

			return($data);
		}

		// DELETE ROW IN QUOTATION
		public function DeleteQuotation(Request $request)
		{
			$data = array();
			DB::table('returns_body_item')->where('id',$request->id)->delete();	
			DB::table('returns_serial')->where('returns_body_item_id',$request->id)->delete();
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

		public function GetTechnicians() {
			$technicians = DB::table('cms_users')->where('id_cms_privileges', 4)->where('status', 'ACTIVE')->select('id', 'name')->get();
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
				]);
				
				return response()->json(['success' => true]);
			
			} catch (\Exception $e) {
				
				\Log::error('Error updating case_assignments: ' . $e->getMessage());
				return response()->json(['success' => false]);
			}
		}

		 public function AcceptJob (Request $request) {
			try {
				DB::table('returns_header')->where('id', $request->id)->update([
					// to ongoing diagnosis
					'repair_status' => 9,
				]);
			}  catch (\Exception $e) {
				\Log::error('Error Accepting Job: ' . $e->getMessage());
				return response()->json(['success' => false]);
			}
		

			return response()->json(['success' => true]);
		 }
	}