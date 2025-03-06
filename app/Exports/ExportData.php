<?php
   
namespace App;
   
use DB;
use CRUDBooster;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
   
class ExportData implements FromCollection, WithHeadings
{
    protected $filter_column;
    
    public function __construct($fields){
        $this->filter_column  = $fields;
    }
    
    public function collection()
    {
        if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6){
            $showcolumn = [
                'reference_no','status_name','warranty_status', 
                'print_receive_form', 'print_technical_report', 'print_release_form', 
                'send_diagnostic_payment_link','send_down_payment_link', 'send_final_payment_link', 
                'diagnostic_fee_payment_date_created','down_payment_date_created','final_payment_date_created', 
                'diagnostic_fee_payment_url', 'down_payment_url', 'final_payment_url',
                'diagnostic_fee_status', 'downpayment_status', 'final_payment_status', 
                'diagnostic_cost', 'software_cost', 'parts_total_cost', 'downpayment_cost', 'final_payment_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'purchase_date', 'warranty_expiration_date', 'memo_no', 'model_name',
                'summary_of_concern', 'header_upc_code', 'header_item_description', 'header_serial_no', 'device_issue_description', 'findings', 'resolution', 'other_diagnostic',
                'problem_details', 'problem_details_other', 
                'created.name AS createdby', 'updated.name AS updatedby', 'returns_header.created_at AS datecreated', 'returns_header.updated_at AS dateupdated', 'AssignedTechnician.name AS assignedTechnician', 'updated.name AS servicedby', 'service_time'
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 2){
            $showcolumn = [
                'reference_no','status_name','warranty_status', 
                'print_receive_form', 'print_technical_report', 'print_release_form', 
                'diagnostic_fee_payment_date_created','down_payment_date_created','final_payment_date_created', 
                'diagnostic_fee_payment_url', 'down_payment_url', 'final_payment_url',
                'diagnostic_fee_status', 'downpayment_status', 'final_payment_status', 
                'diagnostic_cost', 'software_cost', 'parts_total_cost', 'downpayment_cost', 'final_payment_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'purchase_date', 'warranty_expiration_date', 'memo_no', 'model_name',
                'summary_of_concern', 'header_upc_code', 'header_item_description', 'header_serial_no', 'device_issue_description', 'findings', 'resolution', 'other_diagnostic',
                'problem_details', 'problem_details_other', 
                'created.name AS createdby', 'updated.name AS updatedby', 'returns_header.created_at AS datecreated', 'returns_header.updated_at AS dateupdated', 'updated.name AS servicedby', 'service_time'
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 3){
            $showcolumn = [
                'reference_no','status_name','warranty_status', 
                'print_receive_form', 'print_release_form', 
                'diagnostic_fee_payment_date_created','final_payment_date_created', 
                'diagnostic_fee_payment_url','final_payment_url',
                'diagnostic_fee_status', 'final_payment_status', 
                'diagnostic_cost', 'final_payment_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'purchase_date', 'warranty_expiration_date', 'memo_no', 'model_name',
                'summary_of_concern', 'header_upc_code', 'header_item_description', 'header_serial_no', 'device_issue_description', 'findings', 'resolution', 'other_diagnostic',
                'problem_details', 'problem_details_other', 
                'created.name AS createdby', 'updated.name AS updatedby', 'returns_header.created_at AS datecreated', 'returns_header.updated_at AS dateupdated', 'updated.name AS servicedby', 'service_time'
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 4){
            $showcolumn = [
                'reference_no','status_name','warranty_status', 
                'print_technical_report',
                'down_payment_date_created',
                'down_payment_url', 
                'downpayment_status', 
                'downpayment_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'purchase_date', 'warranty_expiration_date', 'memo_no', 'model_name',
                'summary_of_concern', 'header_upc_code', 'header_item_description', 'header_serial_no', 'device_issue_description', 'findings', 'resolution', 'other_diagnostic',
                'problem_details', 'problem_details_other', 
                'created.name AS createdby', 'updated.name AS updatedby', 'returns_header.created_at AS datecreated', 'returns_header.updated_at AS dateupdated', 'updated.name AS servicedby', 'service_time'
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 5){
            $showcolumn = [
                'reference_no','status_name',
                'diagnostic_fee_payment_date_created','down_payment_date_created','final_payment_date_created', 
                'diagnostic_fee_payment_url', 'down_payment_url', 'final_payment_url',
                'diagnostic_fee_status', 'downpayment_status', 'final_payment_status', 
                'diagnostic_cost', 'downpayment_cost', 'final_payment_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'created.name AS createdby', 'updated.name AS updatedby', 'returns_header.created_at AS datecreated', 'returns_header.updated_at AS dateupdated', 'updated.name AS servicedby', 'service_time'
            ];
        }else{
            $showcolumn = [];
        }

        $all_data = DB::table('returns_header')
			->leftJoin('transaction_status', 'returns_header.repair_status', '=', 'transaction_status.id')
			->leftJoin('model', 'returns_header.model', '=', 'model.id')
			->leftJoin('cms_users AS created', 'returns_header.created_by', '=', 'created.id')
			->leftJoin('cms_users AS updated', 'returns_header.updated_by', '=', 'updated.id')
            ->leftJoin('cms_users AS AssignedTechnician', 'returns_header.level3_personnel', '=', 'AssignedTechnician.id');
        
        // Check if date_from and date_to are provided in the filter
        if (!empty($this->filter_column['date_from']) && !empty($this->filter_column['date_to'])) {
            $all_data->whereBetween('returns_header.updated_at', [
                $this->filter_column['date_from'],
                $this->filter_column['date_to']
            ]);
        }
			
		if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6){
		    $export_all_data = $all_data->select($showcolumn)->orderBy('returns_header.id')->get();
		}else{
		    $export_all_data = $all_data->select($showcolumn)->where('returns_header.branch', CRUDBooster::me()->branch_id)->orderBy('returns_header.id')->get();
		}
			
		

        return $export_all_data;
    }

    public function headings(): array
    {
        if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeId() == 6){
            $headings = [
                "REF#","REPAIR STATUS","WARRANTY STATUS",
                "PRINT RECEIVE FORM","PRINT TECHNICAL REPORT","PRINT RELEASE FORM",
                "SEND DIAGNOSTIC LINK","SEND DOWN PAYMENT LINK","SENT FINAL PAYMENT LINK",
                "DIAGNOSTIC PAYMENT DATE","DOWN PAYMENT DATE","FINAL PAYMENT DATE",
                "DIAGNOSTIC URL","DOWN PAYMENT URL","FINAL PAYMENT URL",
                "DIAGNOSTIC FEE STATUS","DOWN PAYMENT STATUS","FINAL PAYMENT STATUS",
                "DIAGNOSTIC FEE COST","SOFTWARE FEE COST","PARTS TOTAL COST","DOWN PAYMENT COST","FINAL PAYMENT COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "PURCHASE DATE","WARRANTY EXPIRATION","MEMO NUMBER","MODEL","SUMMARY OF CONCERN", " "," "," ",
                "DEVICE ISSUE","FINDINGS","RESOLUTION","OTHER DIAGNOSIS","PROBLEM DETAILS","PROBLEM DETAILS (OTHERS)",
                "CREATED BY","UPDATED BY","CREATED DATE","UPDATED DATE","ASSIGNED TECHNICIAN","SERVICED BY","SERVICE TIME"
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 2){
            $headings = [
                "REF#","REPAIR STATUS","WARRANTY STATUS",
                "PRINT RECEIVE FORM","PRINT TECHNICAL REPORT","PRINT RELEASE FORM",
                "DIAGNOSTIC PAYMENT DATE","DOWN PAYMENT DATE","FINAL PAYMENT DATE",
                "DIAGNOSTIC URL","DOWN PAYMENT URL","FINAL PAYMENT URL",
                "DIAGNOSTIC FEE STATUS","DOWN PAYMENT STATUS","FINAL PAYMENT STATUS",
                "DIAGNOSTIC FEE COST","SOFTWARE FEE COST","PARTS TOTAL COST","DOWN PAYMENT COST","FINAL PAYMENT COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "PURCHASE DATE","WARRANTY EXPIRATION","MEMO NUMBER","MODEL","SUMMARY OF CONCERN", " "," "," ",
                "DEVICE ISSUE","FINDINGS","RESOLUTION","OTHER DIAGNOSIS","PROBLEM DETAILS","PROBLEM DETAILS (OTHERS)",
                "CREATED BY","UPDATED BY","CREATED DATE","UPDATED DATE","SERVICED BY","SERVICE TIME"
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 3){
            $headings = [
                "REF#","REPAIR STATUS","WARRANTY STATUS",
                "PRINT RECEIVE FORM","PRINT RELEASE FORM",
                "DIAGNOSTIC PAYMENT DATE","FINAL PAYMENT DATE",
                "DIAGNOSTIC URL","FINAL PAYMENT URL",
                "DIAGNOSTIC FEE STATUS","FINAL PAYMENT STATUS",
                "DIAGNOSTIC FEE COST","FINAL PAYMENT COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "PURCHASE DATE","WARRANTY EXPIRATION","MEMO NUMBER","MODEL","SUMMARY OF CONCERN", " "," "," ",
                "DEVICE ISSUE","FINDINGS","RESOLUTION","OTHER DIAGNOSIS","PROBLEM DETAILS","PROBLEM DETAILS (OTHERS)",
                "CREATED BY","UPDATED BY","CREATED DATE","UPDATED DATE","SERVICED BY","SERVICE TIME"
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 4){
            $headings = [
                "REF#","REPAIR STATUS","WARRANTY STATUS",
                "PRINT TECHNICAL REPORT","DOWN PAYMENT DATE",
                "DOWN PAYMENT URL","DOWN PAYMENT STATUS",
                "DOWN PAYMENT COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "PURCHASE DATE","WARRANTY EXPIRATION","MEMO NUMBER","MODEL","SUMMARY OF CONCERN", " "," "," ",
                "DEVICE ISSUE","FINDINGS","RESOLUTION","OTHER DIAGNOSIS","PROBLEM DETAILS","PROBLEM DETAILS (OTHERS)",
                "CREATED BY","UPDATED BY","CREATED DATE","UPDATED DATE","SERVICED BY","SERVICE TIME"
            ];
        }elseif(CRUDBooster::myPrivilegeId() == 5){
            $headings = [
                "REF#","REPAIR STATUS",
                "DIAGNOSTIC PAYMENT DATE","DOWN PAYMENT DATE","FINAL PAYMENT DATE",
                "DIAGNOSTIC URL","DOWN PAYMENT URL","FINAL PAYMENT URL",
                "DIAGNOSTIC FEE STATUS","DOWN PAYMENT STATUS","FINAL PAYMENT STATUS",
                "DIAGNOSTIC FEE COST","DOWN PAYMENT COST","FINAL PAYMENT COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "CREATED BY","UPDATED BY","CREATED DATE","UPDATED DATE","SERVICED BY","SERVICE TIME"
            ];
        }else{
            $headings = [];
        }
        
        return $headings;
    }
}
?>