@extends('layouts.admin')
@section('title', 'Institutional Analytics - SCMS')

@section('content')

@php
    // --- MENGAMBIL DATA DINAMIS LANGSUNG DARI DATABASE ---
    $days = request('range', 30);
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

    // 4. Kinerja Departemen (Tabel Bawah)
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
            (object)['department' => 'Academic Affairs', 'open_tickets' => 0, 'closed_tickets' => 0, 'avg_days' => 0, 'sla_breach' => 0],
            (object)['department' => 'IT Services', 'open_tickets' => 0, 'closed_tickets' => 0, 'avg_days' => 0, 'sla_breach' => 0],
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

    // 6. Grafik Volume Bulanan
    $monthlyLabels = [];
    $monthlyData = [];
    for ($i = 5; $i >= 0; $i--) {
        $month = \Carbon\Carbon::now()->subMonths($i);
        $monthlyLabels[] = $month->format('M');
        $monthlyData[] = \App\Models\Complaint::whereMonth('created_at', $month->month)->whereYear('created_at', $month->year)->count();
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
            (object)['category_name' => 'Fasilitas Kelas', 'department' => 'Facilities', 'total' => 0],
            (object)['category_name' => 'Kantin', 'department' => 'Facilities', 'total' => 0],
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
            
            <form method="GET" action="{{ route('admin.performance') }}" class="bg-[#ffffff] rounded-lg border-solid border-[#c3c6d7] border py-2 px-4 flex flex-row gap-2 items-center justify-start shadow-[0_4px_20px_rgba(0,0,0,0.04)] relative focus-within:border-[#004ac6] transition cursor-pointer">
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

            <button class="bg-[#ffffff] rounded-lg border-solid border-[#c3c6d7] border py-2 px-4 flex flex-row gap-2 items-center justify-start text-[#191b23] hover:bg-gray-50 transition shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><path d="M4.5 15C4.0875 15 3.73438 14.8531 3.44062 14.5594C3.14687 14.2656 3 13.9125 3 13.5V4.5C3 4.0875 3.14687 3.73438 3.44062 3.44062C3.73438 3.14687 4.0875 3 4.5 3H13.5C13.9125 3 14.2656 3.14687 14.5594 3.44062C14.8531 3.73438 15 4.0875 15 4.5V13.5C15 13.9125 14.8531 14.2656 14.5594 14.5594C14.2656 14.8531 13.9125 15 13.5 15H4.5ZM4.5 13.5H8.25V11.25H4.5V13.5ZM9.75 13.5H13.5V11.25H9.75V13.5ZM0 12V1.5C0 1.0875 0.146875 0.734375 0.440625 0.440625C0.734375 0.146875 1.0875 0 1.5 0H12V1.5H1.5V12H0ZM4.5 9.75H8.25V7.5H4.5V9.75ZM9.75 9.75H13.5V7.5H9.75V9.75ZM4.5 6H13.5V4.5H4.5V6Z" fill="#191B23"/></svg>
                <span class="font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Export Excel</span>
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
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <rect width="36" height="36" rx="8" fill="#2563EB" fill-opacity="0.1"/>
                    <path d="M28 28L24 24H14C13.45 24 12.9792 23.8042 12.5875 23.4125C12.1958 23.0208 12 22.55 12 22V21H23C23.55 21 24.0208 20.8042 24.4125 20.4125C24.8042 20.0208 25 19.55 25 19V12H26C26.55 12 27.0208 12.1958 27.4125 12.5875C27.8042 12.9792 28 13.45 28 14V28ZM10 18.175L11.175 17H21V10H10V18.175ZM8 23V10C8 9.45 8.19583 8.97917 8.5875 8.5875C8.97917 8.19583 9.45 8 10 8H21C21.55 8 22.0208 8.19583 22.4125 8.5875C22.8042 8.97917 23 9.45 23 10V17C23 17.55 22.8042 18.0208 22.4125 18.4125C22.0208 18.8042 21.55 19 21 19H12L8 23ZM10 17V10V17Z" fill="#004AC6"/>
                </svg>
            </div>
            <div class="flex items-center gap-1 mt-4">
                <div class="bg-[rgba(22,163,74,0.10)] rounded-full px-2 py-0.5 flex items-center gap-1">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M4.66667 10.6667V2.55L0.933333 6.28333L0 5.33333L5.33333 0L10.6667 5.33333L9.73333 6.28333L6 2.55V10.6667H4.66667Z" fill="#16A34A"/></svg>
                    <span class="text-[#16a34a] font-medium text-[13px]">12%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Resolution Rate</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $resolutionRate }}%</span>
                </div>
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <rect width="36" height="36" rx="8" fill="#16A34A" fill-opacity="0.1"/>
                    <path d="M16.6 22.6L23.65 15.55L22.25 14.15L16.6 19.8L13.75 16.95L12.35 18.35L16.6 22.6ZM18 28C16.6167 28 15.3167 27.7375 14.1 27.2125C12.8833 26.6875 11.825 25.975 10.925 25.075C10.025 24.175 9.3125 23.1167 8.7875 21.9C8.2625 20.6833 8 19.3833 8 18C8 16.6167 8.2625 15.3167 8.7875 14.1C9.3125 12.8833 10.025 11.825 10.925 10.925C11.825 10.025 12.8833 9.3125 14.1 8.7875C15.3167 8.2625 16.6167 8 18 8C19.3833 8 20.6833 8.2625 21.9 8.7875C23.1167 9.3125 24.175 10.025 25.075 10.925C25.975 11.825 26.6875 12.8833 27.2125 14.1C27.7375 15.3167 28 16.6167 28 18C28 19.3833 27.7375 20.6833 27.2125 21.9C26.6875 23.1167 25.975 24.175 25.075 25.075C24.175 25.975 23.1167 26.6875 21.9 27.2125C20.6833 27.7375 19.3833 28 18 28ZM18 26C20.2167 26 22.1042 25.2208 23.6625 23.6625C25.2208 22.1042 26 20.2167 26 18C26 15.7833 25.2208 13.8958 23.6625 12.3375C22.1042 10.7792 20.2167 10 18 10C15.7833 10 13.8958 10.7792 12.3375 12.3375C10.7792 13.8958 10 15.7833 10 18C10 20.2167 10.7792 22.1042 12.3375 23.6625C13.8958 25.2208 15.7833 26 18 26Z" fill="#16A34A"/>
                </svg>
            </div>
            <div class="flex items-center gap-1 mt-4">
                <div class="bg-[rgba(22,163,74,0.10)] rounded-full px-2 py-0.5 flex items-center gap-1">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M4.66667 10.6667V2.55L0.933333 6.28333L0 5.33333L5.33333 0L10.6667 5.33333L9.73333 6.28333L6 2.55V10.6667H4.66667Z" fill="#16A34A"/></svg>
                    <span class="text-[#16a34a] font-medium text-[13px]">4.5%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Escalated Cases</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $escalatedCases }}</span>
                </div>
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <rect width="36" height="36" rx="8" fill="#D97706" fill-opacity="0.1"/>
                    <path d="M21.3 22.7L22.7 21.3L19 17.6V13H17V18.4L21.3 22.7ZM18 28C16.6167 28 15.3167 27.7375 14.1 27.2125C12.8833 26.6875 11.825 25.975 10.925 25.075C10.025 24.175 9.3125 23.1167 8.7875 21.9C8.2625 20.6833 8 19.3833 8 18C8 16.6167 8.2625 15.3167 8.7875 14.1C9.3125 12.8833 10.025 11.825 10.925 10.925C11.825 10.025 12.8833 9.3125 14.1 8.7875C15.3167 8.2625 16.6167 8 18 8C19.3833 8 20.6833 8.2625 21.9 8.7875C23.1167 9.3125 24.175 10.025 25.075 10.925C25.975 11.825 26.6875 12.8833 27.2125 14.1C27.7375 15.3167 28 16.6167 28 18C28 19.3833 27.7375 20.6833 27.2125 21.9C26.6875 23.1167 25.975 24.175 25.075 25.075C24.175 25.975 23.1167 26.6875 21.9 27.2125C20.6833 27.7375 19.3833 28 18 28ZM18 26C20.2167 26 22.1042 25.2208 23.6625 23.6625C25.2208 22.1042 26 20.2167 26 18C26 15.7833 25.2208 13.8958 23.6625 12.3375C22.1042 10.7792 20.2167 10 18 10C15.7833 10 13.8958 10.7792 12.3375 12.3375C10.7792 13.8958 10 15.7833 10 18C10 20.2167 10.7792 22.1042 12.3375 23.6625C13.8958 25.2208 15.7833 26 18 26Z" fill="#D97706"/>
                </svg>
            </div>
            <div class="flex items-center gap-1 mt-4">
                <div class="bg-[rgba(217,119,6,0.10)] rounded-full px-2 py-0.5 flex items-center gap-1">
                    <svg width="11" height="2" viewBox="0 0 11 2" fill="none"><path d="M0 1.33333V0H10.6667V1.33333H0Z" fill="#505F76" /></svg>
                    <span class="text-[#505f76] font-medium text-[13px]">0%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-[rgba(195,198,215,0.30)] flex flex-col justify-between w-full min-h-[160px]">
            <div class="flex justify-between items-start w-full">
                <div class="flex flex-col">
                    <span class="text-[#505f76] font-['Manrope-Regular',_sans-serif] text-sm leading-5 font-normal mb-1">Avg. Response Time</span>
                    <span class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-2xl leading-8 font-semibold">{{ $avgDisplay }}</span>
                </div>
                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="shrink-0">
                    <rect width="36" height="36" rx="8" fill="#BA1A1A" fill-opacity="0.1"/>
                    <path d="M8 27L19 8L30 27H8ZM11.45 25H26.55L19 12L11.45 25ZM19 24C19.2833 24 19.5208 23.9042 19.7125 23.7125C19.9042 23.5208 20 23.2833 20 23C20 22.7167 19.9042 22.4792 19.7125 22.2875C19.5208 22.0958 19.2833 22 19 22C18.7167 22 18.4792 22.0958 18.2875 22.2875C18.0958 22.4792 18 22.7167 18 23C18 23.2833 18.0958 23.5208 18.2875 23.7125C18.4792 23.9042 18.7167 24 19 24ZM18 21H20V16H18V21Z" fill="#BA1A1A"/>
                </svg>
            </div>
            <div class="flex items-center gap-1 mt-4">
                <div class="bg-[rgba(220,38,38,0.10)] rounded-full px-2 py-0.5 flex items-center gap-1">
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"><path d="M4.66667 0V8.11667L0.933333 4.38333L0 5.33333L5.33333 0L10.6667 5.33333L9.73333 4.38333L6 8.11667V0H4.66667Z" fill="#DC2626"/></svg>
                    <span class="text-[#dc2626] font-medium text-[13px]">2 hrs</span>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        <div class="bg-[#ffffff] rounded-xl p-6 flex flex-col relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-8 w-full min-h-[464px]">
            <div class="flex flex-row items-center justify-between w-full mb-6">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">Monthly Complaint Volume</div>
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

            <div class="bg-[#f3f3fe] rounded-lg border-dashed border-[#c3c6d7] border p-4 flex flex-row gap-3 items-start justify-start w-full mt-auto">
                <svg class="shrink-0 mt-0.5 w-[15px] h-5 relative overflow-visible" width="15" height="20" viewBox="0 0 15 20" fill="none"><path d="M7.5 20C6.95 20 6.47917 19.8042 6.0875 19.4125C5.69583 19.0208 5.5 18.55 5.5 18H9.5C9.5 18.55 9.30417 19.0208 8.9125 19.4125C8.52083 19.8042 8.05 20 7.5 20ZM3.5 17V15H11.5V17H3.5ZM3.75 14C2.6 13.3167 1.6875 12.4 1.0125 11.25C0.3375 10.1 0 8.85 0 7.5C0 5.41667 0.729167 3.64583 2.1875 2.1875C3.64583 0.729167 5.41667 0 7.5 0C9.58333 0 11.3542 0.729167 12.8125 2.1875C14.2708 3.64583 15 5.41667 15 7.5C15 8.85 14.6625 10.1 13.9875 11.25C13.3125 12.4 12.4 13.3167 11.25 14H3.75ZM4.35 12H10.65C11.4 11.4667 11.9792 10.8083 12.3875 10.025C12.7958 9.24167 13 8.4 13 7.5C13 5.96667 12.4667 4.66667 11.4 3.6C10.3333 2.53333 9.03333 2 7.5 2C5.96667 2 4.66667 2.53333 3.6 3.6C2.53333 4.66667 2 5.96667 2 7.5C2 8.4 2.20417 9.24167 2.6125 10.025C3.02083 10.8083 3.6 11.4667 4.35 12Z" fill="#004AC6"/></svg>
                <div class="text-[#505f76] text-left font-['Manrope-Regular',_sans-serif] text-[13px] leading-5 font-normal w-full">
                    <b>{{ $worstDept }}</b> department is currently showing a slight dip in resolution time SLA. Recommend resource allocation review.
                </div>
            </div>
        </div>

        <div class="bg-[#ffffff] rounded-xl flex flex-col relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-8 w-full min-h-[422px] overflow-hidden">
            <div class="border-solid border-[#e1e2ed] border-b p-6 flex flex-row items-center justify-between w-full">
                <div class="text-[#191b23] text-left font-['Manrope-SemiBold',_sans-serif] text-lg leading-7 font-semibold">Department Performance</div>
                <div class="text-[#004ac6] text-center font-['Manrope-SemiBold',_sans-serif] text-[13px] leading-[18px] font-semibold tracking-[0.65px] cursor-pointer hover:underline">View All</div>
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
        
        // 1. Monthly Volume Bar Chart
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
                        ticks: { stepSize: 5, color: '#737686', font: { family: 'Manrope' } },
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
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed !== null) { label += context.parsed + ' tickets'; }
                                return label;
                            }
                        }
                    }
                }
            }
        });
        
    });
</script>
@endsection