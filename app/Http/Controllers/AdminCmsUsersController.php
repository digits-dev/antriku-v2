<?php namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDbooster;
use crocodicstudio\crudbooster\controllers\CBController;

class AdminCmsUsersController extends CBController {


	public function cbInit() {
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon';	
		$this->button_import 	   = false;	
		$this->button_export 	   = true;	
		# END CONFIGURATION DO NOT REMOVE THIS LINE
	
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label"=>"Name","name"=>"name");
		$this->col[] = array("label"=>"Email","name"=>"email");
		$this->col[] = array("label"=>"Privilege","name"=>"id_cms_privileges","join"=>"cms_privileges,name");
		$this->col[] = array("label"=>"Branch","name"=>"branch_id");
		$this->col[] = array("label"=>"Photo","name"=>"photo","image"=>1);	
		$this->col[] = array("label"=>"Status","name"=>"status");
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array(); 		
		$this->form[] = array("label"=>"Name","name"=>"name",'required'=>true,'validation'=>'required|alpha_spaces','type'=>'hidden');
		$this->form[] = array("label"=>"First Name","name"=>"first_name",'required'=>false,'validation'=>'alpha_spaces','readonly'=>false);
		$this->form[] = array("label"=>"Last Name","name"=>"last_name",'required'=>false,'validation'=>'alpha_spaces','readonly'=>false);
		$this->form[] = array("label"=>"Email","name"=>"email",'required'=>true,'type'=>'email','validation'=>'required|email|unique:cms_users,email,'.CRUDBooster::getCurrentId(),'readonly'=>false);		
		$this->form[] = array("label"=>"Photo","name"=>"photo","type"=>"upload","help"=>"Recommended resolution is 200x200px",'required'=>true,'validation'=>'required|image|max:1000','resize_width'=>90,'resize_height'=>90);											
		$this->form[] = array("label"=>"Privilege","name"=>"id_cms_privileges","type"=>"select","datatable"=>"cms_privileges,name",'required'=>false);						
		$this->form[] = array("label"=>"Branch","name"=>"branch_id","type"=>"select2","datatable"=>"branch,branch_name","datatable_where"=>"branch_status='ACTIVE'");
		$this->form[] = array("label"=>"Password","name"=>"password","type"=>"password","help"=>"Please leave empty if not change");
		$this->form[] = array("label"=>"Password Confirmation","name"=>"password_confirmation","type"=>"password","help"=>"Please leave empty if not change");
		if(in_array(CRUDBooster::getCurrentMethod(),['getEdit','postEditSave','getDetail'])) {
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'select','validation'=>'required','width'=>'col-sm-6','dataenum'=>'ACTIVE;INACTIVE'];
		}
		# END FORM DO NOT REMOVE THIS LINE
		
		$this->button_selected = array();
		if(CRUDBooster::isSuperadmin()){
			$this->button_selected[] = ["label"=>"Set Status ACTIVE ","icon"=>"fa fa-check-circle","name"=>"set_status_ACTIVE"];
			$this->button_selected[] = ["label"=>"Set Status INACTIVE","icon"=>"fa fa-times-circle","name"=>"set_status_INACTIVE"];
			$this->button_selected[] = ["label"=>"Reset Password","icon"=>"fa fa-refresh","name"=>"reset_password"];
		}
	}
	
		public function hook_row_index($column_index,&$column_value) 
		{	        
    		//Your code here
    		if($column_index == 4){
                $Branch = DB::table('branch')->where('id',$column_value)->first();
                $column_value = $Branch->branch_name;
    	    }
	    }
	    
	public function actionButtonSelected($id_selected,$button_name) {
		//Your code here
		switch ($button_name) {
			case 'set_status_ACTIVE':
				DB::table('cms_users')->whereIn('id',$id_selected)->update([
					'status'=>'ACTIVE', 
					'updated_at' => date('Y-m-d H:i:s')
				]);
				break;
			case 'set_status_INACTIVE':
				DB::table('cms_users')->whereIn('id',$id_selected)->update([
					'status'=>'INACTIVE', 
					'updated_at' => date('Y-m-d H:i:s')
				]);
				break;
			case 'reset_password':
				DB::table('cms_users')->whereIn('id',$id_selected)->update([
					'password'=>bcrypt('qwerty2022'),
					'updated_at' => date('Y-m-d H:i:s')
				]);
				break;
			default:
				# code...
				break;
		}    
	}

	public function getProfile() {			

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;			
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;	
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = cbLang("label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users',CRUDBooster::myId());

        return $this->view('crudbooster::default.form',$data);
	}
	public function hook_before_edit(&$postdata,$id) { 
        $postdata['name'] = $postdata['first_name'].' '.$postdata['last_name'];
		unset($postdata['password_confirmation']);
	}
	public function hook_before_add(&$postdata) {      
        $postdata['name'] = $postdata['first_name'].' '.$postdata['last_name']; 
	    unset($postdata['password_confirmation']);
	}
}
