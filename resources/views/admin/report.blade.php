@extends('layouts.admin')
@section('title', 'Institutional Analytics - SCMS')

@section('content')

@php
    // --- MENGAMBIL DATA DINAMIS BERDASARKAN DROPDOWN ---
    $days = request('range', 30); // Default 30 hari
    $startDate = \Carbon\Carbon::now()->subDays($days);

    // 1. Total Complaints & Resolution Rate
    $totalComplaints = \App\Models\Complaint::where('created_at', '>=', $startDate)->count();
    $resolvedCount = \App\Models\Complaint::whereIn('status', ['Resolved', 'Closed'])->where('created_at', '>=', $startDate)->count();
    $resolutionRate = $totalComplaints > 0 ? round(($resolvedCount / $totalComplaints) * 100, 1) : 0;
    
    // 2. Escalated Cases
    $escalatedCases = \App\Models\Complaint::whereIn('status', ['Pending', 'Reviewing'])
        ->where('priority', 'Tinggi')
        ->where('created_at', '>=', $startDate)
        ->count();

    // 3. Average Resolution Time
    $avgResolutionRaw = \App\Models\Complaint::whereIn('status', ['Resolved', 'Closed'])
        ->where('created_at', '>=', $startDate)
        ->select(\Illuminate\Support\Facades\DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours'))
        ->first()->avg_hours ?? 0;
    
    $avgDays = floor($avgResolutionRaw / 24);
    $avgHours = round($avgResolutionRaw % 24);
    $avgDisplay = $avgDays > 0 ? "{$avgDays}d {$avgHours}h" : "{$avgHours}h";

    // 4. Kinerja Departemen
    $departmentStats = \Illuminate\Support\Facades\DB::table('complaints')
        ->join('categories', 'complaints.category_id', '=', 'categories.id')
        ->where('complaints.created_at', '>=', $startDate)
        ->select(
            'categories.department',
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN complaints.status IN ("Pending", "Reviewing", "In Progress") THEN 1 ELSE 0 END) as open_tickets'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN complaints.status IN ("Resolved", "Closed") THEN 1 ELSE 0 END) as closed_tickets'),
            \Illuminate\Support\Facades\DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, complaints.created_at, complaints.updated_at)), 1) as avg_days'),
            \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(DAY, complaints.created_at, complaints.updated_at) > 7 THEN 1 ELSE 0 END) as sla_breach')
        )
        ->groupBy('categories.department')
        ->get();

    if ($departmentStats->isEmpty()) {
        $departmentStats = collect([
            (object)['department' => 'Facilities Management', 'open_tickets' => 0, 'closed_tickets' => 0, 'avg_days' => 0, 'sla_breach' => 0],
        ]);
    }

    $departmentStats = $departmentStats->map(function($stat) {
        $stat->total = $stat->open_tickets + $stat->closed_tickets;
        $stat->resolution_rate = $stat->total > 0 ? round(($stat->closed_tickets / $stat->total) * 100) : 0;
        $stat->status = $stat->resolution_rate >= 75 ? 'Optimal' : 'Lagging';
        $stat->breach_rate = $stat->closed_tickets > 0 ? round(($stat->sla_breach / $stat->closed_tickets) * 100) : 0;
        return $stat;
    });

    $worstDept = $departmentStats->sortByDesc('avg_days')->first()->department ?? 'Facilities Management';

    // 5. Data SLA Performance
    $withinSLA = \App\Models\Complaint::whereIn('status', ['Resolved', 'Closed'])
        ->where('created_at', '>=', $startDate)
        ->whereRaw('TIMESTAMPDIFF(DAY, created_at, updated_at) <= 7')
        ->count();
    $slaRate = $resolvedCount > 0 ? round(($withinSLA / $resolvedCount) * 100) : 0;

    $fastResponseCount = \Illuminate\Support\Facades\DB::table('complaints')
        ->join('complaint_responses', 'complaints.id', '=', 'complaint_responses.complaint_id')
        ->where('complaints.created_at', '>=', $startDate)
        ->whereRaw('TIMESTAMPDIFF(HOUR, complaints.created_at, complaint_responses.created_at) <= 24')
        ->select('complaints.id')->distinct()->count();
    $initialResponseRate = $totalComplaints > 0 ? round(($fastResponseCount / $totalComplaints) * 100) : 0;

    if (\Illuminate\Support\Facades\Schema::hasColumn('complaints', 'rating')) {
        $csatScore = \App\Models\Complaint::whereNotNull('rating')->where('created_at', '>=', $startDate)->avg('rating') ?? 0;
    } else {
        $csatScore = 0; 
    }
    
    $csatScore = round($csatScore, 1);
    $csatPercent = ($csatScore / 5) * 100;

    // 6. PERBAIKAN GRAFIK VOLUME: Dinamis Sesuai Dropdown
    $monthlyLabels = [];
    $monthlyData = [];
    $chartStep = max(1, floor($days / 6)); // Bagi grafik menjadi 6 kolom

    for ($i = 5; $i >= 0; $i--) {
        $startRange = \Carbon\Carbon::now()->subDays(($i + 1) * $chartStep);
        $endRange = \Carbon\Carbon::now()->subDays($i * $chartStep);
        
        // Jika periode <= 30 hari tampilkan tanggal, jika panjang tampilkan Bulan
        $monthlyLabels[] = $endRange->format($days <= 30 ? 'd M' : 'M Y');
        $monthlyData[] = \App\Models\Complaint::whereBetween('created_at', [$startRange, $endRange])->count();
    }

    // 7. Grafik Donat Kategori
    $issuesByCategory = \Illuminate\Support\Facades\DB::table('complaints')
        ->join('categories', 'complaints.category_id', '=', 'categories.id')
        ->where('complaints.created_at', '>=', $startDate)
        ->select('categories.name as category_name', 'categories.department as department', \Illuminate\Support\Facades\DB::raw('count(complaints.id) as total'))
        ->groupBy('categories.id', 'categories.name', 'categories.department')
        ->orderByDesc('total')
        ->get();
    
    if ($issuesByCategory->isEmpty()) {
        $issuesByCategory = collect([
            (object)['category_name' => 'Data Kosong', 'department' => 'None', 'total' => 0],
        ]);
    }

    $catColors = ['#004ac6', '#2563eb', '#b4c5ff', '#16a34a', '#f59e0b', '#d97706', '#e1e2ed'];
    $catLabels = []; $catData = []; $i = 0;
    foreach($issuesByCategory as $issue) {
        $catLabels[] = $issue->category_name;
        $catData[] = $issue->total;
        $issue->color = $catColors[$i % count($catColors)];
        $i++;
    }
