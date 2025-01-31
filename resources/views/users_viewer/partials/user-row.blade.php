<tr>
    <td class="p-4 border-b border-slate-200">
        <div class="flex items-center gap-3">
        <img src="https://demos.creative-tim.com/test/corporate-ui-dashboard/assets/img/team-3.jpg"
            alt="{{ $user->full_name }}" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
        <div class="flex flex-col">
            <p class="text-sm font-semibold text-slate-700">
            {{ $user->full_name }}
            </p>
            <p
            class="text-sm text-slate-500">
            {{ $user->phone_number }}
            </p>
        </div>
        </div>
    </td>
    <td class="p-4 border-b border-slate-200">
        <div class="w-max">
        <div
            class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
            <span class="">{{ $user_status }}</span>
        </div>
        </div>
    </td>
    <td class="p-4 border-b border-slate-200">
        <p class="text-sm text-slate-500">
            {{ \Carbon\Carbon::parse($user->created_at)->format('m/d/Y') }}
        </p>
    </td>
    <td class="p-4 border-b border-slate-200">
        
        <select id="status-{{ $user->id }}" class="border rounded px-2 py-1">
             <option value="">Status</option>
             @foreach ($CSVReader->statuses() as $status => $v)
             <option value="{{ $status }}" {{ isset($statuses[$user->id]) && $statuses[$user->id] === $status ? 'selected' : '' }}>{{ $v }}</option>
                 
             @endforeach
        </select>
        <button onclick="updateStatus('{{ $user->id }}')" class="bg-blue-500 text-white px-4 py-1 rounded">Save</button>

    </td>
    </tr>