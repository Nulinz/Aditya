<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\Overhead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class OverheadExport implements FromCollection, WithHeadings, WithMapping
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
        return Overhead::where('overheads.created_by', $this->createdBy)
                       ->join('projects', 'overheads.pro_id', '=', 'projects.id')
                       ->get([
                           'projects.pro_title as project_name',
                           'overheads.item_code',
                           'overheads.mat_des as description',
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
            $row->item_code,
            $row->description,
        ];
    }
}
