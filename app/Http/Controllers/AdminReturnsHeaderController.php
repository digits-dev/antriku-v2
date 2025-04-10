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
use Illuminate\Support\Facades\Log;
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
		$this->col[] = ["label" => "Diagnostic Payment Status", "name" => "diagnostic_fee_status"];
		$this->col[] = ["label" => "Diagnostic Fee", "name" => "diagnostic_cost"];
		$this->col[] = ["label" => "Date Created", "name" => "created_at"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by", 'join' => 'cms_users,name'];
		# END COLUMNS DO NOT REMOVE THIS LINE
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

		$cities_client = new Client();
    	$response = $cities_client->get('https://psgc.gitlab.io/api/regions.json');	
    	$data['cities'] = json_decode($response->getBody(), true);

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
		$provinces_client = new Client();
		$response = $provinces_client->request('GET', 'https://psgc.gitlab.io/api/provinces/');
    	$provinces = json_decode($response->getBody(), true); 
		return response()->json($provinces);
	}

	public function getCities(Request $request)
	{
		$baseUrl = 'https://psgc.gitlab.io/api/';
		$cities_client = new Client();
		$cities = [];
		
		try {
			// Check if the province code is for Metro Manila
			if ($request->input('prov_code') === '00') {
				$response_metro_manila = $cities_client->get("https://psgc.gitlab.io/api/cities-municipalities.json");
				$cities_in_manila = json_decode($response_metro_manila->getBody(), true);
				
				$cities = array_filter($cities_in_manila, function($city) {
					return $city['regionCode'] === '130000000'; // NCR region
				});

				return response()->json(array_values($cities));
			} else {
				// Non-Metro Manila
				$response = $cities_client->get("{$baseUrl}provinces/{$request->input('prov_code')}/cities-municipalities/");
				$cities = json_decode($response->getBody(), true);
				
				return response()->json($cities);
			}
		} catch (\Exception $e) {
			return response()->json(['error' => 'Failed to fetch cities', 'message' => $e->getMessage()], 500);
		}
	}

	public function getBrgy(Request $request)
	{
		$baseUrl = 'https://psgc.gitlab.io/api/';
		$barangays_client = new Client();
		$cityMunCode = $request->input('city_mun_code');
		$response = $barangays_client->get("{$baseUrl}cities-municipalities/{$cityMunCode}/barangays/");
		$barangays = json_decode($response->getBody(), true);
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

	public function hook_query_index(&$query)
	{
		//Your code here
		if (CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6) {
			$query->where('repair_status', 24)->where('print_receive_form', 'NO')->orderBy('id', 'asc');
		} else {
			$query->where('repair_status', 24)->where('print_receive_form', 'NO')->where('branch', CRUDBooster::me()->branch_id)->orderBy('id', 'asc');
		}
	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		$pending = DB::table('transaction_status')->where('id', '24')->first();
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

		if ($column_index == 6) {
			$column_value = '₱' . $column_value;
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
			'repair_status' 			=> ($data['warranty_status'] === "OUT OF WARRANTY") ? 8 : 24,
			'last_name'   				=> $data['last_name'],
			'first_name'   				=> $data['first_name'],
			'email'   					=> $data['email'],
			'country'					=> $data['country'],
			'province'					=> $data['province'],
			'city'						=> $data['city'],
			'barangay'					=> $data['barangay'],
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
			'other_inclusion'			=> $data['other_inclusion'],
			'header_item_description'	=> $data['item_description'],
			'model'						=> $data['model'],
			'unit_type'					=> $data['unit_type'],
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
		
		$this->save_inspected_model($data['marked_image_base64'], $tracking_number, $headerID);

		return (array(['header_id' => $headerID, 'ref_no' => $tracking_number, 'warranty_status' => $data['warranty_status']]));
	}

	private function save_inspected_model($marked_image_base64, $tracking_number, $headerID){
		if (isset($marked_image_base64) && !empty($marked_image_base64)) {
			$base64Image = $marked_image_base64;
			[$type, $data] = explode(',', $base64Image);
			$imageData = base64_decode($data);
			$fileName = $tracking_number . '_inspected_' . time() . '.png';
			Storage::put("public/inspections/$fileName", $imageData);
			DB::table('returns_header')->where('id', $headerID)->update([
				'inspected_model_photo' => 'inspections/'.$fileName,
			]);
		} else {
			Log::error("Missing or invalid 'marked_image_base64' data.");
		}
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
				'print_receiving_form_by' => CRUDBooster::myId(),
				'print_receiving_form_at' => now(),
				'updated_by' => CRUDBooster::myId()
			]);
		} elseif ($data['print_form_type'] == 2) {
			DB::table('returns_header')->where('id', $header_id)->update([
				'print_technical_report' => "YES",
				'updated_by' => CRUDBooster::myId()
			]);
		} elseif ($data['print_form_type'] == 3) {
			$get_header_data = DB::table('returns_header')->where('id', $header_id)->first();
			if($get_header_data->repair_status == 3){
				DB::table('returns_header')->where('id', $header_id)->update([
					'print_release_form' => "YES",
					'updated_by' => CRUDBooster::myId()
				]);
			} else {
				DB::table('returns_header')->where('id', $header_id)->update([
					'print_release_form' => "YES",
					'print_releasing_form_by' => CRUDBooster::myId(),
					'print_releasing_form_at' => now(),
					'repair_status' => 6,
					'completed_by' => CRUDBooster::myId(),
					'completed_at' => now(),
					'updated_by' => CRUDBooster::myId()
				]);
			}
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