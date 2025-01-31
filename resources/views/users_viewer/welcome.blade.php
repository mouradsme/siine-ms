@extends('users_viewer.layouts.app')
@php 
    $CSVReader = new App\Helpers\CSVReader();
    $statuses = $CSVReader->readStatusesFromCsv();
@endphp
@section('content')
    
    <div class="container mx-auto p-4">
    
           

<!-- component -->
<div class="max-w-[1120px] mx-auto">
    <h1 class="text-2xl font-bold mb-4">Micro-service: User Viewer</h1>


   <div class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
       <div class="p-5 z-50 mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border sticky top-0">

        @include('users_viewer.partials.searchbar')
           <div class="flex items-center justify-between ">

            <div class="flex justify-between mb-1">
                {{ $users->links() }}
            </div>
           <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
            @if (isset($search) && strlen($search) > 0 && count($users) > 0) 
                @include('users_viewer.partials.message', array('message' => 'Found ' . count($users) . ' record(s)'))

            @endif
           </div>
           </div>
       
       </div>
       <div class="p-0 overflow-scroll">
           <table class="w-full mt-4 text-left table-auto min-w-max">
           <thead>
               <tr>
               <th
                   class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                   <p
                   class="flex items-center justify-between gap-2 font-sans text-sm font-normal leading-none text-slate-500">
                   User
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                       stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                       <path stroke-linecap="round" stroke-linejoin="round"
                       d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                   </svg>
                   </p>
               </th>
               <th
                   class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                   <p
                   class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                   Status
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                       stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                       <path stroke-linecap="round" stroke-linejoin="round"
                       d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                   </svg>
                   </p>
               </th>
               <th
                   class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                   <p
                   class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                   Created At
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                       stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                       <path stroke-linecap="round" stroke-linejoin="round"
                       d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                   </svg>
                   </p>
               </th>
               <th
                   class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                   <p
                   class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                   </p>
               </th>
               </tr>
           </thead>
           <tbody>
            
            @forelse ($users as $user)

                @include('users_viewer.partials.user-row', array(
                    'user' => $user, 
                    'user_status' => $statuses[$user->id]?? 'N/A',
                    'CSVReader' => $CSVReader,
                    'statuses' => $statuses))
            @empty
                
                @include('users_viewer.partials.message', array('message' => 'No records found!'))
            @endforelse
               
           </tbody>
           </table>
       </div>
       
       </div>
       

</div>

        
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(() => {
                fetch('{{ secure_url(route('users_viewer.check-new')) }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.newUsers.length > 0) {
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));    
            }, 60000);
        });
        function updateStatus(userId) {
            const status = document.getElementById(`status-${userId}`).value;
    
            if (!status) {
                alert('Please select a status.');
                return;
            }
    
            fetch("{{ secure_url(route('users_viewer.updateStatus')) }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({
        user_id: userId,
        status: status,
    }),
})
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload()
                } else {
                    alert('Failed to update status.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

    </script>



@endsection