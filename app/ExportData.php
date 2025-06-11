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
      
            $showcolumn = [
                'reference_no','status_name','returns_header.warranty_status', 'case_status', 
                'print_receive_form', 'print_technical_report', 'print_release_form', 
                'diagnostic_cost', 'parts_total_cost',
                'returns_header.last_name AS customer_last_name', 'returns_header.first_name AS customer_first_name', 
                'returns_header.email AS customer_email','address', 'contact_no', 'company_name','company_contact_no',
                'purchase_date', 'warranty_expiration_date', 'memo_no', 'model_name',
                'summary_of_concern', 'header_upc_code', 'header_item_description', 'header_serial_no', 'device_issue_description', 'findings', 'resolution', 'other_diagnostic',
                'problem_details', 'problem_details_other', 
                'created.name AS createdby','returns_header.created_at AS datecreated', 'AssignedTechnician.name AS assignedTechnician', 'AssignedTechnician.tech_id' ,
            ];

        $all_data = DB::table('returns_header')
            ->leftJoin('transaction_status', 'returns_header.repair_status', '=', 'transaction_status.id')
            ->leftJoin('model', 'returns_header.model', '=', 'model.id')
            ->leftJoin('cms_users AS created', 'returns_header.created_by', '=', 'created.id')
            ->leftJoin('cms_users AS updated', 'returns_header.updated_by', '=', 'updated.id')
            ->leftJoin('cms_users AS AssignedTechnician', 'returns_header.technician_id', '=', 'AssignedTechnician.id');

        if (!empty($this->filter_column['date_from']) && !empty($this->filter_column['date_to'])) {
            $all_data->whereBetween('returns_header.created_at', [
                $this->filter_column['date_from'],
                $this->filter_column['date_to']
            ]);
        }
        if(in_array(CRUDBooster::myPrivilegeId(), [3, 9, 4])){
             $export_all_data = $all_data->select($showcolumn)->where('returns_header.branch', CRUDBooster::me()->branch_id)->orderBy('returns_header.id')->get();
            \Log::debug($all_data->select($showcolumn)->where('returns_header.branch', CRUDBooster::me()->branch_id)->orderBy('returns_header.id')->toSql());
        }else {
              $export_all_data = $all_data->select($showcolumn)->orderBy('returns_header.id')->get();
            \Log::debug($all_data->select($showcolumn)->orderBy('returns_header.id')->toSql());
        }

        return $export_all_data;
    }

    public function headings(): array
    {
        
            $headings = [
                "REF#","REPAIR STATUS","WARRANTY STATUS", "CASE STATUS",
                "PRINT RECEIVE FORM","PRINT TECHNICAL FORM","PRINT RELEASE FORM",
                "DIAGNOSTIC FEE COST","PARTS TOTAL COST",
                "LAST NAME","FIRST NAME","EMAIL","ADDRESS","CONTACT NUMBER","COMPANY NAME","COMPANY CONTACT",
                "PURCHASE DATE","WARRANTY EXPIRATION","MEMO NUMBER","MODEL","SUMMARY OF CONCERN"," "," "," ",
                "DEVICE ISSUE","FINDINGS","RESOLUTION","OTHER DIAGNOSIS","PROBLEM DETAILS","PROBLEM DETAILS (OTHERS)",
                "CREATED BY","CREATED DATE","ASSIGNED TECHNICIAN", 'TECHNICIAN ID',
            ];

        return $headings;
    }
}