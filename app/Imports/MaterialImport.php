<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class MaterialImport implements ToModel, WithHeadingRow

{
    /**
    * @param Collection $collection
    */
    protected $createdBy;

    public function __construct()
    {
        $this->createdBy = Auth::id(); // Get the current authenticated user's ID
    }

    /**
     * Handle each row of the import
     *
     * @param array $row
     * @return Material|null
     */
    public function model(array $row)
    {
        $projectTitle = $row['project']; // Handle missing 'project' key

        if (!$projectTitle) {
            return null; // Skip row if project title is missing
        }

        // Check if the project title exists in the database
        $project = Project::where('pro_title', $projectTitle)->first(); // Search by project title

        if (!$project) {
            // Skip the row if the project doesn't exist
            return null;
        }

        // Retrieve values from the row and handle defaults
        $item_code = $row['item_code'] ?? null;
        $description = $row['description'] ?? '';


        // Create or update the vendor record
        return new Material([
            'pro_id' => $project->id, // Use the validated project ID
            'item_code' => $item_code,
            'des' => $description,
            'created_by' => $this->createdBy,
        ]);
    }
}


