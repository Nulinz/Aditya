<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\ProjectSale;
use App\Models\Unit;
use App\Models\Boq;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProcessZeroImport implements ToModel, WithHeadingRow
{
    protected $proId;

    /**
     * Constructor to receive the project ID.
     *
     * @param int $proId
     */
    public function __construct($proId)
    {
        $this->proId = $proId;
    }

    /**
     * Handle each row of the import.
     *
     * @param array $row
     * @return ProjectSale|null
     */
    public function model(array $row)
    {
        $createdBy = Auth::id();

        // Convert date to 'Y-m-d' format
        $date = isset($row['date']) && !empty($row['date'])
            ? Carbon::createFromFormat('d-m-Y', $row['date'])->format('Y-m-d')
            : null;

        if (!$row['unit'] || !$row['boq_code']) {
            return null;
        }

        $unit = $row['unit'] ?? null;
        $boqCode = $row['boq_code'] ?? null;
        $description = $row['description'] ?? '';
        $descriptionOfWork = $row['description_of_work'] ?? '';
        $quantity = $row['quantity'] ?? 0;
        $boqRate = $row['boq_rate'] ?? 0;
        $zeroRate = $row['zero_rate'] ?? 0;
        $saleAmount = $row['sale_amount'] ?? 0;
        $zeroAmount = $row['zero_amount'] ?? 0;
        $remarks = $row['remarks'] ?? '';

        $unitRecord = Unit::firstOrCreate(
            ['unit' => $unit],
            ['status' => 1, 'created_by' => $createdBy]
        );

        $boqRecord = Boq::firstOrCreate(
            ['code' => $boqCode],
            [
                'pro_id' => $this->proId,
                'description' => $description,
                'des' => $descriptionOfWork,
                'unit' => $unitRecord->id,
                'qty' => $quantity,
                'boq_rate' => $boqRate,
                'zero_rate' => $zeroRate,
                'boq_amount' => $saleAmount,
                'zero_amount' => $zeroAmount,
                'remarks' => $remarks,
                'status' => 1,
                'created_by' => $createdBy,
            ]
        );

        return new ProjectSale([
            'pro_id' => $this->proId,
            'pro_date' => $date,
            'code' => $boqRecord->id,
            'des' => $description,
            'work' => $descriptionOfWork,
            'unit' => $unitRecord->id,
            'qty' => $quantity,
            'pro_zero_rate' => $zeroRate,
            'pro_sale_rate' => $boqRate,
            'pro_sale_amt' => $saleAmount,
            'pro_zero_amt' => $zeroAmount,
            'remarks' => $remarks,
            'status' => 1,
            'created_by' => $createdBy,
        ]);
    }
}
