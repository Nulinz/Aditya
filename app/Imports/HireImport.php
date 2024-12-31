<?php

namespace App\Imports;

use App\Models\Hire;
use App\Models\Unit;
use App\Models\AssetCode;
use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HireImport implements ToModel, WithHeadingRow
{
    protected $proId;
    public $errors = []; // Store errors here

    public function __construct($proId)
    {
        $this->proId = $proId;
    }

    /**
     * Handle each row of the import
     *
     * @param array $row
     * @return Hire|null
     */
    public function model(array $row)
    {
        $createdBy = Auth::id();

        try {
            // Parse the date if provided
            $date = isset($row['date']) && Carbon::hasFormat($row['date'], 'd-m-Y')
                ? Carbon::createFromFormat('d-m-Y', $row['date'])->format('Y-m-d')
                : null;

            // Retrieve and sanitize row data
            $boqCode = $row['boq_code'] ?? null;
            $billNo = $row['bill_no'] ?? null;
            $description = $row['description'] ?? null;
            $assetDes = $row['assetdes'] ?? null;
            $contractorName = $row['contractor'] ?? null;
            $assetCode = $row['asset_code'] ?? null;
            $unit = $row['unit'] ?? null;
            $quantity = $row['qty'] ?? 0;
            $rate = $row['rate'] ?? 0;
            $amount = $row['amount'] ?? 0;
            $gst = $row['gst'] ?? 0;
            $gross = $row['gross'] ?? 0;
            $remarks = $row['remark'] ?? '';

            // Ensure unit exists or create it
            $unitRecord = Unit::firstOrCreate(
                ['unit' => $unit], // Search criteria
                [
                    'status' => 1,
                    'created_by' => $createdBy,
                ]
            );

            if (!$unitRecord) {
                $this->errors[] = "Failed to create or find unit for row: " . json_encode($row);
                return null; // Skip this row if unit creation fails
            }


            // Ensure asset code exists
            $assetCodeRecord = AssetCode::where('asset_code', $assetCode)->first();
            if (!$assetCodeRecord) {
                $this->errors[] = "Asset Code not found for row: " . json_encode($row);
                return null; // Skip this row if asset code is not found
            }

            // Ensure vendor exists
            $vendorRecord = Vendor::where('type', $contractorName)->first();
            if (!$vendorRecord) {
                $this->errors[] = "Vendor not found for row: " . json_encode($row);
                return null; // Skip this row if vendor is not found
            }

            // Create the hire record
            return new Hire([
                'pro_id' => $this->proId,
                'hire_date' => $date,
                'code' => $boqCode,
                'des' => $description,
                'type' => $assetDes,
                'bill' => $billNo,
                'con_name' => $vendorRecord->id,
                'a_code' => $assetCodeRecord->id,
                'unit' => $unitRecord->id,
                'qty' => $quantity,
                'u_rate' => $rate,
                'amount' => $amount,
                'gst' => $gst,
                'gross' => $gross,
                'remark' => $remarks,
                'status' => 1,
                'created_by' => $createdBy,
            ]);

        } catch (\Exception $e) {
            $this->errors[] = 'Error processing row: ' . $e->getMessage() . ' Row data: ' . json_encode($row);
            return null;
        }
    }

    // Function to retrieve errors
    public function getErrors()
    {
        return $this->errors;
    }
}