@endphp

<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto">
    
    <div class="w-full mb-2">
        <div class="border-b border-[#c3c6d7] flex gap-6">
            <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'border-[#004ac6] text-[#004ac6]' : 'border-transparent text-[#737686] hover:text-[#191b23] hover:border-[#c3c6d7]' }} border-b-2 pb-3 font-['Manrope-SemiBold',_sans-serif] text-[14px] font-semibold transition-colors">
                Institutional Analytics
            </a>
            <a href="{{ route('admin.performance') }}" class="{{ request()->routeIs('admin.performance') ? 'border-[#004ac6] text-[#004ac6]' : 'border-transparent text-[#737686] hover:text-[#191b23] hover:border-[#c3c6d7]' }} border-b-2 pb-3 font-['Manrope-SemiBold',_sans-serif] text-[14px] font-semibold transition-colors">
                Service Evaluation
            </a>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between w-full gap-4">
        
        <div class="flex flex-col gap-1 w-full lg:w-auto">
            <h1 class="text-[#191b23] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">
                Institutional Analytics
            </h1>
            <p class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-base leading-6 font-normal">
                Comprehensive overview of complaint resolution and service metrics.
            </p>
        </div>
        
        <div class="flex flex-row flex-wrap gap-3 items-center justify-start lg:justify-end shrink-0 print:hidden w-full lg:w-auto">
            
            <form method="GET" action="{{ route('admin.reports') }}" class="bg-[#ffffff] rounded-lg border-solid border-[#c3c6d7] border py-2 px-4 flex flex-row gap-2 items-center justify-start shadow-[0_4px_20px_rgba(0,0,0,0.04)] relative focus-within:border-[#004ac6] transition cursor-pointer">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M5.25 7.875H6V6.375H6.75C6.9625 6.375 7.14062 6.30313 7.28438 6.15938C7.42813 6.01562 7.5 5.8375 7.5 5.625V4.875C7.5 4.6625 7.42813 4.48438 7.28438 4.34062C7.14062 4.19687 6.9625 4.125 6.75 4.125H5.25V7.875ZM6 5.625V4.875H6.75V5.625H6ZM8.25 7.875H9.75C9.9625 7.875 10.1406 7.80313 10.2844 7.65938C10.4281 7.51562 10.5 7.3375 10.5 7.125V4.875C10.5 4.6625 10.4281 4.48438 10.2844 4.34062C10.1406 4.19687 9.9625 4.125 9.75 4.125H8.25V7.875ZM9 7.125V4.875H9.75V7.125H9ZM11.25 7.875H12V6.375H12.75V5.625H12V4.875H12.75V4.125H11.25V7.875ZM4.5 12C4.0875 12 3.73438 11.8531 3.44062 11.5594C3.14687 11.2656 3 10.9125 3 10.5V1.5C3 1.0875 3.14687 0.734375 3.44062 0.440625C3.73438 0.146875 4.0875 0 4.5 0H13.5C13.9125 0 14.2656 0.146875 14.5594 0.440625C14.8531 0.734375 15 1.0875 15 1.5V10.5C15 10.9125 14.8531 11.2656 14.5594 11.5594C14.2656 11.8531 13.9125 12 13.5 12H4.5ZM4.5 10.5H13.5V1.5H4.5V10.5ZM1.5 15C1.0875 15 0.734375 14.8531 0.440625 14.5594C0.146875 14.2656 0 13.9125 0 13.5V3H1.5V13.5H12V15H1.5ZM4.5 1.5V10.5V1.5Z" fill="#191B23"/></svg>
                <select name="range" onchange="this.form.submit()" class="bg-transparent text-[#191b23] font-semibold text-[13px] outline-none cursor-pointer appearance-none pr-5 z-10 w-[110px]">
                    <option value="30" {{ request('range', 30) == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ request('range') == 90 ? 'selected' : '' }}>Last 3 Months</option>
                    <option value="180" {{ request('range') == 180 ? 'selected' : '' }}>Last 6 Months</option>
                    <option value="365" {{ request('range') == 365 ? 'selected' : '' }}>This Year</option>
                </select>
                <svg class="absolute right-4 pointer-events-none" width="10" height="6" viewBox="0 0 10 7" fill="none"><path d="M5 6.16667L0 1.16667L1.16667 0L5 3.83333L8.83333 0L10 1.16667L5 6.16667Z" fill="#191B23"/></svg>
            </form>

            <button onclick="window.print()" class="bg-[#2563eb] rounded-lg py-2 px-4 flex flex-row gap-2 items-center justify-start text-white hover:bg-blue-700 transition shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.66667 10L2.5 5.83333L3.66667 4.625L5.83333 6.79167V0H7.5V6.79167L9.66667 4.625L10.8333 5.83333L6.66667 10ZM1.66667 13.3333C1.20833 13.3333 0.815972 13.1701 0.489583 12.8438C0.163194 12.5174 0 12.125 0 11.6667V9.16667H1.66667V11.6667H11.6667V9.16667H13.3333V11.6667C13.3333 12.125 13.1701 12.5174 12.8438 12.8438C12.5174 13.1701 12.125 13.3333 11.6667 13.3333H1.66667Z" fill="white"/></svg>
                <span class="font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Export PDF</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Total Complaints</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ number_format($totalComplaints) }}</span>
                </div>
                <div class="w-10 h-10 bg-[#e1e2ed] rounded-lg flex items-center justify-center text-[#004ac6]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </div>
            </div>
            <div class="text-[#737686] text-xs font-medium mt-4">In selected range</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Resolution Rate</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $resolutionRate }}%</span>
                </div>
                <div class="w-10 h-10 bg-[#dcfce7] rounded-lg flex items-center justify-center text-[#16a34a]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
            </div>
            <div class="text-[#737686] text-xs font-medium mt-4">Target: >85%</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Escalated Cases</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $escalatedCases }}</span>
                </div>
                <div class="w-10 h-10 bg-[#ffedd5] rounded-lg flex items-center justify-center text-[#d97706]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </div>
            </div>
            <div class="text-[#737686] text-xs font-medium mt-4">High priority open</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Avg. Response</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $avgDisplay }}</span>
                </div>
                <div class="w-10 h-10 bg-[#fee2e2] rounded-lg flex items-center justify-center text-[#dc2626]">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
            </div>
            <div class="text-[#737686] text-xs font-medium mt-4">Across all departments</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        <div class="bg-[#ffffff] rounded-xl p-6 flex flex-col relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-8 w-full min-h-[464px]">
            <div class="flex flex-row items-center justify-between w-full mb-6">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">Complaint Volume (Based on Selection)</div>
            </div>
            <div class="flex-1 w-full h-full relative min-h-[300px]">
                <canvas id="monthlyVolumeChart"></canvas>
            </div>
        </div>

        <div class="bg-[#ffffff] rounded-xl pb-6 flex flex-col relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-4 w-full min-h-[464px]">
            <div class="p-6 flex flex-row items-center justify-between w-full">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">Issues by Category</div>
            </div>
            
            <div class="px-6 pb-2 w-full h-[200px] relative">
                <canvas id="categoryChart"></canvas>
            </div>
            
            <div class="px-6 grid grid-cols-2 gap-y-4 gap-x-2 mt-auto w-full">
                @foreach($issuesByCategory->take(4) as $issue)
                <div class="flex items-center gap-2 w-full">
                    <div class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $issue->color }};"></div>
                    <div class="flex flex-col flex-1 overflow-hidden">
                        <span class="text-[#505f76] text-sm leading-[18px] truncate block" title="{{ $issue->category_name }}">{{ $issue->category_name }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mb-8">
        <div class="bg-[#ffffff] rounded-xl p-6 flex flex-col gap-6 relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-4 w-full min-h-[422px]">
            <div class="flex flex-row items-center justify-between w-full mb-2">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">SLA Performance</div>
            </div>
            
            <div class="flex flex-col gap-6 w-full relative flex-1">
                <div class="flex flex-col gap-2 w-full relative">
                    <div class="flex flex-row items-center justify-between w-full relative">
                        <div class="text-[#191b23] text-left font-['Manrope-Medium',_sans-serif] text-sm leading-5 font-medium">Initial Response (&lt; 24h)</div>
                        <div class="text-[#004ac6] text-left font-['Manrope-Bold',_sans-serif] text-sm leading-5 font-bold">{{ $initialResponseRate }}%</div>
                    </div>
                    <div class="bg-[#ededf9] rounded-full w-full h-2 relative overflow-hidden">
                        <div class="bg-[#004ac6] h-full absolute left-0 top-0 bottom-0 rounded-full" style="width: {{ $initialResponseRate }}%;"></div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full relative">
                    <div class="flex flex-row items-center justify-between w-full relative">
                        <div class="text-[#191b23] text-left font-['Manrope-Medium',_sans-serif] text-sm leading-5 font-medium">Resolution Time (&lt; 7 Days)</div>
                        <div class="text-[#16a34a] text-left font-['Manrope-Bold',_sans-serif] text-sm leading-5 font-bold">{{ $slaRate }}%</div>
                    </div>
                    <div class="bg-[#ededf9] rounded-full w-full h-2 relative overflow-hidden">
                        <div class="bg-[#16a34a] h-full absolute left-0 top-0 bottom-0 rounded-full" style="width: {{ $slaRate }}%;"></div>
                    </div>
                </div>

                <div class="flex flex-col gap-2 w-full relative">
                    <div class="flex flex-row items-center justify-between w-full relative">
                        <div class="text-[#191b23] text-left font-['Manrope-Medium',_sans-serif] text-sm leading-5 font-medium">Student Satisfaction Score</div>
                        <div class="text-[#d97706] text-left font-['Manrope-Bold',_sans-serif] text-sm leading-5 font-bold">{{ $csatScore }} / 5</div>
                    </div>
                    <div class="bg-[#ededf9] rounded-full w-full h-2 relative overflow-hidden">
                        <div class="bg-[#d97706] h-full absolute left-0 top-0 bottom-0 rounded-full" style="width: {{ $csatPercent }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#ffffff] rounded-xl flex flex-col relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-8 w-full min-h-[422px] overflow-hidden">
            <div class="border-solid border-[#e1e2ed] border-b p-6 flex flex-row items-center justify-between w-full">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">Department Performance Comparison</div>
            </div>
            
            <div class="flex-1 w-full overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                    <thead class="bg-[#f1f5f9] border-b border-[#e1e2ed] text-[#505f76] text-[13px] font-semibold tracking-[0.65px]">
                        <tr>
                            <th class="py-4 px-6 font-semibold">Department</th>
                            <th class="py-4 px-6 text-center font-semibold">Open</th>
                            <th class="py-4 px-6 text-center font-semibold">Resolved</th>
                            <th class="py-4 px-6 font-semibold min-w-[150px]">Avg. Resolution</th>
                            <th class="py-4 px-6 font-semibold min-w-[120px]">SLA Breach</th>
                        </tr>
                    </thead>
                    <tbody class="text-[#191b23] text-sm">
                        @foreach($departmentStats as $stat)
                        <tr class="border-b border-[#e1e2ed] hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 font-medium text-[#191b23]">{{ $stat->department }}</td>
                            <td class="py-4 px-6 text-center">{{ $stat->open_tickets }}</td>
                            <td class="py-4 px-6 text-center">{{ $stat->closed_tickets }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3 w-full">
                                    <span class="w-[60px] font-medium">{{ $stat->avg_days }} Days</span>
                                    <div class="bg-[#e1e2ed] rounded-full h-1.5 flex-1 relative overflow-hidden min-w-[80px]">
                                        <div class="bg-[#004ac6] absolute left-0 top-0 bottom-0 rounded-full" style="width: {{ $stat->resolution_rate }}%;"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($stat->breach_rate > 10)
                                    <div class="bg-[rgba(186,26,26,0.10)] rounded inline-flex px-2 py-1 items-center justify-center">
                                        <span class="text-[#ba1a1a] font-semibold text-xs leading-4">High ({{ $stat->breach_rate }}%)</span>
                                    </div>
                                @elseif($stat->breach_rate > 0)
                                    <div class="bg-[rgba(217,119,6,0.10)] rounded inline-flex px-2 py-1 items-center justify-center">
                                        <span class="text-[#d97706] font-semibold text-xs leading-4">Low ({{ $stat->breach_rate }}%)</span>
                                    </div>
                                @else
                                    <div class="bg-[rgba(22,163,74,0.10)] rounded inline-flex px-2 py-1 items-center justify-center">
                                        <span class="text-[#16a34a] font-semibold text-xs leading-4">None (0%)</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. Dynamic Bar Chart
        const ctxBar = document.getElementById('monthlyVolumeChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [{
                    label: 'Total Tickets',
                    data: {!! json_encode($monthlyData) !!},
                    backgroundColor: '#d0e1fb',
                    hoverBackgroundColor: '#004ac6',
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { stepSize: 1, color: '#737686', font: { family: 'Manrope' } },
                        grid: { color: 'rgba(195, 198, 215, 0.2)', borderDash: [5, 5] }
                    },
                    x: { 
                        ticks: { color: '#737686', font: { family: 'Manrope', weight: 'bold' } },
                        grid: { display: false } 
                    }
                }
            }
        });

        // 2. Category Doughnut Chart
        const ctxDoughnut = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($catLabels) !!},
                datasets: [{
                    data: {!! json_encode($catData) !!},
                    backgroundColor: {!! json_encode(array_column($issuesByCategory->toArray(), 'color')) !!},
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: { 
                    legend: { display: false },
                }
            }
        });
    });
</script>
@endsection