<?php
namespace App\Imports;

use App\Models\Vendor;
use App\Models\Project; // Assuming you have a Project model
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class VendorImport implements ToModel, WithHeadingRow
{
    protected $createdBy;

    public function __construct()
    {
        $this->createdBy = Auth::id(); // Get the current authenticated user's ID
    }

    /**
     * Handle each row of the import
     *
     * @param array $row
     * @return Vendor|null
     */
    public function model(array $row)
    {
        // Retrieve project title from the row
        $projectTitle = $row['project']; // Assuming the column name is 'project'

        // Check if the project title exists in the database
        $project = Project::where('pro_title', $projectTitle)->first(); // Search by project title

        if (!$project) {
            // Skip the row if the project doesn't exist
            return null;
        }

        // Retrieve values from the row and handle defaults
        $type = $row['type'] ?? null;
        $date = isset($row['date']) ? Carbon::createFromFormat('d-m-Y', $row['date'])->format('Y-m-d') : now();
        $vendorCode = $row['vendor_code'] ?? null;
        $vendorName = $row['vendor_name'] ?? null;
        $address = $row['address'] ?? '';
        $gst = $row['gst'] ?? '';
        $pan = $row['pan'] ?? '';
        $aadhar = $row['aadhar'] ?? '';
        $bankName = $row['bank_name'] ?? '';
        $accountHolder = $row['ac_holder'] ?? '';
        $accountNo = $row['bank_ac_no'] ?? '';
        $ifscCode = $row['ifsc'] ?? '';
        $branch = $row['branch'] ?? '';
        $mobile = $row['mobile'] ?? '';
        $email = $row['mail'] ?? '';
        $trade = $row['trade'] ?? '';

        if (!$vendorCode || !$vendorName) {
            return null; // Skip if essential fields are missing
        }

        // Create or update the vendor record
        return new Vendor([
            'pro_id' => $project->id, // Use the validated project ID
            'type' => $type,
            'ven_date' => $date,
            'v_code' => $vendorCode,
            'v_name' => $vendorName,
            'address' => $address,
            'gst' => $gst,
            'pan' => $pan,
            'aadhar' => $aadhar,
            'bank' => $bankName,
            'ac_name' => $accountHolder,
            'ac_no' => $accountNo,
            'ifsc' => $ifscCode,
            'branch' => $branch,
            'mob' => $mobile,
            'mail' => $email,
            'trade' => $trade,
            'created_by' => $this->createdBy,
        ]);
    }
}


