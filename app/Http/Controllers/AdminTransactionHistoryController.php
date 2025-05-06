<?php namespace App\Http\Controllers;

	use App\ExportData;
	use Maatwebsite\Excel\Facades\Excel;
	use Illuminate\Http\Request;
	use Session;
	use DB;
	use CRUDBooster;

	class AdminTransactionHistoryController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = false;
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
			$this->col[] = ["label" => "Warranty Status", "name" => "warranty_status"];
			$this->col[] = ["label" => "Case Status", "name" => "case_status"];
			$this->col[] = ["label" => "Technician Assigned", "name" => "technician_id", 'join' => 'cms_users,name'];
			$this->col[] = ["label" => "Date Received", "name" => "technician_accepted_at"];
			$this->col[] = ["label" => "Branch", "name" => "branch", 'join' => 'branch,branch_name'];
            $this->col[] = ["label"=>"Print Receive Form","name"=>"print_receive_form"];
			$this->col[] = ["label"=>"Print Technical Report","name"=>"print_technical_report"];
			$this->col[] = ["label"=>"Print Release Form","name"=>"print_release_form"];
			$this->col[] = ["label"=>"Serial Number","name"=>"header_serial_no", "visible" => false];
			$this->col[] = ["label"=>"First Name","name"=>"first_name", "visible" => false];
			$this->col[] = ["label"=>"Last Name","name"=>"last_name", "visible" => false];
			# END COLUMNS DO NOT REMOVE THIS LINE

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
		    $this->addaction[] = ['title'=>'View','url'=>CRUDBooster::mainpath('getDetailView/[id]'),'icon'=>'fa fa-eye'];
		    $this->addaction[] = [
					'title'=>'Print',
					'url' => '#[id]',
					'icon'=>'fa fa-print',
					'color' => ' print-form'
				];
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
			//$this->index_button[] = ["title"=>"Export Data","label"=>"Export Data","icon"=>"fa fa-download","url"=>CRUDBooster::mainpath('ExportData')];
			$this->index_button[] = [
					"title"=>"Export Data",
					"label"=>"Export Data",
					"icon"=>"fa fa-upload",
					"color"=>"primary",
					"url"=>"javascript:showExport()",
				];
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
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $admin_path = CRUDBooster::adminPath();
	        $this->script_js = "
	            function showExport() {
					$('#modal-export').modal('show');
				}	
				
				$('.user-footer .pull-right a').on('click', function () {
    				const currentMainPath = window.location.origin;
    				Swal.fire({
    					title: 'Do you want to logout?',
    					icon: 'warning',
    					showCancelButton: true,
    					confirmButtonColor: '#d33',
    					cancelButtonColor: '#b9b9b9',
    					confirmButtonText: 'Logout',
    					reverseButtons: true
    				}).then((result) => {
    					if (result.isConfirmed) {
    						location.assign(`$admin_path/logout`);
    					}
    				});
    			});	
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
	        $this->post_index_html = "
    			<div class='modal fade' tabindex='-1' role='dialog' id='modal-export'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button class='close' aria-label='Close' type='button' data-dismiss='modal'>
                                    <span aria-hidden='true'>×</span>
                                </button>
                              	<h4 class='modal-title'><i class='fa fa-download'></i> Export ".CRUDBooster::getCurrentModule()->name."</h4>
                            </div>
                
                            <form method='post' target='_blank' action=".route('exportData').">
                                <input type='hidden' name='_token' value=".csrf_token().">
                                ".CRUDBooster::getUrlParameters()."
                                <div class='modal-body'>
                                    <div class='form-group'>
                                        <label for='filename'>File Name</label>
                                       <input type='text' name='filename' class='form-control' required value='Export ".CRUDBooster::getCurrentModule()->name ." - ".date('Y-m-d H:i:s')."'/>
                                    </div>
                                    <div class='form-group'>
                                        <div class='row'>
                                            <div class='col-md-6'>
                                                <label for='date_from'>From</label>
                                                <input
                                                    type='date'
                                                    id='date_from'
                                                    name='date_from'
                                                    class='form-control'
                                                />
                                            </div>
                                            <div class='col-md-6'>
                                                <label for='date_to'>To</label>
                                                <input
                                                    type='date'
                                                    id='date_to'
                                                    name='date_to'
                                                    class='form-control'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='modal-footer' align='right'>
                                    <button class='btn btn-default' type='button' data-dismiss='modal'>Close</button>
                                    <button class='btn btn-primary btn-submit' type='submit'>Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

	        ";
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        $this->load_js[] = '//cdn.jsdelivr.net/npm/sweetalert2@11';
			$this->load_js[] = asset('js/print-action-buttons.js');
	        
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
	        $this->load_css[] = asset('css/custom.css');
	        
	    }

