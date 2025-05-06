<?php

namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPendingRepairController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "company_name";
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
		$this->col[] = ["label" => "Warranty Status", "name" => "warranty_status"];
		$this->col[] = ["label" => "Case Status", "name" => "case_status"];
		$this->col[] = ["label" => "Technician Assigned", "name" => "technician_id", 'join' => 'cms_users,name'];
		$this->col[] = ["label" => "Date Received", "name" => "technician_accepted_at"];
		$this->col[] = ["label" => "Branch", "name" => "branch", 'join' => 'branch,branch_name'];
		# END COLUMNS DO NOT REMOVE THIS LINE

		if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])) {

			$this->addaction[] = [
				'title'   => 'Edit Data',
				'url'   => CRUDBooster::mainpath('edit/[id]'),
				'icon'  => 'fa fa-pencil',
				'color' => 'success',
			];
		}

		$this->script_js = "
		function handleSwal(id, reference_no, technician_id) {
		assignTechnician(id, reference_no, technician_id);
		}
		";

		$this->post_index_html = '
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="' . asset('js/jobActions.js') . '"></script>
	';
	}



	public function hook_query_index(&$query)
	{
		if (in_array(CRUDBooster::myPrivilegeId(), [4, 8])) {
			$query->where('technician_id', CRUDBooster::myId())->whereIn('repair_status', [30, 31, 34, 40, 41, 42])
				->orderby('returns_header.id', 'ASC');
		} else {
			$query->whereIn('repair_status', [30, 31, 34, 40, 41, 42]);
		}
	}

	public function hook_row_index($column_index, &$column_value)
	{
		$for_order_spare_part_carry_in = DB::table('transaction_status')->where('id', '30')->first();
		$spare_part_release = DB::table('transaction_status')->where('id', '31')->first();
		$ongoing_repair = DB::table('transaction_status')->where('id', '34')->first();
		$for_order_spare_part_carry_in_oow = DB::table('transaction_status')->where('id', '40')->first();
		$spare_part_release_oow = DB::table('transaction_status')->where('id', '41')->first();
		$ongoing_repair_oow = DB::table('transaction_status')->where('id', '42')->first();

		if ($column_index == 1) {
			if ($column_value == $for_order_spare_part_carry_in->id) {
				$column_value = '<span class="label label-warning">' . $for_order_spare_part_carry_in->status_name . '</span>';
			}
			if ($column_value == $spare_part_release->id) {
				$column_value = '<span class="label label-warning">' . $spare_part_release->status_name . '</span>';
			}
			if ($column_value == $ongoing_repair->id) {
				$column_value = '<span class="label label-warning">' . $ongoing_repair->status_name . '</span>';
			}
			if ($column_value == $for_order_spare_part_carry_in_oow->id) {
				$column_value = '<span class="label label-warning">' . $for_order_spare_part_carry_in_oow->status_name . '</span>';
			}
			if ($column_value == $spare_part_release_oow->id) {
				$column_value = '<span class="label label-warning">' . $spare_part_release_oow->status_name . '</span>';
			}
			if ($column_value == $ongoing_repair_oow->id) {
				$column_value = '<span class="label label-warning">' . $ongoing_repair_oow->status_name . '</span>';
			}
		}

		if ($column_index == 3) {
			$models = DB::table('model')->where('id', $column_value)->first();
			if ($models) {
				$model_group = DB::table('model_group')->where('id', $models->model_group)->first();
				$column_value = '<span class="label label-info">' . $model_group->model_group_name . '</span>';
			}
		}

		if ($column_index == 4) {
			if ($column_value == 'IN WARRANTY') {
				$column_value = '<span style="color: #00B74A"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'OUT OF WARRANTY') {
				$column_value = '<span style="color: #F93154"><strong>' . $column_value . '</strong></span>';
			}
		}

		if ($column_index == 5) {
			$column_value = '<span style="color: #1266F1"><strong>' . $column_value . '</strong></span>';
		}
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
			->where('returns_body_item.returns_header_id', $id)->get();
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
			->where('returns_body_item.returns_header_id', $id)->get();
		$data['defective_serial_numbers'] = DB::table('defective_serial_number')->where('returns_header_id', $id)->get();
		$data['Branch'] = DB::table('branch')->leftJoin('cms_users', 'branch.id', '=', 'cms_users.branch_id')->where('cms_users.id', $data['transaction_details']->user_id)->first();
		$data['imfs'] = DB::table('product_item_master')->where('status', 'ACTIVE')->get();
		$data['ProblemDetails'] = DB::table('problem_details')->where('status', 'ACTIVE')->orderBy('problem_details', 'ASC')->get();
		$data['TechTesting'] = DB::table('tech_testing')->where('test_type_status', 'ACTIVE')->where('model_group_id', '!=', NULL)->orderBy('description', 'ASC')->get();

		$this->cbView('transaction_details.view_created_transaction_detail', $data);
	}

	public function filterDoaSparePart(Request $request)
	{
		$get_spare_part = DB::table('parts_item_master')->where('id', $request->spare_parts_id)->first();

		if (!empty($get_spare_part)) {
			return response()->json(['success' => true, 'message' => 'Successfully filtered.', 'response_data' => $get_spare_part]);
		} else {
			return response()->json(['success' => false, 'message' => 'Successfully filtered.']);
		}
	}

	public function saveDoaSparePart(Request $request)
	{
		$request->validate([
			'header_id' => 'required|integer',
			'spare_part_code' => 'required|string',
			'doa_item_desc' => 'required|string',
			'doa_item_qty' => 'required|numeric',
			'doa_item_id' => 'required|integer',
			'doa_item_price' => 'required|numeric',
		]);

		DB::beginTransaction();

		try {
			// Update existing record for DOA
			DB::table('returns_body_item')
				->where('returns_header_id', $request->header_id)
				->where('item_parts_id', $request->doa_item_id)
				->update([
					'qty_status' => 'Available-DOA',
					'updated_by' => CRUDBooster::myId(),
					'updated_at' => now(),
				]);

			// Insert new DOA spare part
			DB::table('returns_body_item')->insert([
				'returns_header_id' => $request->header_id,
				'item_description' => $request->doa_item_desc,
				'service_code' => $request->spare_part_code,
				'qty' => $request->doa_item_qty,
				'qty_status' => $request->doa_item_qty > 0 ? 'Available' : 'Unavailable',
				'item_parts_id' => $request->doa_item_id,
				'item_spare_additional_type' => 'Additional-Standard-DOA',
				'cost' => $request->doa_item_price,
				'created_by' => CRUDBooster::myId(),
				'created_at' => now(),
			]);

			DB::commit();

			return response()->json(['success' => true, 'message' => 'DOA spare part saved successfully.']);
		} catch (\Exception $e) {
			DB::rollBack();
			Log::error('Failed to save DOA spare part: ' . $e->getMessage());

			return response()->json(['success' => false, 'message' => 'Failed to save DOA spare part.'], 500);
		}
	}
}