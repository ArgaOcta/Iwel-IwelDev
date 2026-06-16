@extends('layouts.admin')
@section('title', 'Admin Dashboard - SCMS')

@section('content')
<div class="flex flex-col gap-6 w-full max-w-[1400px] mx-auto">
    
    <div class="flex flex-col gap-1 text-[#191b23]">
        <h1 class="font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">Executive Overview</h1>
        <p class="text-[#434655] text-base">System performance and institutional compliance metrics.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full mt-6">
        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px] uppercase">TOTAL ACTIVE USERS</span>
                    <span class="text-[#191b23] font-bold text-2xl mt-1">{{ number_format($totalActiveUsers) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#c3c6d7] border-b-4 border-b-[#004ac6] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px] uppercase">OVERALL RESOLUTION</span>
                    <span class="text-[#191b23] font-bold text-2xl mt-1">{{ number_format($overallResolution, 1) }}%</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px] uppercase">AVG RESOLUTION TIME</span>
                    <div class="flex items-end gap-1 mt-1">
                        <span class="text-[#191b23] font-bold text-2xl">{{ $avgResolutionTime }}</span>
                        <span class="text-[#434655] text-lg mb-0.5">days</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] p-6 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <span class="text-[#434655] font-semibold text-[13px] tracking-[0.65px] uppercase">PENDING CRITICAL</span>
                    <span class="text-[#191b23] font-bold text-2xl mt-1">{{ $pendingCritical }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full mt-2">
        
        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-8 flex flex-col overflow-hidden min-h-[400px]">
            <div class="p-6 border-b border-[rgba(195,198,215,0.30)] flex justify-between items-center">
                <h3 class="text-[#191b23] text-lg font-semibold">Complaint Volume & Resolution Trend</h3>
                <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-[#f3f3fe] border border-[#c3c6d7] rounded-lg px-2 cursor-pointer focus-within:border-[#004ac6]">
                    <select name="chart_range" onchange="this.form.submit()" class="bg-transparent text-[#434655] text-[13px] font-semibold tracking-[0.65px] focus:outline-none appearance-none cursor-pointer py-1.5 pl-2 pr-6 relative w-full">
                        <option value="3" {{ request('chart_range') == 3 ? 'selected' : '' }}>Last 3 Months</option>
                        <option value="6" {{ request('chart_range', 6) == 6 ? 'selected' : '' }}>Last 6 Months</option>
                        <option value="12" {{ request('chart_range') == 12 ? 'selected' : '' }}>Last 12 Months</option>
                    </select>
                </form>
            </div>
            <div class="flex-1 p-6 relative w-full h-full min-h-[300px]">
                <canvas id="adminChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] lg:col-span-4 flex flex-col p-6 items-center justify-between min-h-[400px]">
            <div class="w-full text-center mb-6">
                <h3 class="text-[#191b23] text-lg font-semibold">Student Satisfaction (CSAT)</h3>
                <p class="text-[#434655] text-sm mt-1">Overall index based on post-resolution surveys.</p>
            </div>

            <div class="relative w-48 h-24 overflow-hidden my-4 flex-shrink-0">
                <div class="absolute top-0 left-0 w-48 h-48 rounded-full border-[24px] border-[#e1e2ed] box-border"></div>
                <div class="absolute top-0 left-0 w-48 h-48 rounded-full border-[24px] border-[#004ac6] border-b-transparent border-r-transparent box-border transform transition-transform duration-1000 ease-out" 
                     style="transform: rotate({{ $csatRotation }}deg);"></div>
                <div class="absolute bottom-0 left-0 w-full flex items-end justify-center mb-[-4px]">
                    <span class="text-[#191b23] font-bold text-4xl">{{ $csatScore }}</span>
                    <span class="text-[#434655] text-xl font-normal ml-1">/5</span>
                </div>
            </div>
            
            <div class="{{ $csatBg }} {{ $csatText }} px-3 py-1 rounded-md text-[13px] font-semibold mb-8 uppercase tracking-wider">
                {{ $csatPredicate }}
            </div>

            <div class="w-full grid grid-cols-2 border-t border-[#c3c6d7] pt-4">
                <div class="flex flex-col items-center justify-center">
                    <span class="text-[#434655] text-sm">Response Rate</span>
                    <span class="text-[#191b23] font-semibold text-lg">{{ $responseRate }}%</span>
                </div>
                <div class="flex flex-col items-center justify-center border-l border-[#c3c6d7]">
                    <span class="text-[#434655] text-sm">NPS</span>
                    <span class="text-[#191b23] font-semibold text-lg">{{ $nps > 0 ? '+'.$nps : $nps }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] shadow-[0_4px_20px_rgba(0,0,0,0.04)] w-full flex flex-col overflow-hidden mt-6">
        <div class="p-6 border-b border-[#c3c6d7] bg-[#f8fafc] flex justify-between items-center">
            <h3 class="text-[#191b23] text-lg font-semibold">Admin Performance (Current Month)</h3>
        </div>
        
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead class="bg-[#f1f5f9] border-b border-[#c3c6d7] text-[#434655] text-[13px] font-medium tracking-[0.65px]">
                    <tr>
                        <th class="py-3 px-6 font-medium">Administrator</th>
                        <th class="py-3 px-6 font-medium">Resolved</th>
                        <th class="py-3 px-6 font-medium">Avg Time</th>
                        <th class="py-3 px-6 font-medium">CSAT</th>
                    </tr>
                </thead>
                <tbody class="text-[#191b23] text-sm">
                    @foreach($departmentPerformances as $perf)
                    <tr class="border-b border-[#e1e2ed] hover:bg-gray-50 transition">
                        <td class="py-4 px-6 flex items-center gap-3">
                            <img class="w-8 h-8 rounded-full object-cover shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($perf->manager) }}&color=fff&background=004ac6">
                            <div class="flex flex-col">
                                <span class="font-semibold text-[#191b23]">{{ $perf->manager }}</span>
                                <span class="text-[#434655] text-xs">{{ $perf->department }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 font-semibold">{{ number_format($perf->total_resolved) }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded text-xs font-semibold {{ $perf->avg_days > 3 ? 'bg-[rgba(186,26,26,0.10)] text-[#ba1a1a]' : 'bg-[rgba(5,150,105,0.10)] text-[#059669]' }}">
                                {{ $perf->avg_days ?? 0 }} days
                            </span>
                        </td>
                        <td class="py-4 px-6 font-semibold text-[#191b23]">
                            {{ $perf->total_resolved > 0 ? $csatScore : '0.0' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
      const ctx = document.getElementById('adminChart').getContext('2d');
      const gradient = ctx.createLinearGradient(0, 0, 0, 300);
      gradient.addColorStop(0, 'rgba(0, 74, 198, 0.3)');
      gradient.addColorStop(1, 'rgba(0, 74, 198, 0)');

      new Chart(ctx, {
          type: 'line',
          data: {
              labels: {!! json_encode($chartLabels) !!},
              datasets: [{
                  label: 'Tiket Masuk',
                  data: {!! json_encode($chartData) !!},
                  borderColor: '#004ac6',
                  borderWidth: 3,
                  backgroundColor: gradient,
                  fill: true,
                  tension: 0.4,
                  pointBackgroundColor: '#004ac6',
                  pointHoverRadius: 7
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: { legend: { display: false } },
              scales: {
                  y: { beginAtZero: true, ticks: { stepSize: 1 } },
                  x: { grid: { display: false } }
              }
          }
      });
    });
</script>
@endsection