// 		public function cbView($template, $data)
// 		{
// 			$this->cbLoader();
// 			echo view($template, $data)->with('data', $data);
// 		}

	

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	       // dd($id_selected, $button_name);
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
			if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6 || CRUDBooster::myPrivilegeId() == 7){
				$query->orderBy('id', 'desc'); 
			}else{
				$query->where('branch', CRUDBooster::me()->branch_id);

				if(!empty(Session::get('toggle')) && Session::get('toggle') == "ON")
				{
					$query->where('level3_personnel', CRUDBooster::me()->id)->orderBy('id', 'desc'); 
				}else{
					// $query->where('branch', CRUDBooster::me()->branch_id)->orderBy('id', 'desc'); 
					$query->orderBy('id', 'desc'); 
				}
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
			if ($column_index == 1) {
				
				$statuses = DB::table('transaction_status')
								->pluck('status_name', 'id');
	
				if (isset($statuses[$column_value])) {
					$column_value = '<span class="label label-warning">'.$statuses[$column_value].'</span>';
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
				if($column_value == 'IN WARRANTY'){
					$column_value = '<span style="color: #00B74A"><strong>'.$column_value.'</strong></span>';
				}elseif($column_value == 'OUT OF WARRANTY'){
					$column_value = '<span style="color: #F93154"><strong>'.$column_value.'</strong></span>';
				}
			}
	
			if($column_index == 5){
				$column_value = '<span style="color: #1266F1"><strong>'.$column_value.'</strong></span>';
			}

			if($column_index >= 9 && $column_index <= 11){
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
	    
	    public function getDetailView($id) 
		{
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) { 
			  CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			$this->cbLoader();
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
			return $this->view('transaction_details.view_created_transaction_detail',$data);
		}



	    //By the way, you can still create your own method in here... :) 
		public function getExportData(Request $request) {
			date_default_timezone_set('Asia/Manila');
			$exportDate = date('Y-m-d H:i:s');
			$filename = $request['filename'];
			$filters = $request->all();
			return Excel::download(new ExportData($filters), $filename.'.csv');
	    }

		public function AssignedTechnician(Request $request) {
			return back()->with('toggle','ON');
	    }
	    
	    public function PrintReceivingForm($id)
		{
			$data = array();
			$data['page_title'] = 'Print Receiving Form';
			$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('returns_body_item', 'returns_header.id', '=', 'returns_body_item.returns_header_id')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*','returns_body_item.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'returns_serial.serial_number as serial_no', 'model.id as model_id', 'model_name', 'model_photo', 'model_status' )
			->where('returns_header.id',$id)->first();

			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$this->cbView("print_form_transaction_history.print_receiving_form", $data);
		}
		
		public function PrintTechnicalReport($id)
		{
			$data = array(); 
			$data['page_title'] = 'Print Technical Report';
			$data['transaction_details'] = DB::table('returns_header')
				->leftJoin('model', 'returns_header.model', '=', 'model.id')
				->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
				->leftJoin('cms_users', 'returns_header.updated_by', '=', 'cms_users.id')
				->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'cms_users.name as name', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'model_group')
				->where('returns_header.id',$id)->first();

			$data['diagnostic_result'] = DB::table('returns_diagnostic_test')
				->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->where('returns_header_id',$data['transaction_details']->header_id)->get();

			$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
				->where('returns_diagnostic_test.returns_header_id',$data['transaction_details']->header_id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();
			$data['TechTestingResult'] = DB::table('tech_testing_result')->where('test_result_status', 'ACTIVE')->get();

			$data['Quotation'] = DB::table('returns_body_item')
				->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
				->where('returns_body_item.returns_header_id',$data['transaction_details']->header_id)->get();

			$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$this->cbView("print_form_transaction_history.print_technical_report", $data);
		}
		
		public function PrintSameDayReleaseForm($id)
		{
			$data = array();
			$data['page_title'] = 'Print Release Form';
			$data['transaction_details'] = DB::table('returns_header')
				->leftJoin('model', 'returns_header.model', '=', 'model.id')
				->leftJoin('model_group', 'model.model_group', '=', 'model_group.id')
				->leftJoin('cms_users', 'returns_header.updated_by', '=', 'cms_users.id')
				->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'cms_users.name as name', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'diagnostic_fee', 'model_group')
				->where('returns_header.id',$id)->first();

			$data['diagnostic_result'] = DB::table('returns_diagnostic_test')
				->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->where('returns_header_id',$data['transaction_details']->header_id)->get();

			$data['diagnostic_test'] = DB::table('returns_diagnostic_test')->leftJoin('tech_testing', 'returns_diagnostic_test.test_type', '=', 'tech_testing.id')
				->select('returns_diagnostic_test.*','tech_testing.description as diagnostic_desc')
				->where('returns_diagnostic_test.returns_header_id',$data['transaction_details']->header_id)->orderBy('returns_diagnostic_test.created_at', 'ASC')->get();

			$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id','!=',NULL)->orderBy('description', 'ASC')->get();

			$data['Quotation'] = DB::table('returns_body_item')
				->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
				->where('returns_body_item.returns_header_id',$data['transaction_details']->header_id)->get();

			$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
			$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id',$data['transaction_details']->user_id)->first();
			$this->cbView("print_form_transaction_history.print_release_form", $data);
		}

	}