<?php

namespace App\Imports;

use App\Models\Boq;
use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class BoqImport implements ToModel, WithHeadingRow
{
    protected $proId;

    public function __construct($proId)
    {
        $this->proId = $proId;
    }

    /**
     * Handle each row of the import
     *
     * @param array $row
     * @return Boq|null
     */
    public function model(array $row)
    {
        $createdBy = Auth::id();

        $unit = isset($row['unit']) ? $row['unit'] : null;
        $boqCode = isset($row['boq_code']) ? $row['boq_code'] : null;
        $description = isset($row['description']) ? $row['description'] : '';
        $descriptionOfWork = isset($row['description_of_work']) ? $row['description_of_work'] : '';
        $quantity = isset($row['quantity']) ? $row['quantity'] : 0;
        $boqRate = isset($row['boq_rate']) ? $row['boq_rate'] : 0;
        $zeroRate = isset($row['zero_rate']) ? $row['zero_rate'] : 0;
        $saleAmount = isset($row['sale_amount']) ? $row['sale_amount'] : 0;
        $zeroAmount = isset($row['zero_amount']) ? $row['zero_amount'] : 0;
        $remarks = isset($row['remarks']) ? $row['remarks'] : '';

        if (!$unit || !$boqCode) {
            return null;
        }

        $unitRecord = Unit::create([
            'unit' => $unit,
            'status' => 1,
            'created_by' => $createdBy,
        ]);

        return new Boq([
            'pro_id' => $this->proId,
            'code' => $boqCode,
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
        ]);
    }
}
