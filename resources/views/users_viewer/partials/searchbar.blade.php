<!-- component -->
<div style="max-width:900px;" class="mb-3">
    <form class="flex flex-col gap-3" method="GET" action="{{ route('users_viewer.index') }}">   
        <div class="flex items-center gap-3">
            <div class="relative flex-1">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by name or phone number...">
            </div>
            <div class="w-48">
                @php
                    $CSVReader = new App\Helpers\CSVReader();
                    $statusOptions = $CSVReader->statuses();
                @endphp
                <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">All Statuses</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-sm font-medium text-gray-700">Quick Filters:</span>
                <button type="button" id="filter-today" onclick="setDateRange('today')" class="quick-filter-btn text-sm px-3 py-1 rounded-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">Today</button>
                <button type="button" id="filter-yesterday" onclick="setDateRange('yesterday')" class="quick-filter-btn text-sm px-3 py-1 rounded-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">Yesterday</button>
                <button type="button" id="filter-week" onclick="setDateRange('week')" class="quick-filter-btn text-sm px-3 py-1 rounded-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">Last 7 days</button>
                <button type="button" id="filter-month" onclick="setDateRange('month')" class="quick-filter-btn text-sm px-3 py-1 rounded-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 transition-colors duration-200">Last 30 days</button>
            </div>
            
            <div class="flex items-center gap-3 flex-wrap">
                <div class="flex items-center gap-2">
                    <label for="date_from" class="text-sm font-medium text-gray-700">From:</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="bg-white border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 p-2 rounded-md" onchange="handleDateChange()">
                </div>
                <div class="flex items-center gap-2">
                    <label for="date_to" class="text-sm font-medium text-gray-700">To:</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="bg-white border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 p-2 rounded-md" onchange="handleDateChange()">
                </div>
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <a href="{{ route('users_viewer.export', ['format' => 'csv'] + request()->except(['page'])) }}" 
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
                <a href="{{ route('users_viewer.export', ['format' => 'xls'] + request()->except(['page'])) }}" 
                   class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:ring-4 focus:ring-green-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export XLS
                </a>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-blue-700 rounded-md border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg aria-hidden="true" class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Apply Filters
            </button>
            <a href="{{ route('users_viewer.index') }}" class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white rounded-md border border-gray-300 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-100">
                Clear All
            </a>
        </div>
    </form>
</div>

<style>
.quick-filter-btn.active {
    @apply border-blue-500 bg-blue-50 text-blue-700 font-medium;
}
</style>

<script>
function setDateRange(range) {
    const today = new Date();
    let fromDate = new Date();
    let toDate = new Date();

    // Remove active class from all buttons
    document.querySelectorAll('.quick-filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Add active class to clicked button
    document.getElementById(`filter-${range}`).classList.add('active');

    switch(range) {
        case 'today':
            fromDate = today;
            toDate = today;
            break;
        case 'yesterday':
            fromDate.setDate(today.getDate() - 1);
            toDate.setDate(today.getDate() - 1);
            break;
        case 'week':
            fromDate.setDate(today.getDate() - 7);
            toDate = today;
            break;
        case 'month':
            fromDate.setDate(today.getDate() - 30);
            toDate = today;
            break;
    }

    document.getElementById('date_from').value = formatDate(fromDate);
    document.getElementById('date_to').value = formatDate(toDate);
}

function formatDate(date) {
    return date.toISOString().split('T')[0];
}

function handleDateChange() {
    // Remove active class from all quick filter buttons when dates are manually changed
    document.querySelectorAll('.quick-filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
}

// Check if we should highlight a quick filter button based on current date values
document.addEventListener('DOMContentLoaded', function() {
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = document.getElementById('date_to').value;
    
    if (!dateFrom || !dateTo) return;

    const today = new Date();
    const fromDate = new Date(dateFrom);
    const toDate = new Date(dateTo);
    
    // Format dates to compare just the date part
    const todayStr = formatDate(today);
    const fromStr = formatDate(fromDate);
    const toStr = formatDate(toDate);
    
    if (fromStr === todayStr && toStr === todayStr) {
        document.getElementById('filter-today').classList.add('active');
    } else if (fromStr === formatDate(new Date(today.setDate(today.getDate() - 1))) && 
               toStr === fromStr) {
        document.getElementById('filter-yesterday').classList.add('active');
    } else if (fromStr === formatDate(new Date(today.setDate(today.getDate() - 6))) && 
               toStr === formatDate(new Date())) {
        document.getElementById('filter-week').classList.add('active');
    } else if (fromStr === formatDate(new Date(today.setDate(today.getDate() - 23))) && 
               toStr === formatDate(new Date())) {
        document.getElementById('filter-month').classList.add('active');
    }
});
</script>