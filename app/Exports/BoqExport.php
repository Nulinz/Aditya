<?php
namespace App\Exports;

use App\Models\Boq;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class BoqExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
        $boqs = Boq::where('pro_id', $this->projectId)->get();

        $totalBoqAmount = $boqs->sum('boq_amount');
        $totalZeroAmount = $boqs->sum('zero_amount');

        $boqs->push((object)[
            'code' => 'Total',
            'description' => '',
            'des' => '',
            'unit' => '',
            'qty' => '',
            'boq_rate' => '',
            'zero_rate' => '',
            'boq_amount' => $totalBoqAmount,
            'zero_amount' => $totalZeroAmount,
            'remarks' => ''
        ]);

        return $boqs;
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
            'Quantity', 'BOQ Rate', 'Zero Rate', 'BOQ Amount', 'Zero Amount',
            'Remarks'
        ];
    }

    /**
     * Map each record for the export.
     *
     * @param mixed $boq
     * @return array
     */
    public function map($boq): array
    {
        if ($boq->code === 'Total') {
            return [
                $boq->code,
                $boq->description,
                $boq->des,
                $boq->unit,
                $boq->qty,
                $boq->boq_rate,
                $boq->zero_rate,
                $boq->boq_amount,
                $boq->zero_amount,
                $boq->remarks
            ];
        }

        $unit = Unit::where('id', $boq->unit)->first();
        $unitName = $unit ? $unit->unit : 'N/A';

        return [
            $boq->code,
            $boq->description,
            $boq->des,
            $unitName,
            $boq->qty,
            $boq->boq_rate,
            $boq->zero_rate,
            $boq->boq_amount,
            $boq->zero_amount,
            $boq->remarks
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

            $units = Unit::pluck('unit')->toArray();

            $unitList = implode(',', $units);

            $lastRow = $event->sheet->getHighestRow();

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
