<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminCallOutController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

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

			# START FORM DO NOT REMOVE THIS LINE
			// $this->form = [];
			// $this->form[] = ['label'=>'Address','name'=>'address','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Branch','name'=>'branch','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Case','name'=>'case','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Company Contact No','name'=>'company_contact_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Company Name','name'=>'company_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Contact No','name'=>'contact_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Created By','name'=>'created_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Device Issue Description','name'=>'device_issue_description','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Diagnostic Cost','name'=>'diagnostic_cost','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Diagnostic Fee Payment Date Created','name'=>'diagnostic_fee_payment_date_created','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Diagnostic Fee Payment Url','name'=>'diagnostic_fee_payment_url','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Diagnostic Fee Status','name'=>'diagnostic_fee_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Down Payment Date Created','name'=>'down_payment_date_created','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Down Payment Url','name'=>'down_payment_url','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Downpayment Cost','name'=>'downpayment_cost','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Downpayment Status','name'=>'downpayment_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:returns_header','width'=>'col-sm-10','placeholder'=>'Please enter a valid email address'];
			// $this->form[] = ['label'=>'Final Payment Cost','name'=>'final_payment_cost','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Final Payment Date Created','name'=>'final_payment_date_created','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Final Payment Status','name'=>'final_payment_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Final Payment Url','name'=>'final_payment_url','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Findings','name'=>'findings','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'First Name','name'=>'first_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Gsx Status','name'=>'gsx_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Header Item Description','name'=>'header_item_description','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Header Serial No','name'=>'header_serial_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Header Upc Code','name'=>'header_upc_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Last Name','name'=>'last_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Lead Technician Id','name'=>'lead_technician_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'lead_technician,id'];
			// $this->form[] = ['label'=>'Level1 Personnel','name'=>'level1_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level1 Personnel Edited','name'=>'level1_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level2 Personnel','name'=>'level2_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level2 Personnel Edited','name'=>'level2_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level3 Personnel','name'=>'level3_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level3 Personnel Edited','name'=>'level3_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level4 Personnel','name'=>'level4_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level4 Personnel Edited','name'=>'level4_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level5 Personnel','name'=>'level5_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level5 Personnel Edited','name'=>'level5_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level6 Personnel','name'=>'level6_personnel','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Level6 Personnel Edited','name'=>'level6_personnel_edited','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Memo No','name'=>'memo_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Model','name'=>'model','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Other Diagnostic','name'=>'other_diagnostic','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Other Remarks','name'=>'other_remarks','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Parts Replacement Cost','name'=>'parts_replacement_cost','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Parts Total Cost','name'=>'parts_total_cost','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Print Receive Form','name'=>'print_receive_form','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Print Release Form','name'=>'print_release_form','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Print Technical Report','name'=>'print_technical_report','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Problem Details','name'=>'problem_details','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Problem Details Other','name'=>'problem_details_other','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Purchase Date','name'=>'purchase_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Reference No','name'=>'reference_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Repair Status','name'=>'repair_status','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Resolution','name'=>'resolution','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Send Diagnostic Payment Link','name'=>'send_diagnostic_payment_link','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Send Down Payment Link','name'=>'send_down_payment_link','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Send Final Payment Link','name'=>'send_final_payment_link','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Serial Status','name'=>'serial_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Service Time','name'=>'service_time','type'=>'time','validation'=>'required|date_format:H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Software Cost','name'=>'software_cost','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Summary Of Concern','name'=>'summary_of_concern','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Technician Assigned At','name'=>'technician_assigned_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Technician Id','name'=>'technician_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'technician,id'];
			// $this->form[] = ['label'=>'Updated By','name'=>'updated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Warranty Expiration Date','name'=>'warranty_expiration_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			// $this->form[] = ['label'=>'Warranty Status','name'=>'warranty_status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Address","name"=>"address","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Branch","name"=>"branch","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Case","name"=>"case","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Company Contact No","name"=>"company_contact_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Company Name","name"=>"company_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact No","name"=>"contact_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Created By","name"=>"created_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Device Issue Description","name"=>"device_issue_description","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Diagnostic Cost","name"=>"diagnostic_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Diagnostic Fee Payment Date Created","name"=>"diagnostic_fee_payment_date_created","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Diagnostic Fee Payment Url","name"=>"diagnostic_fee_payment_url","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Diagnostic Fee Status","name"=>"diagnostic_fee_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Down Payment Date Created","name"=>"down_payment_date_created","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Down Payment Url","name"=>"down_payment_url","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Downpayment Cost","name"=>"downpayment_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Downpayment Status","name"=>"downpayment_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:returns_header","placeholder"=>"Please enter a valid email address"];
			//$this->form[] = ["label"=>"Final Payment Cost","name"=>"final_payment_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Final Payment Date Created","name"=>"final_payment_date_created","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Final Payment Status","name"=>"final_payment_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Final Payment Url","name"=>"final_payment_url","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Findings","name"=>"findings","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"First Name","name"=>"first_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Gsx Status","name"=>"gsx_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Header Item Description","name"=>"header_item_description","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Header Serial No","name"=>"header_serial_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Header Upc Code","name"=>"header_upc_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Last Name","name"=>"last_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Lead Technician Id","name"=>"lead_technician_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"lead_technician,id"];
			//$this->form[] = ["label"=>"Level1 Personnel","name"=>"level1_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level1 Personnel Edited","name"=>"level1_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level2 Personnel","name"=>"level2_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level2 Personnel Edited","name"=>"level2_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level3 Personnel","name"=>"level3_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level3 Personnel Edited","name"=>"level3_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level4 Personnel","name"=>"level4_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level4 Personnel Edited","name"=>"level4_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level5 Personnel","name"=>"level5_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level5 Personnel Edited","name"=>"level5_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Level6 Personnel","name"=>"level6_personnel","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Level6 Personnel Edited","name"=>"level6_personnel_edited","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Memo No","name"=>"memo_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Model","name"=>"model","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Other Diagnostic","name"=>"other_diagnostic","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Other Remarks","name"=>"other_remarks","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Parts Replacement Cost","name"=>"parts_replacement_cost","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Parts Total Cost","name"=>"parts_total_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Print Receive Form","name"=>"print_receive_form","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Print Release Form","name"=>"print_release_form","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Print Technical Report","name"=>"print_technical_report","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Problem Details","name"=>"problem_details","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Problem Details Other","name"=>"problem_details_other","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Purchase Date","name"=>"purchase_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Reference No","name"=>"reference_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Repair Status","name"=>"repair_status","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Resolution","name"=>"resolution","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Send Diagnostic Payment Link","name"=>"send_diagnostic_payment_link","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Send Down Payment Link","name"=>"send_down_payment_link","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Send Final Payment Link","name"=>"send_final_payment_link","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Serial Status","name"=>"serial_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Service Time","name"=>"service_time","type"=>"time","required"=>TRUE,"validation"=>"required|date_format:H:i:s"];
			//$this->form[] = ["label"=>"Software Cost","name"=>"software_cost","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Summary Of Concern","name"=>"summary_of_concern","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Technician Assigned At","name"=>"technician_assigned_at","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Technician Id","name"=>"technician_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"technician,id"];
			//$this->form[] = ["label"=>"Updated By","name"=>"updated_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Warranty Expiration Date","name"=>"warranty_expiration_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Warranty Status","name"=>"warranty_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
			if (CRUDBooster::myPrivilegeId() == 3) {
				$query->whereIn('repair_status', [10,16])->where('branch', CRUDBooster::me()->branch_id); 
			}else {
				$query->whereIn('repair_status', [10,16]);
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_detail(&$query) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of index table 
	    | ---------------------------------------------------------------------- 
	    | @html = current html 
	    |
	    */
	    public function hook_index_table(&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of detail table 
	    | ---------------------------------------------------------------------- 
	    | @html = current html 
	    |
	    */
	    public function hook_detail_table(&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of detail tab 
	    | ---------------------------------------------------------------------- 
	    | @tab_name = tab name 
	    | @html = current html 
	    |
	    */
	    public function hook_detail_tab($tab_name,&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of detail tab 
	    | ---------------------------------------------------------------------- 
	    | @tab_name = tab name 
	    | @html = current html 
	    |
	    */
	    public function hook_detail_tab2($tab_name,&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of detail tab 
	    | ---------------------------------------------------------------------- 
	    | @tab_name = tab name 
	    | @html = current html 
	    |
	    */
	    public function hook_detail_tab3($tab_name,&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of form 
	    | ---------------------------------------------------------------------- 
	    | @html = current html 
	    |
	    */
	    public function hook_form(&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of form 
	    | ---------------------------------------------------------------------- 
	    | @html = current html 
	    |
	    */
	    public function hook_form_add(&$html) {
	        //Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate html of form 
	    | ---------------------------------------------------------------------- 
	    | @html
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	$pending_customes_approval = DB::table('transaction_status')->where('id','10')->first();
	    	$for_call_out = DB::table('transaction_status')->where('id','16')->first();

			if($column_index == 1){
				if($column_value == $pending_customes_approval->id){
					$column_value = '<span class="label label-warning">'.$pending_customes_approval->status_name.'</span>';
				}
				if($column_value == $for_call_out->id){
					$column_value = '<span class="label label-info">'.$for_call_out->status_name.'</span>';
				}
			}
			if($column_index == 3){
				$models = DB::table('model')->where('id',$column_value)->first();
				if($models){
					$model_group = DB::table('model_group')->where('id',$models->model_group)->first();
					$column_value = '<span class="label label-info">'.$model_group->model_group_name.'</span>';
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

	  

	}