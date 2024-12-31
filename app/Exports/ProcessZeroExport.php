<?php
namespace App\Exports;

use App\Models\ProjectSale;
use App\Models\Unit;
use App\Models\Boq;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ProcessZeroExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $projectId;

    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Return the data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $process = ProjectSale::where('pro_id', $this->projectId)->get();

        // Summing the amounts
        $totalprocessAmount = $process->sum('pro_sale_amt');
        $totalprocessZeroAmount = $process->sum('pro_zero_amt');

        // Adding total row
        $process->push((object)[
            'code' => 'Total',
            'des' => '',
            'work' => '',
            'unit' => '',
            'qty' => '',
            'pro_sale_rate' => '',
            'pro_zero_rate' => '',
            'pro_sale_amt' => $totalprocessAmount,
            'pro_zero_amt' => $totalprocessZeroAmount,
            'remarks' => ''
        ]);

        return $process;
    }

    /**
     * Define the headers for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Boq Code', 'Description', 'Description of Work', 'Unit',
            'Quantity', 'Sales Rate', 'Zero Rate', 'Sales Amount', 'Zero Amount',
            'Remarks'
        ];
    }

    /**
     * Map each record for the export.
     *
     * @param mixed $process
     * @return array
     */
    public function map($process): array
    {
        if ($process->code === 'Total') {
            return [
                $process->code,
                $process->des,
                $process->work,
                $process->unit,
                $process->qty,
                $process->pro_sale_rate,
                $process->pro_zero_rate,
                $process->pro_sale_amt,
                $process->pro_zero_amt,
                $process->remarks
            ];
        }

        $unit = Unit::where('id', $process->unit)->first();
        $unitName = $unit ? $unit->unit : 'N/A';

        $boq = Boq::where('id', $process->code)->first();
        $boqCode = $boq ? $boq->code : 'N/A';

        return [
            $boqCode,
            $process->des,
            $process->work,
            $unitName,
            $process->qty,
            $process->pro_sale_rate,
            $process->pro_zero_rate,
            $process->pro_sale_amt,
            $process->pro_zero_amt,
            $process->remarks
        ];
    }

    /**
     * Register the events for the export.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Get the units for dropdown validation
                $units = Unit::pluck('unit')->toArray();
                $unitList = implode(',', $units);

                $lastRow = $event->sheet->getHighestRow();

                // Add data validation to the 'Unit' column (D)
                $dataValidation = $event->sheet->getDelegate()->getCell('D2')->getDataValidation();
                $dataValidation->setType(DataValidation::TYPE_LIST)
                    ->setAllowBlank(true)
                    ->setShowDropDown(true)
                    ->setFormula1('"' . $unitList . '"');

                $event->sheet->getDelegate()->setDataValidation("D2:D{$lastRow}", $dataValidation);
            }
        ];
    }
}
