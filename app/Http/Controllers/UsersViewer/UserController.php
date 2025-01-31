<?php 

namespace App\Http\Controllers\UsersViewer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\CSVReader;

class UserController extends Controller
{
    protected $csvReader;

    public function __construct()
    {
        $this->csvReader = new CSVReader();
    }

    public function index(Request $request) {
        $search = $request->search ?? '';
        $dateFrom = $request->date_from ? Carbon::parse($request->date_from)->startOfDay() : null;
        $dateTo = $request->date_to ? Carbon::parse($request->date_to)->endOfDay() : null;
        $status = $request->status;
        
        $query = DB::table('_user')->where('deleted', 0);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%$search%")
                  ->orWhere('phone_number', 'LIKE', "%$search%");
            });
        }

        // Apply date filters
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }

        // Get all users matching the current query
        $users = $query->orderBy('created_at', 'DESC');
        
        // Apply status filter if selected
        if ($status) {
            // Get all statuses from CSV
            $csvStatuses = $this->csvReader->readStatusesFromCsv();
            
            // Filter users based on status
            $filteredUserIds = array_keys(array_filter($csvStatuses, function($userStatus) use ($status) {
                return $userStatus === $status;
            }));
            
            $users->whereIn('id', $filteredUserIds);
        }

        // Get paginated results
        $users = $users->paginate(20);
        
        // Get total count for the current filter
        $totalFilteredCount = $users->total();
            
        return view('users_viewer.welcome', compact(
            'users',
            'search',
            'dateFrom',
            'dateTo',
            'status',
            'totalFilteredCount'
        ));
    }


    
    public function checkNewUsers(Request $request)
    {
        // Get the last known "created_at" timestamp from the request
        $users = DB::table('_user');
        $lastUser = $users->where('deleted', 0)->orderBy('created_at', 'DESC')->first();
        // Query for new users created after the given timestamp
        $lastCreatedAt = $lastUser->created_at ?? now()->subMinutes(60);
        $newUsers = $users->where('deleted', 0)->where('created_at', '>', $lastCreatedAt)->orderBy('created_at', 'desc')->get();

        return response()->json([
            'newUsers' => $newUsers
        ]);
    }
}
