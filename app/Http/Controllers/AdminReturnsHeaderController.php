<?php

namespace App\Http\Controllers;

use App\Mail\EmailReceivePrintForm;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Session;
use DB;
use URL;
use ZipArchive;
use CRUDBooster;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AdminReturnsHeaderController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "last_name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
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
		$this->col[] = ["label" => "Status", "name" => "repair_status"];
		$this->col[] = ["label" => "Reference No", "name" => "reference_no"];
		$this->col[] = ["label" => "Model Group", "name" => "model"];
		$this->col[] = ["label" => "Print Receive Form", "name" => "print_receive_form"];
		$this->col[] = ["label" => "Send Payment Link", "name" => "send_diagnostic_payment_link"];
		$this->col[] = ["label" => "Diagnostic Payment Status", "name" => "diagnostic_fee_status"];
		$this->col[] = ["label" => "Diagnostic Fee", "name" => "diagnostic_cost"];
		$this->col[] = ["label" => "Diagnostic Payment URL", "name" => "diagnostic_fee_payment_url"];
		$this->col[] = ["label" => "Date Created", "name" => "created_at"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by"];
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
		$this->button_selected[] = ['label' => 'Print Receive Form', 'icon' => 'fa fa-print', 'name' => 'print_receive_form'];
		$this->button_selected[] = ['label' => 'Print Technical Report', 'icon' => 'fa fa-print', 'name' => 'print_technical_report'];
		// 			$this->button_selected[] = ['label'=>'Print Release Form','icon'=>'fa fa-print','name'=>'print_release_form'];
		$this->button_selected[] = ['label' => 'Print Same Day Release Form', 'icon' => 'fa fa-print', 'name' => 'print_sameday_release_form'];

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
		//Create an Auth
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = [];
		$data['page_title'] = 'Transaction Details';
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('returns_body_item', 'returns_header.id', '=', 'returns_body_item.returns_header_id')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*', 'returns_body_item.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'returns_serial.serial_number as serial_no', 'model.id as model_id', 'model_name', 'model_photo', 'model_status')
			->where('returns_header.id', $id)->first();

		$data['Comment'] = DB::table('returns_comments')
			->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			->where('returns_comments.returns_header_id', $id)->orderBy('comment_date', 'ASC')->get();

		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function getAdd()
	{
		$this->cbLoader();
		if (!CRUDBooster::isUpdate() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();
		$data['branch'] = DB::table('branch')->where('branch_status', 'ACTIVE')->orderBy('branch_name', 'ASC')->get();
		$data['imfs'] = DB::table('product_item_master')->get();
		$data['Model'] = DB::table('model')->where('model_status', 'ACTIVE')->orderBy('model_name', 'ASC')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['country'] = DB::table('refcountry')->get();

		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('returns_body_item', 'returns_header.id', '=', 'returns_body_item.returns_header_id')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->select('returns_header.*', 'returns_body_item.*', 'returns_header.id as header_id', 'returns_serial.serial_number as serial_no')
			->first();

		if (!empty(Session::get('success'))) {
			$data['success'] = Session::get('success');
		} else {
			$data['success'] = "";
		}


		$this->cbView("frontliner.create_transactions", $data);
	}

	public function getProvinces(Request $request)
	{
		$provinces = DB::table('refprovince')->where('country_id', $request->input('country_id'))->get();
		return response()->json($provinces);
	}

	public function getCities(Request $request)
	{
		$cities = DB::table('refcitymun')->where('provCode', $request->input('prov_code'))->get();
		return response()->json($cities);
	}

	public function getBrgy(Request $request)
	{
		$barangays = DB::table('refbrgy')->where('provCode', $request->input('prov_code'))->where('citymunCode', $request->input('city_mun_code'))->get();
		return response()->json($barangays);
	}

	public function getEdit($id)
	{
		if (!CRUDBooster::isUpdate() && $this->global_privilege == FALSE || $this->button_edit == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = [];
		$data['page_title'] = "To Pay Diagnostic";
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('returns_body_item', 'returns_header.id', '=', 'returns_body_item.returns_header_id')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*', 'returns_body_item.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'returns_serial.serial_number as serial_no', 'model.id as model_id', 'model_name', 'model_photo', 'model_status', 'model_group')
			->where('returns_header.id', $id)->first();


		$data['Comment'] = DB::table('returns_comments')
			->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', 'returns_comments.created_at as comment_date', 'cms_users.name as name', 'cms_users.id as userid', 'cms_users.photo as userimg', 'cms_privileges.name as role')
			->where('returns_comments.returns_header_id', $id)->orderBy('comment_date', 'ASC')->get();

		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$data['Diagnostic_Fee'] = DB::table('model_group')->where('id', $data['transaction_details']->model_group)->value('diagnostic_fee');
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	public function actionButtonSelected($id_selected, $button_name)
	{
		//Your code here
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	public function hook_query_index(&$query)
	{
		//Your code here
		if (CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6) {
			$query->where('repair_status', 8)->orderBy('id', 'asc');
		} else {
			$query->where('repair_status', 8)->where('branch', CRUDBooster::me()->branch_id)->orderBy('id', 'asc');
		}
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		$pending = DB::table('transaction_status')->where('id', '1')->first();
		$to_pay = DB::table('transaction_status')->where('id', '2')->first();
		$rejected = DB::table('transaction_status')->where('id', '3')->first();
		$repair_in_process = DB::table('transaction_status')->where('id', '4')->first();
		$void = DB::table('transaction_status')->where('id', '5')->first();
		$complete = DB::table('transaction_status')->where('id', '6')->first();
		$pick_up = DB::table('transaction_status')->where('id', '7')->first();
		$pay_diagnose = DB::table('transaction_status')->where('id', '8')->first();

		if ($column_index == 1) {
			if ($column_value == $pending->id) {
				$column_value = '<span class="label label-warning">' . $pending->status_name . '</span>';
			} elseif ($column_value == $to_pay->id) {
				$column_value = '<span class="label label-warning">' . $to_pay->status_name . '</span>';
			} elseif ($column_value == $rejected->id) {
				$column_value = '<span class="label label-danger">' . $rejected->status_name . '</span>';
			} elseif ($column_value == $repair_in_process->id) {
				$column_value = '<span class="label label-success">' . $repair_in_process->status_name . '</span>';
			} elseif ($column_value == $void->id) {
				$column_value = '<span class="label label-danger">' . $void->status_name . '</span>';
			} elseif ($column_value == $pick_up->id) {
				$column_value = '<span class="label label-success">' . $pick_up->status_name . '</span>';
			} elseif ($column_value == $pay_diagnose->id) {
				$column_value = '<span class="label label-primary">' . $pay_diagnose->status_name . '</span>';
			}
		}

		if ($column_index == 3) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}

		if ($column_index == 4 || $column_index == 5) {
			if ($column_value == 'YES') {
				$column_value = '<span class="label label-success">' . $column_value . '</span>';
			} elseif ($column_value == 'NO') {
				$column_value = '<span class="label label-danger">' . $column_value . '</span>';
			}
		}

		if ($column_index == 6) {
			if ($column_value == 'UNPAID') {
				$column_value = '<span style="color: #F93154"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'PAID') {
				$column_value = '<span style="color: #00B74A"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'IN WARRANTY') {
				$column_value = '<span style="color: #1266F1"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'SPECIAL') {
				$column_value = '<span style="color: #FFA900"><strong>' . $column_value . '</strong></span>';
			}
		}

		if ($column_index == 7) {
			$column_value = '₱' . $column_value;
		}

		if ($column_index == 8) {
			$column_value = "<a href='" . $column_value . "'>" . $column_value . "</a>";
		}

		if ($column_index == 10) {
			$name = DB::table('cms_users')->where('id', $column_value)->value('name');
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
	public function hook_before_add(&$postdata)
	{
		//Your code here
	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	public function hook_after_add($id)
	{
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
	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here
	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_edit($id)
	{
		//Your code here 
	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_before_delete($id)
	{
		//Your code here
	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_delete($id)
	{
		//Your code here
	}

	//By the way, you can still create your own method in here... :) 
	public function AddTransactionProcess(Request $request)
	{
		$data = array();
		parse_str($request->data, $data);
		$model = DB::table('model')->where('id', $data['model'])->value('model_group');
		$diagnostic_fee = DB::table('model_group')->where('id', $model)->value('diagnostic_fee');

		if (!empty($data['problem_details'])) {
			$ProblemDetails = implode(",", $data['problem_details']);
		} else {
			$ProblemDetails = "";
		}

		if ($data['warranty_status'] == "OUT OF WARRANTY") {
			$status_diagnose = "UNPAID";
		} else {
			$status_diagnose = $data['warranty_status'];
		}

		date_default_timezone_set('Asia/Manila');
		$headerID = DB::table('returns_header')->insertGetId([
			'repair_status' 			=> ($data['warranty_status'] === "OUT OF WARRANTY") ? 8 : 1,
			'last_name'   				=> $data['last_name'],
			'first_name'   				=> $data['first_name'],
			'email'   					=> $data['email'],
			'address'					=> $data['address'],
			'contact_no'   				=> $data['contact_no'],
			'company_name'   			=> $data['company_name'],
			'company_contact_no'   		=> $data['company_contact_no'],
			'purchase_date'   			=> date('Y-m-d', strtotime($data['purchase_date'])),
			'warranty_expiration_date' 	=> date('Y-m-d', strtotime($data['warranty_expiration_date'])),
			'warranty_status' 			=> $data['warranty_status'],
			'diagnostic_fee_status'		=> $status_diagnose,
			'downpayment_status' 	    => $status_diagnose,
			'final_payment_status' 	    => $status_diagnose,
			'diagnostic_cost'			=> 0.00,
			'summary_of_concern' 		=> $data['summary_of_concern'],
			'header_item_description'	=> $data['item_description'],
			'model'						=> $data['model'],
			'branch'                    => CRUDBooster::me()->branch_id,
			'problem_details'			=> $ProblemDetails,
			'problem_details_other'		=> $data['problem_details_other'],
			'other_remarks'		        => $data['other_remarks'],
			'header_upc_code'			=> $data['upc_code'],
			'header_serial_no'			=> $data['serial_no'],
			'created_by'            	=> CRUDBooster::myId(),
			'updated_by'            	=> CRUDBooster::myId(),
			'level1_personnel'          => CRUDBooster::myId(),
			'level1_personnel_edited'   => date('Y-m-d H:i:s')
		]);

		$numberCode = str_pad($headerID, 9, "0", STR_PAD_LEFT);
		$tracking_number = 'A' . $numberCode;

		DB::table('returns_header')->where('id', $headerID)->update([
			'reference_no'	=>	$tracking_number,
		]);

		DB::table('returns_payments')->insertGetId([
			'header_id' => $headerID,
		]);

		return (array(['header_id' => $headerID, 'ref_no' => $tracking_number, 'warranty_status' => $data['warranty_status']]));
	}

	public function EditTransactionProcess(Request $request)
	{
		$transaction_details = DB::table('returns_header')->where('id', $request->id)->first();

		if (!empty($transaction_details->diagnostic_fee_payment_url)) {
			if ($transaction_details->repair_status == 9) {
				$status_diagnostic_fee = 'PAID';
			} else if ($transaction_details->diagnostic_fee_status == 'PAID') {
				$status_diagnostic_fee = 'PAID';
			} else {
				$status_diagnostic_fee = 'PAID';
			}
		} else {
			if ($request->warranty_status == "OUT OF WARRANTY") {
				$status_diagnostic_fee = 'PAID';
			} else {
				$status_diagnostic_fee = $request->warranty_status;
			}
		}

		if (!empty($transaction_details->down_payment_url)) {
			$status_down_payment = 'PAID';
		} else {
			if ($request->warranty_status == "OUT OF WARRANTY") {
				$status_down_payment = 'UNPAID';
			} else {
				$status_down_payment = $request->warranty_status;
			}
		}

		if (!empty($transaction_details->final_payment_url)) {
			$status_final_payment = 'PAID';
		} else {
			if ($request->warranty_status == "OUT OF WARRANTY") {
				$status_final_payment = 'UNPAID';
			} else {
				$status_final_payment = $request->warranty_status;
			}
		}

		$ProblemDetails = implode(",", $request->problem_details);
		DB::table('returns_header')->where('id', $request->id)->update([
			'email'   					=> $request->email,
			'contact_no'   				=> $request->contact_no,
			'diagnostic_cost'   		=> $request->diagnostic_cost,
			'diagnostic_fee_status'		=> $status_diagnostic_fee,
			'downpayment_status' 		=> $status_down_payment,
			'final_payment_status' 		=> $status_final_payment,
			'warranty_status'			=> $request->warranty_status,
			'memo_no' 					=> $request->memo_number,
			'problem_details'			=> $ProblemDetails,
			'problem_details_other'		=> $request->problem_details_other,
			'other_remarks'		        => $request->other_remarks,
			'updated_by'            	=> CRUDBooster::myId()
		]);

		if ($transaction_details->repair_status == 8) {
			return redirect()->back();
		} else {
			return redirect('/admin/pay_diagnostic/PrintReceivingForm/' . $request->id);
		}
	}

	public function DiagnosticPaymentStatus(Request $request)
	{
		$transaction_details = DB::table('returns_header')->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'model.id as model_id', 'model_name', 'model_photo', 'model_status')
			->where('returns_header.id', $request->header_id)->get();

		if ($request->status_id == 'send') {
			if ($request->warranty_status == 'OUT OF WARRANTY') {
				$data = array();
				$data['id'] = $request->header_id;
				$data['reference_no'] = $transaction_details[0]->reference_no;
				$data['first_name'] = $transaction_details[0]->first_name;
				$data['last_name'] = $transaction_details[0]->last_name;
				$data['diagnostic_cost'] = number_format($request->diagnostic_cost, 2, '.', ',');
				$data['model_name'] = $transaction_details[0]->model_name;
				$data['main_url'] = URL::to('/');

				if (URL::to('/') == "https://antriku.beyondthebox.ph") {
					$email = $request->email;
				} else {
					$email = "lewieadona@digits.ph";
				}

				CRUDBooster::sendEmail(['to' => $email, 'data' => $data, 'template' => 'send_payment_link_for_diagnostic_fee_email', 'attachments' => []]);

				DB::table('returns_header')->where('id', $request->header_id)->update([
					'send_diagnostic_payment_link' => 'YES'
				]);
			}
		} elseif ($request->status_id == 1) {
			DB::table('returns_header')->where('id', $request->header_id)->update([
				'repair_status' 			=> 1,
				'updated_by'            	=> CRUDBooster::myId(),
				'level2_personnel'          => CRUDBooster::myId(),
				'level2_personnel_edited'   => date('Y-m-d H:i:s')
			]);
		}

		return ($transaction_details);
	}

	public function search_item(Request $request)
	{
		$data = array();
		$data['sample_count'] = $xx;
		$data['status_no'] = 0;
		$data['message']   = 'No Item Found!';
		$data['items'] = array();
		$items = DB::table('product_item_master')
			->orWhere('product_item_master.digits_code', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.upc_code', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.item_description', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.upc_code2', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.upc_code3', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.upc_code4', 'LIKE', '%' . $request->search . '%')
			->orWhere('product_item_master.upc_code5', 'LIKE', '%' . $request->search . '%')
			->select('product_item_master.*')->take(500)->get();

		if ($items) {
			$data['status'] = 1;
			$data['problem']  = 1;
			$data['status_no'] = 1;
			$data['message']   = 'Item Found';
			$i = 0;
			foreach ($items as $key => $value) {
				$return_data[$i]['id'] = $value->id;
				$return_data[$i]['digits_code'] = $value->digits_code;
				$return_data[$i]['upc_code'] = $value->upc_code;
				$return_data[$i]['item_description'] = $value->item_description;
				$i++;
			}
			$data['items'] = $return_data;
		}
		echo json_encode($data);
		exit;
	}

	public function model(Request $request)
	{
		$model = DB::table('model')->where('id', $request->model)->orderBy('model_name', 'ASC')->get();
		return ($model);
	}

	public function comment(Request $request)
	{
		DB::table('returns_comments')->insertGetId([
			'returns_header_id'			=> $request->id,
			'comments'					=> $request->comment,
			'created_by'				=> CRUDBooster::myId()
		]);

		$Comments = DB::table('returns_comments')
			->leftJoin('cms_users', 'returns_comments.created_by', '=', 'cms_users.id')
			->leftJoin('cms_privileges', 'cms_users.id_cms_privileges', '=', 'cms_privileges.id')
			->select('returns_comments.returns_header_id as header_id', 'returns_comments.comments as comment', DB::raw("DATE_FORMAT(returns_comments.created_at, '%M %d, %Y %h:%i %p') as comment_date"), 'cms_users.name as name', 'cms_users.id as userid',  'cms_users.photo as userimg', 'cms_privileges.name as role')
			->where('returns_comments.returns_header_id', $request->id)->orderBy('returns_comments.created_at', 'ASC')->get();

		return ($Comments);
	}

	// PRINT RECEIVING FORM
	public function PrintReceivingForm($id)
	{
		$data = array();
		$data['page_title'] = 'Print Receiving Form';
		$data['transaction_details'] = DB::table('returns_header')
			->leftJoin('returns_body_item', 'returns_header.id', '=', 'returns_body_item.returns_header_id')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->select('returns_header.*', 'returns_body_item.*', 'returns_header.id as header_id', 'returns_header.created_by as user_id', 'returns_serial.serial_number as serial_no', 'model.id as model_id', 'model_name', 'model_photo', 'model_status')
			->where('returns_header.id', $id)->first();

		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$this->cbView("print_form.print_receiving_form", $data);
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
			->where('returns_body_item.returns_header_id', $data['transaction_details']->header_id)->get();

		$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$this->cbView("print_form.print_technical_report", $data);
	}

	// PRINT RELEASE FORM
	public function PrintReleaseForm($id)
	{
		$data = array();
		$data['page_title'] = 'Print Release Form';
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

		$data['Quotation'] = DB::table('returns_body_item')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->where('returns_body_item.returns_header_id', $data['transaction_details']->header_id)->get();

		$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$this->cbView("print_form.print_release_form", $data);
	}

	// PRINT SAME DAY RELEASE FORM
	public function PrintSameDayReleaseForm($id)
	{
		$data = array();
		$data['page_title'] = 'Print Release Form';
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

		$data['Quotation'] = DB::table('returns_body_item')
			->leftJoin('returns_serial', 'returns_body_item.id', '=', 'returns_serial.returns_body_item_id')
			->where('returns_body_item.returns_header_id', $data['transaction_details']->header_id)->get();

		$data['Model'] = DB::table('model')->orderBy('model_name', 'ASC')->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$this->cbView("print_form.print_release_form", $data);
	}

	// STATUS OF PRINT FORM
	public function PrintStatus(Request $request)
	{
		$data = $request->all();
		$header_id = $data['header_id'];

		if ($data['print_form_type'] == 1) {
			DB::table('returns_header')->where('id', $header_id)->update([
				'print_receive_form' => "YES",
				'updated_by' => CRUDBooster::myId()
			]);
		} elseif ($data['print_form_type'] == 2) {
			DB::table('returns_header')->where('id', $header_id)->update([
				'print_technical_report' => "YES",
				'updated_by' => CRUDBooster::myId()
			]);
		} elseif ($data['print_form_type'] == 3) {
			DB::table('returns_header')->where('id', $header_id)->update([
				'print_release_form' => "YES",
				'updated_by' => CRUDBooster::myId()
			]);
		}
		return ($data);
	}

	public function verfiyEmail(Request $request)
	{
		$email = $request->input('email');
		$apiKey = "b7b56faaa6eec3f22d39f55d68155f79";
		$url = "http://apilayer.net/api/check?access_key={$apiKey}&email={$email}&smtp=1&format=1";

		$client = new Client();
		$response = $client->request('GET', $url);
		$result = json_decode($response->getBody(), true);

		if ($result['format_valid'] && $result['smtp_check']) {
			return response()->json([
				'valid_email' => 'Valid and active email.'
			]);
		} else {
			return response()->json([
				'invalid_email' => 'Invalid email or non-existent!'
			]);
		}
	}

	public function uploadPdf(Request $request)
	{
		// Validate
		$request->validate([
			'pdf' => 'required|mimes:pdf|max:25600',
		]);

		// save PDF file to Drive
		$file = $request->file('pdf');
		$fileName = date('Y-m-d') . '_' . $file->getClientOriginalName();

		$existingFile = DB::table('pdf_files_tracker')->where('pdf_file_name', $fileName)->first();
		
		if ($existingFile) {
			return response()->json(['error' => 'PDF File already uploaded!', 'file_name' => $fileName], 400);
		}

		$filePath = Storage::disk('google')->put($fileName, file_get_contents($file));

		if ($filePath) {
			$created = DB::table('pdf_files_tracker')->insert([
				'pdf_file_name' => $fileName,
				'save_drive' => 1,
				'save_drive_by' => CRUDBooster::myId(),
				'save_drive_at' => now()
			]);

			if($created){
				return response()->json(['message' => 'File uploaded successfully!', 'file_name' => $fileName]);
			}
		}

		return response()->json(['error' => 'Failed to upload file'], 500);
	}

	public function sendPdf(Request $request)
	{
		// Validate the request
		$request->validate([
			'contact_no' => 'required',
			'first_name' => 'required',
			'last_name' => 'required',
			'email' => 'required|email',
			'pdf' => 'required|file|mimes:pdf|max:25600',
		]);

		$pdfFile = $request->file('pdf');
		$fileName = date('Y-m-d') . '_' . $pdfFile->getClientOriginalName();
		$pdfPath = storage_path('app/temp_pdfs/' . $fileName);

		// Move file to storage
		$pdfFile->storeAs('temp_pdfs', $fileName);

		// Define ZIP file path
		$zipFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.zip';
		$zipFilePath = storage_path('app/temp_pdfs/' . $zipFileName);

		// Set encryption ZIP key
		$contactNo = $request->contact_no;
		$lastFourDigits = substr($contactNo, -4); 
		$firstLetterFirstName = strtoupper(substr($request->first_name, 0, 1)); 
		$firstLetterLastName = strtoupper(substr($request->last_name, 0, 1)); 
		$lastLetterLastName = strtoupper(substr($request->last_name, -1)); 
		$zipPassword = $lastFourDigits . $firstLetterFirstName . $firstLetterLastName . $lastLetterLastName;

		// ZIP archive and add the PDF with encryption
		$zip = new ZipArchive();
		if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
			$zip->setPassword($zipPassword);
			$zip->addFile($pdfPath, $fileName);
			$zip->setEncryptionName($fileName, ZipArchive::EM_AES_256);
			$zip->close();
		} else {
			return response()->json(['message' => 'Failed to create ZIP file.'], 500);
		}

		// Send Email in ZIP Attachment
		Mail::to($request->email)->send(new EmailReceivePrintForm($zipFilePath, $zipFileName, $zipPassword));

		// Delete tempt files
		Storage::delete('temp_pdfs/' . $fileName);
		Storage::delete('temp_pdfs/' . $zipFileName);

		// Update Database Tracking
		$track_pdf_file = DB::table('pdf_files_tracker')->where('pdf_file_name', $fileName)->first();

		if ($track_pdf_file) {
			$updated = DB::table('pdf_files_tracker')->where('pdf_file_name', $fileName)->update([
				'send_email' => 1,
				'send_email_by' => CRUDBooster::myId(),
				'send_email_at' => now(),
			]);

			if ($updated) {
				return response()->json([
					'message' => 'PDF sent successfully!',
					'email' => $request->email,
					'file_name' => $fileName
				], 200);
			}
		}
	}
}