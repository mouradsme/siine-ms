<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CSVReader {
    protected $csvFilePath = 'user_statuses.csv';

    public function statuses() {
        return array(
            "pending" => "Pending",
            "called" => "Called",
            "confirmed" => "Confirmed",
            "cancelled" => "Cancelled",
            "fake" => "Fake"
        );
    }
    public function getUserStatusById($id) {
        $statuses = $this->readStatusesFromCsv();
        $status = $statuses[$id] ?? 'N/A';
        return $status;
    }
    public function readStatusesFromCsv()
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

    

}