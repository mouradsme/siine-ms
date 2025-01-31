<?php 

namespace App\Http\Controllers\UsersViewer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserStatusController extends Controller
{
    // Path to the CSV file
    protected $csvFilePath = 'user_statuses.csv';

    // Update/Create user status
    public function updateStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'status' => 'required',
        ]);

        // Get user details

        // Update the CSV file
        $this->writeStatusToCsv($request->user_id, $request->status);

        return response()->json(['success' => true, 'message' => 'User status updated successfully.']);
    }

    // Read statuses from the CSV file
    private function readStatusesFromCsv()
    {
        $statuses = [];

        if (Storage::exists($this->csvFilePath)) {
            $file = fopen(Storage::path($this->csvFilePath), 'r');

            while (($row = fgetcsv($file)) !== false) {
                $statuses[$row[0]] = $row[1]; // Key: user ID, Value: status
            }

            fclose($file);
        }

        return $statuses;
    }

    // Write status to the CSV file
    private function writeStatusToCsv($userId, $status)
    {
        $statuses = $this->readStatusesFromCsv();

        // Update the status in the array
        $statuses[$userId] = $status;

        // Write all statuses back to the CSV file
        $file = fopen(Storage::path($this->csvFilePath), 'w');

        foreach ($statuses as $id => $status) {
            fputcsv($file, [$id, $status]);
        }

        fclose($file);
    }
}
