@extends('layouts.admin')
@section('title', 'Service Evaluation - SCMS')

@section('content')

@php
    // --- MENGAMBIL DATA DINAMIS HARUS DIULANG DI FILE INI ---
    $days = request('range', 30);
    $startDate = \Carbon\Carbon::now()->subDays($days);

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
            (object)['department' => 'Data Belum Tersedia', 'open_tickets' => 0, 'closed_tickets' => 0, 'avg_days' => 0, 'sla_breach' => 0],
        ]);
    }

    $departmentStats = $departmentStats->map(function($stat) {
        $stat->total = $stat->open_tickets + $stat->closed_tickets;
        $stat->resolution_rate = $stat->total > 0 ? round(($stat->closed_tickets / $stat->total) * 100) : 0;
        $stat->status = $stat->resolution_rate >= 75 ? 'Optimal' : 'Lagging';
        $stat->breach_rate = $stat->closed_tickets > 0 ? round(($stat->sla_breach / $stat->closed_tickets) * 100) : 0;
        return $stat;
    });

    $needsAttentionList = collect($departmentStats)->filter(function($item) {
        return $item->open_tickets > 0 || $item->status == 'Lagging';
    })->sortByDesc('open_tickets')->values();

    // PERBAIKAN GRAFIK LINE: Dinamis Sesuai Dropdown
    $chartLabels = [];
    $chartData = [];
    $step = max(1, floor($days / 6));

    for ($i = 5; $i >= 0; $i--) {
        $start = \Carbon\Carbon::now()->subDays(($i + 1) * $step);
        $end = \Carbon\Carbon::now()->subDays($i * $step);
        
        $chartLabels[] = $end->format($days <= 30 ? 'd M' : 'M Y');
        
        $avgRes = \App\Models\Complaint::whereIn('status', ['Resolved', 'Closed'])
            ->whereBetween('created_at', [$start, $end])
            ->select(\Illuminate\Support\Facades\DB::raw('AVG(TIMESTAMPDIFF(DAY, created_at, updated_at)) as avg_days'))
            ->first()->avg_days ?? 0;
        
        $chartData[] = round($avgRes, 1);
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

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 w-full">
        <div class="flex flex-col gap-1 w-full md:w-auto shrink-0">
            <h1 class="font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px] whitespace-nowrap text-[#191b23]">Service Evaluation</h1>
            <p class="text-[#434655] text-base">Leadership overview of institutional complaint resolution performance.</p>
        </div>
        
        <div class="flex flex-row flex-wrap items-center gap-3 w-full md:w-auto shrink-0 print:hidden">
            
            <form method="GET" action="{{ route('admin.performance') }}" class="relative bg-white border border-[#c3c6d7] rounded-lg py-2 px-4 flex items-center gap-2 cursor-pointer hover:bg-gray-50 transition shadow-sm focus-within:border-[#004ac6]">
                <svg width="15" height="15" viewBox="0 0 15 17" fill="currentColor"><path d="M1.66667 16.6667C1.20833 16.6667 0.815972 16.5035 0.489583 16.1771C0.163194 15.8507 0 15.4583 0 15V3.33333C0 2.875 0.163194 2.48264 0.489583 2.15625C0.815972 1.82986 1.20833 1.66667 1.66667 1.66667H2.5V0H4.16667V1.66667H10.8333V0H12.5V1.66667H13.3333C13.7917 1.66667 14.184 1.82986 14.5104 2.15625C14.8368 2.48264 15 2.875 15 3.33333V15C15 15.4583 14.8368 15.8507 14.5104 16.1771C14.184 16.5035 13.7917 16.6667 13.3333 16.6667H1.66667ZM1.66667 15H13.3333V6.66667H1.66667V15ZM1.66667 5H13.3333V3.33333H1.66667V5Z" fill="#191B23"/></svg>
                <select name="range" onchange="this.form.submit()" class="bg-transparent text-[#191b23] font-semibold text-[13px] outline-none cursor-pointer appearance-none pr-5 z-10 w-[110px]">
                    <option value="30" {{ request('range', 30) == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ request('range') == 90 ? 'selected' : '' }}>Last 3 Months</option>
                    <option value="180" {{ request('range') == 180 ? 'selected' : '' }}>Last 6 Months</option>
                    <option value="365" {{ request('range') == 365 ? 'selected' : '' }}>This Year</option>
                </select>
                <svg class="absolute right-4 pointer-events-none" width="10" height="6" viewBox="0 0 10 7" fill="currentColor"><path d="M5 6.16667L0 1.16667L1.16667 0L5 3.83333L8.83333 0L10 1.16667L5 6.16667Z" fill="#191B23"/></svg>
            </form>
            
            <button onclick="window.print()" class="bg-[#004ac6] border border-[#004ac6] text-white rounded-lg py-2 px-4 flex items-center gap-2 hover:bg-blue-800 transition shadow-sm">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M6.66667 10L2.5 5.83333L3.66667 4.625L5.83333 6.79167V0H7.5V6.79167L9.66667 4.625L10.8333 5.83333L6.66667 10ZM1.66667 13.3333C1.20833 13.3333 0.815972 13.1701 0.489583 12.8438C0.163194 12.5174 0 12.125 0 11.6667V9.16667H1.66667V11.6667H11.6667V9.16667H13.3333V11.6667C13.3333 12.125 13.1701 12.5174 12.8438 12.8438C12.5174 13.1701 12.125 13.3333 11.6667 13.3333H1.66667Z" fill="currentColor"/></svg>
                <span class="font-semibold text-[13px]">Export Report</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-sm p-6 lg:col-span-4 flex flex-col justify-start gap-4 min-h-[294px]">
            <div class="flex justify-between items-center w-full">
                <span class="text-[#191b23] font-semibold text-lg">Needs Attention</span>
                <svg width="22" height="19" viewBox="0 0 22 19" fill="none"><path d="M0 19L11 0L22 19H0ZM3.45 17H18.55L11 4L3.45 17ZM11 16C11.2833 16 11.5208 15.9042 11.7125 15.7125C11.9042 15.5208 12 15.2833 12 15C12 14.7167 11.9042 14.4792 11.7125 14.2875C11.5208 14.0958 11.2833 14 11 14C10.7167 14 10.4792 14.0958 10.2875 14.2875C10.0958 14.4792 10 14.7167 10 15C10 15.2833 10.0958 15.5208 10.2875 15.7125C10.4792 15.9042 10.7167 16 11 16ZM10 13H12V8H10V13Z" fill="#BA1A1A"/></svg>
            </div>
            
            <div class="flex flex-col gap-3 w-full">
                @forelse($needsAttentionList->take(2) as $index => $dept)
                    @if($index == 0 || $dept->status == 'Lagging')
                        <div class="bg-[rgba(255,218,214,0.30)] rounded-lg border border-[rgba(255,218,214,0.50)] p-3 flex justify-between items-center w-full hover:bg-[rgba(255,218,214,0.50)] transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#ffdad6] flex items-center justify-center shrink-0">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M0 12V2.66667H2.66667V0H9.33333V5.33333H12V12H6.66667V9.33333H5.33333V12H0ZM1.33333 10.6667H2.66667V9.33333H1.33333V10.6667ZM1.33333 8H2.66667V6.66667H1.33333V8ZM1.33333 5.33333H2.66667V4H1.33333V5.33333ZM4 8H5.33333V6.66667H4V8ZM4 5.33333H5.33333V4H4V5.33333ZM4 2.66667H5.33333V1.33333H4V2.66667ZM6.66667 8H8V6.66667H6.66667V8ZM6.66667 5.33333H8V4H6.66667V5.33333ZM6.66667 2.66667H8V1.33333H6.66667V2.66667ZM9.33333 10.6667H10.6667V9.33333H9.33333V10.6667ZM9.33333 8H10.6667V6.66667H9.33333V8Z" fill="#BA1A1A"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[#191b23] font-semibold text-[13px] leading-[18px]">{{ $dept->department }}</span>
                                    <span class="text-[#ba1a1a] text-sm">Critical / Lagging</span>
                                </div>
                            </div>
                            <span class="text-[#ba1a1a] font-semibold text-lg">{{ $dept->open_tickets }}</span>
                        </div>
                    @else
                        <div class="bg-[#ededf9] rounded-lg border border-[rgba(195,198,215,0.30)] p-3 flex justify-between items-center w-full hover:bg-[#e1e2ed] transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#e1e2ed] flex items-center justify-center shrink-0">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 10.6667V6H3.3333V10.6667H2ZM6 10.6667V6H7.3333V10.6667H6ZM0 13.3333V12H13.3333V13.3333H0ZM10 10.6667V6H11.3333V10.6667H10ZM0 4.6667V3.3333L6.6667 0L13.3333 3.3333V4.6667H0ZM2.9667 3.3333H10.3667L6.6667 1.5L2.9667 3.3333Z" fill="#434655"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[#191b23] font-semibold text-[13px] leading-[18px]">{{ $dept->department }}</span>
                                    <span class="text-[#434655] text-sm">Backlog increasing</span>
                                </div>
                            </div>
                            <span class="text-[#191b23] font-semibold text-lg">{{ $dept->open_tickets }}</span>
                        </div>
                    @endif
                @empty
                    <div class="bg-[#dcfce7] rounded-lg border border-[#bbf7d0] p-4 flex justify-between items-center w-full">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#bbf7d0] flex items-center justify-center shrink-0">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#166534" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[#166534] font-semibold text-[13px]">All Clear!</span>
                                <span class="text-[#166534] text-sm opacity-80">No critical action required</span>
                            </div>
                        </div>
                        <span class="text-[#166534] font-semibold text-[28px]">0</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-sm p-6 lg:col-span-8 flex flex-col justify-start min-h-[294px]">
            <div class="flex justify-between items-center w-full mb-4">
                <span class="text-[#191b23] font-semibold text-lg">Average Resolution Time (Days)</span>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-[#ba1a1a] rounded-full opacity-50 border-2 border-transparent" style="border-style: dashed;"></div>
                    <span class="text-[#434655] text-sm">Target (3 Days)</span>
                </div>
            </div>
            
            <div class="w-full flex-1 relative min-h-[200px]">
                <canvas id="resolutionChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-sm w-full overflow-hidden mt-2">
        <div class="p-6 border-b border-[rgba(195,198,215,0.50)] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full bg-[#f8fafc]">
            <h2 class="text-[#191b23] text-lg font-semibold">Department Performance Comparison</h2>
            
            <div class="relative bg-white border border-[#c3c6d7] rounded-lg p-2 pl-9 w-full sm:w-64 focus-within:border-[#004ac6] transition shadow-sm print:hidden">
                <svg class="absolute left-3 top-2.5 text-[#6b7280]" width="16" height="16" viewBox="0 0 18 24" fill="none"><path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="currentColor"/></svg>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search department..." class="bg-transparent border-none outline-none w-full text-sm text-[#191b23]">
            </div>
        </div>

        <div class="flex-1 w-full overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px]">
                <thead class="bg-[#f1f5f9] border-b border-[#e1e2ed] text-[#434655] text-[13px] font-semibold tracking-[0.65px]">
                    <tr>
                        <th class="py-4 px-6">Department</th>
                        <th class="py-4 px-6 text-center">Open</th>
                        <th class="py-4 px-6 text-center">Resolved</th>
                        <th class="py-4 px-6 min-w-[200px]">Resolution Rate</th>
                        <th class="py-4 px-6">Status</th>
                    </tr>
                </thead>
                <tbody id="departmentTable" class="text-[#191b23] text-sm">
                    @forelse($departmentStats ?? [] as $stat)
                    <tr class="border-b border-[#e1e2ed] hover:bg-gray-50 transition-colors">
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="bg-[rgba(0,74,198,0.10)] w-8 h-8 rounded flex items-center justify-center">
                                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none"><path d="M8.25 13.5L3 10.65V6.15L0 4.5L8.25 0L16.5 4.5V10.5H15V5.325L13.5 6.15V10.65L8.25 13.5ZM8.25 7.275L13.3875 4.5L8.25 1.725L3.1125 4.5L8.25 7.275Z" fill="#004AC6"/></svg>
                                </div>
                                <span class="font-medium text-sm department-name">{{ $stat->department }}</span>
                            </div>
                        </td>
                        
                        <td class="py-5 px-6 text-center text-[#943700] font-medium">{{ $stat->open_tickets }}</td>
                        <td class="py-5 px-6 text-center font-medium">{{ $stat->closed_tickets }}</td>
                        
                        <td class="py-5 px-6">
                            <div class="flex items-center gap-4 w-full">
                                <div class="bg-[#e1e2ed] rounded-full h-2 flex-1 relative overflow-hidden min-w-[100px]">
                                    <div class="{{ $stat->status == 'Lagging' ? 'bg-[#ba1a1a]' : 'bg-[#004ac6]' }} absolute left-0 top-0 bottom-0 rounded-full" style="width: {{ $stat->resolution_rate }}%;"></div>
                                </div>
                                <span class="{{ $stat->status == 'Lagging' ? 'text-[#ba1a1a]' : 'text-[#191b23]' }} font-medium text-xs w-8">{{ $stat->resolution_rate }}%</span>
                            </div>
                        </td>
                        
                        <td class="py-5 px-6">
                            @if($stat->status == 'Optimal')
                                <div class="inline-flex bg-[#d0e1fb] text-[#004ac6] border border-[#004ac6]/20 px-2.5 py-1 rounded-md text-xs font-semibold">
                                    Optimal
                                </div>
                            @else
                                <div class="inline-flex bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a]/20 px-2.5 py-1 rounded-md text-xs font-semibold">
                                    Lagging
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-10 text-center text-gray-500">Tidak ada data departemen pada rentang waktu ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function filterTable() {
        let input = document.getElementById("searchInput").value.toUpperCase();
        let table = document.getElementById("departmentTable");
        let tr = table.getElementsByTagName("tr");
        
        for (let i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByClassName("department-name")[0];
            if (td) {
                let txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const ctxElem = document.getElementById('resolutionChart');
        if (ctxElem) {
            const ctx = ctxElem.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(0, 74, 198, 0.2)');
            gradient.addColorStop(1, 'rgba(0, 74, 198, 0)');

            const labelsData = {!! isset($chartLabels) ? json_encode($chartLabels) : '[]' !!};
            const chartDataValues = {!! isset($chartData) ? json_encode($chartData) : '[]' !!};
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsData,
                    datasets: [
                        {
                            label: 'Avg Resolution Time',
                            data: chartDataValues,
                            borderColor: '#004ac6',
                            borderWidth: 3,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#004ac6',
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Target',
                            data: Array(labelsData.length).fill(3),
                            borderColor: 'rgba(186, 26, 26, 0.4)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            max: 7,
                            ticks: { stepSize: 1, color: '#737686', font: { family: 'Manrope' } },
                            grid: { color: 'rgba(195, 198, 215, 0.2)' }
                        },
                        x: { 
                            ticks: { color: '#737686', font: { family: 'Manrope', weight: 'bold' } },
                            grid: { display: false } 
                        }
                    }
                }
            });
        }
    });
</script>
@endsection