<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class MaterialExport implements FromCollection, WithHeadings, WithMapping
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
        return Material::where('materials.created_by', $this->createdBy)
                       ->join('projects', 'materials.pro_id', '=', 'projects.id')
                       ->get([
                           'projects.pro_title as project_name',
                           'materials.item_code',
                           'materials.des as description',
                           'materials.created_at',
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
