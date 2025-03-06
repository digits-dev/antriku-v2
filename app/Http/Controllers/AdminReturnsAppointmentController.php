<?php 

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use Log;

class AdminReturnsAppointmentController extends \crocodicstudio\crudbooster\controllers\CBController {

	public function cbInit() {

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "firstname";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = false;
		$this->button_edit = true;
		$this->button_delete = false;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "returns_appointment";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"Status","name"=>"appointment_status"];
		$this->col[] = ["label"=>"Reference#","name"=>"reference_no"];
		$this->col[] = ["label"=>"Branch","name"=>"branch_id","join"=>"branch,branch_name"];
		$this->col[] = ["label"=>"Day","name"=>"scheduled_day"];
		$this->col[] = ["label"=>"Scheduled Date","name"=>"scheduled_date"];
		$this->col[] = ["label"=>"Scheduled Time","name"=>"scheduled_time"];
		$this->col[] = ["label"=>"Warranty Status","name"=>"warranty_status"];
		$this->col[] = ["label"=>"First Name","name"=>"firstname"];
		$this->col[] = ["label"=>"Last Name","name"=>"lastname"];
		$this->col[] = ["label"=>"Serial#","name"=>"serial_no"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label'=>'Reference No','name'=>'reference_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-6','readonly'=>'readonly'];
		$this->form[] = ['label'=>'Branch Id','name'=>'branch_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-6','datatable'=>'branch,branch_name'];
		$custom_date = view('include.scheduled_date')->render();
		$this->form[] = ["label"=>"Scheduled Date","name"=>"scheduled_date","type"=>"custom",'validation'=>'required',"html"=>$custom_date];
		$custom_time = view('include.scheduled_time')->render();
		$this->form[] = ["label"=>"Scheduled Time","name"=>"scheduled_time","type"=>"custom",'validation'=>'required',"html"=>$custom_time];
		$this->form[] = ['label'=>'Warranty Status','name'=>'warranty_status','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-6','dataenum'=>'IN WARRANTY;OUT OF WARRANTY'];
		$this->form[] = ['label'=>'Firstname','name'=>'firstname','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-6'];
		$this->form[] = ['label'=>'Lastname','name'=>'lastname','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-6'];
		$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email','width'=>'col-sm-6','placeholder'=>'Please enter a valid email address'];
		$this->form[] = ['label'=>'Serial No','name'=>'serial_no','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-6'];
		$this->form[] = ['label'=>'Summary','name'=>'summary','type'=>'textarea','validation'=>'required|string|min:1|max:5000','width'=>'col-sm-6'];
		$custom_action = view('include.action')->render();
		$this->form[] = ["label"=>"Action","name"=>"action","type"=>"custom",'validation'=>'required',"html"=>$custom_action];
        $custom_status = view('include.appointment_status')->render();
		$this->form[] = ["label"=>"Status","name"=>"appointment_status","type"=>"custom",'validation'=>'required',"html"=>$custom_status];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ["label"=>"Reference No","name"=>"reference_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Branch Id","name"=>"branch_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"branch,branch_name"];
		//$this->form[] = ["label"=>"Scheduled Date","name"=>"scheduled_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
		//$this->form[] = ["label"=>"Scheduled Time","name"=>"scheduled_time","type"=>"time","required"=>TRUE,"validation"=>"required|date_format:H:i:s"];
		//$this->form[] = ["label"=>"Warranty Status","name"=>"warranty_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Firstname","name"=>"firstname","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Lastname","name"=>"lastname","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:returns_appointment","placeholder"=>"Please enter a valid email address"];
		//$this->form[] = ["label"=>"Serial No","name"=>"serial_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
		//$this->form[] = ["label"=>"Summary","name"=>"summary","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
		$this->load_js[] = asset("js/returns_appointment.js").'?r='.time();
		
		
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
			
	}

	/*
	| ---------------------------------------------------------------------- 
	| Hook for manipulate row of index table html 
	| ---------------------------------------------------------------------- 
	|
	*/    
	public function hook_row_index($column_index,&$column_value) {	        
		//Your code here
		if($column_index == 1){
			if($column_value == 'BOOKED'){
				$column_value = '<span class="label label-warning">'.$column_value.'</span>';
			}elseif($column_value == 'ARRIVED'){
				$column_value = '<span class="label label-success">'.$column_value.'</span>';
			}elseif($column_value == 'NO SHOW'){
				$column_value = '<span class="label label-info">'.$column_value.'</span>';
			}elseif($column_value == 'CANCELLED'){
				$column_value = '<span class="label label-danger">'.$column_value.'</span>';
			}
		}
		
		if($column_index == 7){
			if($column_value == 'OUT OF WARRANTY'){
				$column_value = '<span style="color: #F93154"><strong>'.$column_value.'</strong></span>';
			}elseif($column_value == 'IN WARRANTY'){
				$column_value = '<span style="color: #00B74A"><strong>'.$column_value.'</strong></span>';
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
 		$schedule = DB::table('operating_schedule')->where('branch_id',$postdata['branch_id'])
 		->where('day',date('l', strtotime($postdata['scheduled_date'])))->where('time',date('H:i:s', strtotime($postdata['scheduled_time'])))->first();

		$postdata['schedule_id']  = $schedule->id;
		$postdata['scheduled_day']  = date('l', strtotime($postdata['scheduled_date']));
		$postdata['scheduled_date'] = date('Y-m-d', strtotime($postdata['scheduled_date']));
		$postdata['scheduled_time'] = date('H:i:s', strtotime($postdata['scheduled_time']));
		
		DB::connection('mysql2')->table(env('DB_DATABASE_FRONT_END').'.returns_appointment')->where('id',$id)->update([
		    'appointment_status'=>  $postdata['appointment_status'],
		    'schedule_id'       =>  $postdata['schedule_id'],
			'branch_id'         =>  $postdata['branch_id'],
			'scheduled_day'     =>  $postdata['scheduled_day'],
			'scheduled_date'    =>  $postdata['scheduled_date'],		
			'scheduled_time'   	=>  $postdata['scheduled_time'],
			'warranty_status'   =>  $postdata['warranty_status'],				
			'firstname'			=>  $postdata['firstname'],	
			'lastname'   		=>  $postdata['lastname'],	
			'email'   			=>  $postdata['email'],
			'serial_no'   		=>  $postdata['serial_no'],
			'summary'   	    =>  $postdata['summary']
		]);
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
		$data = array();

		$appointment = DB::table('returns_appointment')->leftjoin('branch', 'returns_appointment.branch_id', '=', 'branch.id')
		->where('returns_appointment.id',$id)->first();  

		$data['reference_no'] = $appointment->reference_no;
		$data['firstname'] = $appointment->firstname;
		$data['lastname'] = $appointment->lastname;
		$data['email'] = $appointment->email;
		$data['branch_name'] = $appointment->branch_name;
		$data['branch_address'] = $appointment->branch_address;
		$data['scheduled_date'] = date('F j, Y', strtotime($appointment->scheduled_date));
		$data['scheduled_time'] = date('g:i A', strtotime($appointment->scheduled_time));

        if($appointment->action == 'CHANGE STATUS'){
            if($appointment->appointment_status == 'BOOKED'){
    			CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'reminder_appointment_email','attachments'=>[]]);     //BOOKED
            }else if($appointment->appointment_status == 'ARRIVED'){
    			CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'completed_appointment_email','attachments'=>[]]);    //ARRIVED
            }else if($appointment->appointment_status == 'NO SHOW'){
    			CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'missed_appointment_email','attachments'=>[]]);       //NO SHOW
            }else if($appointment->appointment_status == 'CANCELLED'){
    			CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'cancel_appointment_email','attachments'=>[]]);       //CANCELLED
            }
        }
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

	public function getTime(Request $request) 
	{
		$data = array();
		$time_input = strtotime($request->date); 
		$date_input = getDate($time_input); 
		$data['date'] = $date_input;
		$data['schedule'] = DB::table('operating_schedule')->where('branch_id',$request->branch)->where('day', date('l', strtotime($request->date)))->where('status','ACTIVE')->get();
		$data['reservations'] = DB::table('returns_appointment')->where('branch_id',$request->branch)->where('scheduled_date', date('Y-m-d', strtotime($request->date)))->get(); 
		return($data);

	}

	public function EmailNotif(Request $request) 
	{
		$data = array();

		$appointment = DB::table('returns_appointment')->leftjoin('branch', 'returns_appointment.branch_id', '=', 'branch.id')->where('returns_appointment.id',1)->first();  

		$data['reference_no'] = $appointment->reference_no;
		$data['firstname'] = $appointment->firstname;
		$data['lastname'] = $appointment->lastname;
		$data['email'] = $appointment->email;
		$data['branch_name'] = $appointment->branch_name;
		$data['branch_address'] = $appointment->branch_address;
		$data['scheduled_date'] = date('F j, Y', strtotime($appointment->scheduled_date));
		$data['scheduled_time'] = date('g:i A', strtotime($appointment->scheduled_time));

		// if($appointment->appointment_status == 'CANCELLED'){
			CRUDBooster::sendEmail(['to'=>$appointment->email, 'data'=>$data, 'template'=>'cancel_appointment_email','attachments'=>[]]);
		// }
	}
}