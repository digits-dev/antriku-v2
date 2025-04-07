<?php

namespace App\Http\Controllers;

use Session;
use Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use crocodicstudio\crudbooster\helpers\CRUDBooster;

class AdminProductItemMasterController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
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
		$this->table = "product_item_master";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Digits Code", "name" => "digits_code"];
		$this->col[] = ["label" => "UPC Code", "name" => "upc_code"];
		$this->col[] = ["label" => "Item Description", "name" => "item_description"];
		$this->col[] = ["label" => "Status", "name" => "status"];
		$this->col[] = ["label" => "Date Created", "name" => "created_at"];
		$this->col[] = ["label" => "Date Updated", "name" => "updated_at"];
		$this->col[] = ["label" => "Created By", "name" => "created_by"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Digits Code', 'name' => 'digits_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'UPC Code', 'name' => 'upc_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'Item Description', 'name' => 'item_description', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-7'];
		$this->form[] = ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'validation' => 'required', 'width' => 'col-sm-7', 'dataenum' => 'ACTIVE;INACTIVE'];
		# END FORM DO NOT REMOVE THIS LINE

	}

	public function hook_query_index(&$query)
	{
		//Your code here
	}

	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		if ($column_index == 3) {
			if ($column_value == 'INACTIVE') {
				$column_value = '<span style="color: #F93154"><strong>' . $column_value . '</strong></span>';
			} elseif ($column_value == 'ACTIVE') {
				$column_value = '<span style="color: #00B74A"><strong>' . $column_value . '</strong></span>';
			}
		}

		if ($column_index == 6 || $column_index == 7) {
			$name = DB::table('cms_users')->where('id', $column_value)->value('name');
			$column_value = $name;
		}
	}

	public function hook_before_add(&$postdata)
	{
		//Your code here
		$postdata['created_by'] = CRUDBooster::myId();
	}

	public function hook_after_add($id)
	{
		//Your code here
	}

	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here
		$postdata['updated_by'] = CRUDBooster::myId();
	}

	public function hook_after_edit($id)
	{
		//Your code here 
	}

	public function getItemsCreatedAPI()
	{
		$secretKey = config('api.dimfs_secret_key');

		$uniqueString = time();
		$userAgent = $_SERVER['HTTP_USER_AGENT'] ?: config('api.user_agent');
		$xAuthorizationToken = md5($secretKey . $uniqueString . $userAgent);
		$xAuthorizationTime = $uniqueString;

		$page = 1;
		$perPage = 10000;
		$client = new Client();

		$response = $client->get(config('api.dimfs_api_created_link'), [
			'headers' => [
				'X-Authorization-Token' => $xAuthorizationToken,
				'X-Authorization-Time' => $xAuthorizationTime,
				'User-Agent' => $userAgent,
			],
			'query' => [
				'page' => $page,
				'limit' => $perPage,
			],
		]);

		if ($response->getStatusCode() == 200) {
			$data = json_decode($response->getBody()->getContents(), true);

			if (!empty($data["data"])) {
				$new_items = [];
				foreach ($data["data"] as $value) {
					$new_items[] = [
						'digits_code' => $value['digits_code'] ?? null,
						'upc_code' => $value['upc_code'] ?? null,
						'item_description' => $value['item_description'] ?? null,
					];
				}

				DB::table('product_item_master')->insert($new_items);
			}
		} else {
			Log::error('Error occurred: ' . $response->getStatusCode());
		}
	}
}
