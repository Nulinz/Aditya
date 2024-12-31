<?php

namespace App\Imports;

use App\Models\AssetCode;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AssetImport implements ToModel, WithHeadingRow
{
    /**
     * Holds the ID of the currently authenticated user.
     */
    protected $createdBy;

    /**
     * Constructor to set the createdBy field.
     */
    public function __construct()
    {
        $this->createdBy = Auth::id(); // Get the current authenticated user's ID
    }

    /**
     * Process each row during the import.
     *
     * @param array $row
     * @return AssetCode|null
     */
    public function model(array $row)
    {
        // Handle the asset date
        $asset_date = isset($row['asset_date']) && !empty($row['asset_date'])
        ? Carbon::createFromFormat('d-m-Y', $row['asset_date'])->format('Y-m-d')
        : Carbon::now()->format('Y-m-d'); // Default to today's date


        // Get the project title
        $projectTitle = $row['project'] ?? null;

        if (!$projectTitle) {
            return null; // Skip row if project title is missing
        }

        // Check if the project exists
        $project = Project::where('pro_title', $projectTitle)->first();

        if (!$project) {
            return null; // Skip row if the project doesn't exist
        }

        // Retrieve other values
        $asset_code = $row['asset_code'] ?? null;
        $description = $row['description'] ?? '';

        // Return a new AssetCode instance
        return new AssetCode([
            'pro_id' => $project->id,
            'asset_code' => $asset_code,
            'des' => $description,
            'asset_date' => $asset_date,
            'created_by' => $this->createdBy,
        ]);
    }
}
