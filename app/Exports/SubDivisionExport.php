<?php

namespace App\Exports;

use App\Models\Division;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class SubDivisionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $createdBy;

    public function __construct()
    {
        $this->createdBy = Auth::id(); // Get the authenticated user's ID
    }

    /**
     * Fetch the data for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Division::where('divisions.created_by', $this->createdBy)
            ->join('projects', 'divisions.pro_id', '=', 'projects.id')
            ->join('boqs', 'divisions.boq', '=', 'boqs.id') // Join with boqs table
            ->get([
                'projects.pro_title as project_name',
                'boqs.code as boq_name', // Replace with the appropriate column name from boqs table
                'divisions.sub_code',
                'divisions.des',
                'divisions.created_at',
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
            'BOQ Name',
            'Sub Code',
            'Description',
            'Created At',
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
            $row->boq_name, // Adjusted for joined BOQ name
            $row->sub_code,
            $row->des,
            $row->created_at,
        ];
    }
}
