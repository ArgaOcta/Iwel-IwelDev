@extends('layouts.mahasiswa')
@section('title', 'Dashboard - SCMS')

@section('content')
<div class="p-6 pb-14 w-full h-full min-h-screen">
  
  @if (session('success'))
      <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
          <span class="block sm:inline font-medium">{{ session('success') }}</span>
      </div>
  @endif

  <div class="grid gap-6" style="grid-template-columns: repeat(12, minmax(0, 1fr));">
    
    <div class="rounded-xl p-6 flex flex-row items-center justify-between h-[120px] overflow-hidden col-span-12 relative shadow-[0_4px_20px_rgba(0,0,0,0.04)]" style="background: linear-gradient(90deg, rgba(0, 74, 198, 1) 0%, rgba(180, 197, 255, 1) 100%);">
      <svg class="absolute right-[-50px] top-[-50px] opacity-10" width="184" height="150" viewBox="0 0 184 150" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M91.6667 150L33.3333 118.333V68.3333L0 50L91.6667 0L183.333 50V116.667H166.667V59.1667L150 68.3333V118.333L91.6667 150ZM91.6667 80.8333L148.75 50L91.6667 19.1667L34.5833 50L91.6667 80.8333ZM91.6667 131.042L133.333 108.542V77.0833L91.6667 100L50 77.0833V108.542L91.6667 131.042Z" fill="white"/></svg>
      <div class="flex flex-col gap-2 z-10">
        <div class="text-[#ffffff] font-['Manrope-Bold',_sans-serif] text-[32px] leading-10 font-bold tracking-[-0.64px]">Student Dashboard</div>
        <div class="text-[#ffffff] font-['Manrope-Regular',_sans-serif] text-base leading-6 opacity-90">Track your academic concerns and administrative requests.</div>
      </div>
      <a href="{{ route('complaint.create') }}" class="bg-[#ffffff] rounded-lg py-3 px-6 flex items-center gap-2 hover:bg-gray-100 transition shadow-[0_1px_2px_rgba(0,0,0,0.05)] z-10">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 15H11V11H15V9H11V5H9V9H5V11H9V15ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="#004AC6"/></svg>
        <span class="text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">New Complaint</span>
      </a>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-5 col-span-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="flex justify-between">
        <div class="flex flex-col gap-1">
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Total Complaints</div>
          <div class="text-[#191b23] text-2xl font-semibold">{{ $totalComplaints }}</div>
        </div>
        <div class="bg-[#dbe1ff] rounded-full w-10 h-10 flex items-center justify-center">
          <svg width="22" height="16" viewBox="0 0 22 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 16C1.45 16 0.979167 15.8042 0.5875 15.4125C0.195833 15.0208 0 14.55 0 14V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H8L10 2H18C18.55 2 19.0208 2.19583 19.4125 2.5875C19.8042 2.97917 20 3.45 20 4H9.175L7.175 2H2V14L4.4 6H21.5L18.925 14.575C18.7917 15.0083 18.5458 15.3542 18.1875 15.6125C17.8292 15.8708 17.4333 16 17 16H2ZM4.1 14H17L18.8 8H5.9L4.1 14ZM4.1 14L5.9 8L4.1 14ZM2 4V2V4Z" fill="#004AC6"/></svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-5 col-span-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="flex justify-between">
        <div class="flex flex-col gap-1">
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Pending</div>
          <div class="text-[#bc4800] text-2xl font-semibold">{{ $pendingComplaints }}</div>
        </div>
        <div class="bg-[#ffdbcd] rounded-full w-10 h-10 flex items-center justify-center">
          <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 18H12V15C12 13.9 11.6083 12.9583 10.825 12.175C10.0417 11.3917 9.1 11 8 11C6.9 11 5.95833 11.3917 5.175 12.175C4.39167 12.9583 4 13.9 4 15V18ZM8 9C9.1 9 10.0417 8.60833 10.825 7.825C11.6083 7.04167 12 6.1 12 5V2H4V5C4 6.1 4.39167 7.04167 5.175 7.825C5.95833 8.60833 6.9 9 8 9ZM0 20V18H2V15C2 13.9833 2.2375 13.0292 2.7125 12.1375C3.1875 11.2458 3.85 10.5333 4.7 10C3.85 9.46667 3.1875 8.75417 2.7125 7.8625C2.2375 6.97083 2 6.01667 2 5V2H0V0H16V2H14V5C14 6.01667 13.7625 6.97083 13.2875 7.8625C12.8125 8.75417 12.15 9.46667 11.3 10C12.15 10.5333 12.8125 11.2458 13.2875 12.1375C13.7625 13.0292 14 13.9833 14 15V18H16V20H0Z" fill="#943700"/></svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-5 col-span-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="flex justify-between">
        <div class="flex flex-col gap-1">
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">In Progress</div>
          <div class="text-[#004ac6] text-2xl font-semibold">{{ $inProgressComplaints }}</div>
        </div>
        <div class="bg-[#d3e4fe] rounded-full w-10 h-10 flex items-center justify-center">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 16V14H2.75L2.35 13.65C1.48333 12.8833 0.875 12.0083 0.525 11.025C0.175 10.0417 0 9.05 0 8.05C0 6.2 0.554167 4.55417 1.6625 3.1125C2.77083 1.67083 4.21667 0.716667 6 0.25V2.35C4.8 2.78333 3.83333 3.52083 3.1 4.5625C2.36667 5.60417 2 6.76667 2 8.05C2 8.8 2.14167 9.52917 2.425 10.2375C2.70833 10.9458 3.15 11.6 3.75 12.2L4 12.45V10H6V16H0ZM10 15.75V13.65C11.2 13.2167 12.1667 12.4792 12.9 11.4375C13.6333 10.3958 14 9.23333 14 7.95C14 7.2 13.8583 6.47083 13.575 5.7625C13.2917 5.05417 12.85 4.4 12.25 3.8L12 3.55V6H10V0H16V2H13.25L13.65 2.35C14.4667 3.16667 15.0625 4.05417 15.4375 5.0125C15.8125 5.97083 16 6.95 16 7.95C16 9.8 15.4458 11.4458 14.3375 12.8875C13.2292 14.3292 11.7833 15.2833 10 15.75Z" fill="#38485D"/></svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-5 col-span-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="flex justify-between">
        <div class="flex flex-col gap-1">
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">Resolved</div>
          <div class="text-[#191b23] text-2xl font-semibold">{{ $resolvedComplaints }}</div>
        </div>
        <div class="bg-[#e7e7f3] rounded-full w-10 h-10 flex items-center justify-center">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.6 14.6L15.65 7.55L14.25 6.15L8.6 11.8L5.75 8.95L4.35 10.35L8.6 14.6ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1 <path d="M8.6 14.6L15.65 7.55L14.25 6.15L8.6 11.8L5.75 8.95L4.35 10.35L8.6 14.6ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="#434655"/></svg>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 col-span-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)] min-h-[400px] flex flex-col">
      <div class="border-b border-[rgba(195,198,215,0.50)] pb-2 mb-4">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Submission Activity</h3>
      </div>
      <div class="flex-1 relative w-full h-full min-h-[300px]">
        <canvas id="submissionChart"></canvas>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('submissionChart').getContext('2d');
        
        // Membuat efek gradient warna biru transparan khas Glassmorphism
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 74, 198, 0.3)');
        gradient.addColorStop(1, 'rgba(0, 74, 198, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Pengaduan',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#004ac6',
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4, // Membuat lekukan garis menjadi smooth
                    pointBackgroundColor: '#004ac6',
                    pointHoverRadius: 7
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
                        grid: { color: 'rgba(195, 198, 215, 0.2)' }
                    },
                    x: {
                        ticks: { color: '#737686', font: { family: 'Manrope', weight: 'bold' } },
                        grid: { display: false }
                    }
                }
            }
        });
      });
    </script>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-6 col-span-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="border-b border-[rgba(195,198,215,0.50)] pb-2 mb-6">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Recent Activity</h3>
      </div>
      <div class="pl-3 overflow-y-auto max-h-[300px]">
        <div class="border-l-2 border-[rgba(195,198,215,0.30)] flex flex-col gap-6">
          @forelse ($recentActivities as $activity)
            <div class="pl-6 flex flex-col gap-1 relative">
              <div class="text-[#434655] text-[13px] font-semibold">{{ $activity->updated_at->diffForHumans() }}</div>
              <div class="text-[#191b23] text-base font-medium">Complaint #{{ $activity->ticket_no }}</div>
              <div class="text-[#505f76] text-sm">Status updated to '{{ $activity->status }}'.</div>
              <div class="bg-[#004ac6] rounded-full border-2 border-white w-4 h-4 absolute left-[-9px] top-1"></div>
            </div>
          @empty
            <div class="pl-6 text-[#505f76] text-sm italic">Belum ada aktivitas.</div>
          @endforelse
        </div>
      </div>
    </div>

    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] col-span-12 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)]">
      <div class="border-b border-[rgba(195,198,215,0.50)] p-6 flex justify-between items-center">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Recent Submissions</h3>
        <a href="{{ route('complaint.history') }}" class="text-[#004ac6] text-[13px] font-semibold hover:underline">View All</a>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead class="bg-[#f3f3fe] text-[#434655] text-[13px] font-semibold border-b border-[rgba(195,198,215,0.20)]">
            <tr>
              <th class="py-3 px-6 font-semibold">ID</th>
              <th class="py-3 px-6 font-semibold">Category</th>
              <th class="py-3 px-6 font-semibold">Subject</th>
              <th class="py-3 px-6 font-semibold">Date Submitted</th>
              <th class="py-3 px-6 font-semibold">Status</th>
            </tr>
          </thead>
          <tbody class="text-[#191b23] text-sm font-medium">
            @forelse ($recentSubmissions as $submission)
              @php
                  $badgeBg = match($submission->status) {
                      'Pending', 'Reviewing' => 'bg-[#ffdbcd] text-[#bc4800]',
                      'In Progress' => 'bg-[#d3e4fe] text-[#38485d]',
                      'Resolved', 'Closed' => 'bg-[#e7e7f3] text-[#434655]',
                      default => 'bg-gray-200 text-gray-700'
                  };
              @endphp
              <tr class="border-b border-[rgba(195,198,215,0.20)] hover:bg-gray-50 transition">
                <td class="py-3 px-6">#{{ $submission->ticket_no ?? 'CMP-000' }}</td>
                <td class="py-3 px-6">{{ $submission->category->name ?? '-' }}</td>
                <td class="py-3 px-6 max-w-[200px] truncate">{{ $submission->title }}</td>
                <td class="py-3 px-6 text-[#434655]">{{ $submission->created_at->format('M d, Y') }}</td>
                <td class="py-3 px-6">
                  <span class="{{ $badgeBg }} px-2.5 py-0.5 rounded-full text-xs font-medium">
                    {{ $submission->status }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-6 px-6 text-center text-[#737686] font-normal">Belum ada pengajuan keluhan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
@endsection