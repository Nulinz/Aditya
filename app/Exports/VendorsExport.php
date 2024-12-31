<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Facades\Auth;

class VendorsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $createdBy;

    public function __construct()
    {
        $this->createdBy = Auth::id(); // Get the current authenticated user's ID
    }

    /**
     * Fetch the data for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Vendor::where('vendors.created_by', $this->createdBy)
                     ->join('projects', 'vendors.pro_id', '=', 'projects.id')
                     ->get([
                         'vendors.pro_id as project_id',
                         'projects.pro_title as project_name',
                         'vendors.type',
                         'vendors.ven_date',
                         'vendors.v_code',
                         'vendors.v_name',
                         'vendors.address',
                         'vendors.gst',
                         'vendors.pan',
                         'vendors.aadhar',
                         'vendors.bank',
                         'vendors.ac_name',
                         'vendors.ac_no',
                         'vendors.ifsc',
                         'vendors.branch',
                         'vendors.mob',
                         'vendors.mail',
                         'vendors.trade',
                     ]);
    }

    /**
     * Define the headings for the export
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Project Name',
            'Type',
            'Vendor Date',
            'Vendor Code',
            'Vendor Name',
            'Address',
            'GST',
            'PAN',
            'Aadhar',
            'Bank Name',
            'Account Holder',
            'Account Number',
            'IFSC Code',
            'Branch',
            'Mobile',
            'Email',
            'Trade',
        ];
    }

    /**
     * Map the data to be exported
     *
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->project_name,
            $row->type,
            $row->ven_date,
            $row->v_code,
            $row->v_name,
            $row->address,
            $row->gst,
            $row->pan,
            $row->aadhar,
            $row->bank,
            $row->ac_name,
            $row->ac_no,
            $row->ifsc,
            $row->branch,
            $row->mob,
            $row->mail,
            $row->trade,
        ];
    }
}
