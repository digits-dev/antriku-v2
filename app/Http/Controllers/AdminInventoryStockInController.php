<?php namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;

	class AdminInventoryStockInController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = false;
			$this->button_bulk_action = false;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "inventory_stock_in";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Reference Number","name"=>"reference_number"];
			$this->col[] = ["label"=>"Parts Item","name"=>"parts_item_master_id","join"=>"parts_item_master,spare_parts"];
			$this->col[] = ["label"=>"Qty","name"=>"qty"];
			$this->col[] = ["label"=>"Stock In Type","name"=>"stock_in_type"];
			$this->col[] = ["label"=>"Stock In Status","name"=>"stock_in_status"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created At","name"=>"created_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE
	        
	    }

	    public function hook_query_index(&$query) {
			if(in_array(CRUDBooster::myPrivilegeId(), [9])){
				$query->leftJoin('cms_users as usr', 'usr.id', '=', 'inventory_stock_in.created_by')
					->where('inventory_stock_in.stock_in_status', '=', 'Received')
					->where('usr.branch_id', CRUDBooster::me()->branch_id);
			} else {
				$query->where('stock_in_status', '=', 'Received');
			}
	            
	    }

	    public function hook_row_index($column_index,&$column_value) {	        
	    	
	    }

	}