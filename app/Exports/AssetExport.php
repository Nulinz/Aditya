<?php

namespace App\Exports;

use App\Models\AssetCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class AssetExport implements FromCollection, WithHeadings, WithMapping
{
    protected $createdBy;

    public function __construct()
    {
        $this->createdBy = Auth::id();
    }

    /**
     * Fetch the data for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AssetCode::where('asset_codes.created_by', $this->createdBy)
                       ->join('projects', 'asset_codes.pro_id', '=', 'projects.id')
                       ->get([
                           'projects.pro_title as project_name',
                           'asset_codes.asset_code',
                           'asset_codes.des as description',
                           'asset_codes.asset_date',
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
            'Item Code',
            'Description',
            'Asset Date',

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
            $row->asset_code,
            $row->description,
            $row->asset_date,
        ];
    }
}

