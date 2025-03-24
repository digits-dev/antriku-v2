<?php namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Input;
	use Session;
	use DB;
	use CRUDBooster;

	class AdminToCloseController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

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
            $this->col[] = ["label"=>"Print Release Form","name"=>"print_release_form"];
			$this->col[] = ["label"=>"Send Final Payment Link","name"=>"send_final_payment_link"];
			$this->col[] = ["label"=>"Final Payment Status","name"=>"final_payment_status"];
			$this->col[] = ["label"=>"Final Payment URL","name"=>"final_payment_url"];
			$this->col[] = ["label"=>"Date Received","name"=>"level5_personnel_edited"];
            $this->col[] = ["label"=>"Updated By","name"=>"updated_by"];

			if(CRUDBooster::myPrivilegeId() == 1 || CRUDBooster::myPrivilegeId() == 2){
			    $this->col[] = ["label"=>"Apple Part Status","name"=>"serial_status"];
			}
			
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
			$this->button_selected[] = ['label'=>'Print Release Form', 'icon'=>'fa fa-print', 'name'=>'print_release_form'];
			$this->button_selected[] = ['label'=>'Print Same Day Release Form', 'icon'=>'fa fa-print', 'name'=>'print_sameday_release_form'];

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert = array();
	                
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
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;

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
	        $this->post_index_html = null;
	        
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
	        $this->style_css = NULL;
	        
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
			
			// $data = [];
			// $data['page_title'] = 'To Close';

			// $data['transaction_details'] = DB::table('returns_header')
			// 	->leftJoin('model', 'returns_header.model', '=', 'model.id')
			// 	->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
			// 	->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'model_group')
			// 	->where('returns_header.id',$id)->first();

			// $data['branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			// $data['imfs'] = DB::table('product_item_master')->get();
			// $data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
			// $data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
			// $data['Warranty'] = DB::table('tech_warranty_status')->orderBy('tech_warranty_status_name', 'ASC')->get();

			// $data['Comment'] = DB::table('returns_comments')
			// 	->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			// 	->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			// 	->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			// 	->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'DESC')->get();

			// $data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			// 	->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
			// 	->where('returns_diagnostic_test.returns_header_id',$id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			// $diagnosticArray = [];
			// foreach($data['diagnostic_test'] as $dt){
			// 	$diagnosticArray[] = DB::table('tech_testing')->where('tech_testing.id',$dt->test_type)->value('id');
			// }

			// $data['diagnosticArray'] = $diagnosticArray;
			// $data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			// $data['TechTestingResult'] = DB::table('tech_testing_result')->where('test_result_status', 'ACTIVE')->get();

			// $data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			// 	->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			// 	->where('returns_body_item.returns_header_id',$id)->get();
			
			// $this->cbView('transaction_details.view_diagnosed_transaction_detail',$data);


			$data = [];
			$data['page_title'] = "To Close";
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
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			// $data = [];
			// $data['page_title'] = 'To Close';

			// $data['transaction_details'] = DB::table('returns_header')
			// 	->leftJoin('model', 'returns_header.model', '=', 'model.id')
			// 	->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
			// 	->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'model_group')
			// 	->where('returns_header.id',$id)->first();

			// $data['branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			// $data['imfs'] = DB::table('product_item_master')->get();
			// $data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
			// $data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
			// $data['Warranty'] = DB::table('tech_warranty_status')->orderBy('tech_warranty_status_name', 'ASC')->get();

			// $data['Comment'] = DB::table('returns_comments')
			// 	->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			// 	->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			// 	->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			// 	->where('returns_comments.returns_header_id',$id)->orderBy('comment_date', 'DESC')->get();

			// $data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
			// 	->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
			// 	->where('returns_diagnostic_test.returns_header_id',$id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			// $diagnosticArray = [];
			// foreach($data['diagnostic_test'] as $dt){
			// 	$diagnosticArray[] = DB::table('tech_testing')->where('tech_testing.id',$dt->test_type)->value('id');
			// }

			// $data['diagnosticArray'] = $diagnosticArray;
			// $data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			// $data['TechTestingResult'] = DB::table('tech_testing_result')->where('test_result_status', 'ACTIVE')->get();

			// $data['quotation'] = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			// 	->select('returns_body_item.*', 'returns_body_item.returns_header_id as header_id', 'returns_serial.returns_header_id as serial_header_id', 'returns_serial.returns_body_item_id as serial_body_item_id', 'returns_serial.serial_number as serial_no')
			// 	->where('returns_body_item.returns_header_id',$id)->get();
		
			// //Please use cbView method instead view method from laravel
			// $this->cbView('transaction_details.view_diagnosed_transaction_detail',$data);


			$data = [];
			$data['page_title'] = "To Close";
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
			if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6){
			    $query->where('repair_status','=',3)->orWhere('repair_status','=',7)->orderBy('id', 'asc'); 
			}else{
			    $query->where('branch', CRUDBooster::me()->branch_id)->whereIn('repair_status', [3,7])->orderBy('id', 'asc'); 
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
			//Your code here
			$pending = DB::table('transaction_status')->where('id','1')->first();
			$to_pay = DB::table('transaction_status')->where('id','2')->first();
			$rejected = DB::table('transaction_status')->where('id','3')->first();
			$repair_in_process = DB::table('transaction_status')->where('id','4')->first();
			$void = DB::table('transaction_status')->where('id','5')->first();
			$complete = DB::table('transaction_status')->where('id','6')->first();
			$pick_up = DB::table('transaction_status')->where('id','7')->first();

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
				}
			}

            if($column_index == 3){
				$models = DB::table('model')->where('id',$column_value)->first();
				if($models){
					$model_group = DB::table('model_group')->where('id',$models->model_group)->first();
					$column_value = '<span class="label label-info">'.$model_group->model_group_name.'</span>';
				}
			}

			if($column_index == 4 || $column_index == 5){
				if($column_value == 'YES'){
					$column_value = '<span class="label label-success">'.$column_value.'</span>';
				}elseif($column_value == 'NO'){
					$column_value = '<span class="label label-danger">'.$column_value.'</span>';
				}
			}

			if($column_index == 6){
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

			if($column_index == 7){
				$column_value = "<a href='".$column_value."' target='_blank'>".$column_value."</a>";
			}
			
			if($column_index == 9){
                $name = DB::table('cms_users')->where('id',$column_value)->value('name');
				$column_value = $name;
			}
			
			if($column_index == 10){
				if($column_value == 'YES'){
					$column_value = '<span class="label label-success">'.$column_value.'</span>';
				}elseif($column_value == 'NO'){
					$column_value = '<span class="label label-danger">'.$column_value.'</span>';
				}
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
		public function DiagnoseTransactionProcess(Request $request)
		{
			DB::beginTransaction();
			try {
				$ProblemDetails = implode(",", $request->problem_details);
				DB::table('returns_header')->where('id',$request->id)->update([
					'problem_details'			=> $ProblemDetails,
					'warranty_status' 			=> $request->warranty_status,
					'warranty_id' 				=> $request->warranty,
					'device_issue_description' 	=> $request->device_issue_description,
					'findings' 					=> $request->findings,
					'resolution' 				=> $request->resolution,
					'diagnostic_results'		=> $request->diagnostic_results,
					'other_diagnostic'			=> $request->other_diagnostic,
					'updated_by'            	=> CRUDBooster::myId()
				]);
	
				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
			}

			$test_id = explode(",", $request->test_id);
			$test_type = explode(",", $request->test_type);
			$test_result = explode(",", $request->test_result);

			DB::beginTransaction();
			try {
				for($j=0; $j<=$request->test_row; $j++)
				{
					if(!empty($test_type[$j]) && !empty($test_result[$j]))
					{
						$Test_Type = DB::table('returns_diagnostic_test')->where('id',$test_id[$j])->first();
						if(!empty($Test_Type))
						{
							DB::table('returns_diagnostic_test')->where('id',$test_id[$j])->update([
								'returns_header_id' 		=> $request->id,
								'test_type' 				=> $test_type[$j],
								'test_result' 				=> $test_result[$j],
								'updated_by' 				=> CRUDBooster::myId()
							]);
						}else{
							DB::table('returns_diagnostic_test')->insert([
								'returns_header_id' 		=> $request->id,
								'test_type' 				=> $test_type[$j],
								'test_result' 				=> $test_result[$j],
								'created_by' 				=> CRUDBooster::myId(),
								'updated_by' 				=> CRUDBooster::myId()
							]);
						}
					}
				}
				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
			}
			
			$row_id = explode(",", $request->row_id);
			$gsx_ref = explode(",", $request->gsx_ref);
			$cs_code = explode(",", $request->cs_code);
			$service_code = explode(",", $request->service_code);
			$serial_no = explode(",", $request->serial_no);
			$digits_code = explode(",", $request->digits_code);
			$item_desc = explode(",", $request->item_desc);
			$date_ordered = explode(",", $request->date_ordered);
			$cost = explode(",", $request->cost);

			$bodyItem = DB::table('returns_body_item')->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_body_item.*','returns_serial.serial_number as serial_no')->where('returns_body_item.id',$row_id[1])->where('returns_serial.returns_header_id',$request->id)->first();

			DB::beginTransaction();
			try {
				for($i=0; $i<=$request->number_of_rows; $i++)
				{	
					if(!empty($digits_code[$i]) || !empty($item_desc[$i]) || !empty($gsx_ref[$i]) || !empty($cs_code[$i]) || !empty($service_code[$i]) || !empty($serial_no[$i]) || !empty($date_ordered[$i]) || !empty($cost[$i]))
					{
						if(!empty($date_ordered[$i])){
							$date_ordered_format = date('Y-m-d', strtotime($date_ordered[$i]));
						}else{
							$date_ordered_format = NULL;
						}

						$bodyItem = DB::table('returns_body_item')
						->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
						->select('returns_body_item.*','returns_serial.serial_number as serial_no')
						->where('returns_body_item.id',$row_id[$i])->where('returns_serial.returns_header_id',$request->id)->first();

						if(!empty($bodyItem)){
							DB::table('returns_body_item')->where('id',$row_id[$i])->update([
								'digits_code'		=> $digits_code[$i],
								'item_description'	=> $item_desc[$i],
								'gsx_ref'			=> $gsx_ref[$i],
								'cs_code'			=> $cs_code[$i],
								'service_code'		=> $service_code[$i],
								'date_ordered'		=> $date_ordered_format,
								'cost'				=> $cost[$i],
								'updated_by'		=> CRUDBooster::myId()
							]);
							DB::table('returns_serial')->where('returns_header_id',$request->id)->where('returns_body_item_id',$row_id[$i])->update([
								'serial_number'			=> $serial_no[$i],
								'updated_by'			=> CRUDBooster::myId()
							]);
						}else{
							$bodyItemID = DB::table('returns_body_item')->insertGetId([
								'returns_header_id'	=> $request->id,
								'digits_code'		=> $digits_code[$i],
								'item_description'	=> $item_desc[$i],
								'gsx_ref'			=> $gsx_ref[$i],
								'cs_code'			=> $cs_code[$i],
								'service_code'		=> $service_code[$i],
								'date_ordered'		=> $date_ordered_format,
								'cost'				=> $cost[$i],
								'created_by'		=> CRUDBooster::myId(),
								'updated_by'		=> CRUDBooster::myId()
							]);
							DB::table('returns_serial')->insert([
								'returns_header_id'   	=> $request->id,
								'returns_body_item_id'	=> $bodyItemID,
								'serial_number'			=> $serial_no[$i],
								'created_by'			=> CRUDBooster::myId(),
								'updated_by'			=> CRUDBooster::myId()
							]);
						}
					}
				}
				// $bodyItemID = DB::table('returns_body_item')->insertGetId([
				// 	'returns_header_id'	=> $request->id,
				// 	'digits_code'		=> $request->digits_code,
				// 	'item_description'	=> $request->item_desc,
				// 	'gsx_ref'			=> $request->gsx_ref,
				// 	'cs_code'			=> $request->cs_code,
				// 	'service_code'		=> $request->service_code,
				// 	'date_ordered'		=> $date_ordered,
				// 	'cost'				=> $request->cost,
				// 	'created_by'		=> CRUDBooster::myId(),
				// 	'updated_by'		=> CRUDBooster::myId()
				// ]);

				DB::commit();
			} catch (\Exception $e) {
				DB::rollback();
			}
			

			// DB::beginTransaction();
			// try {
				
			// 	DB::commit();
			// } catch (\Exception $e) {
			// 	DB::rollback();
			// }

			return redirect('admin/to_close');
		}

		public function closeTransaction(Request $request)
		{
			// $status = DB::table('transaction_status')->where('id',$request->status_id)->value('status_name');

			DB::table('returns_header')->where('id',$request->id)->update([
				'repair_status' 			=> $request->status_id,
				'updated_by'            	=> CRUDBooster::myId()
			]);

			return redirect('admin/to_close');
		}
	}