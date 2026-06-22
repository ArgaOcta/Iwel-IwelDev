@extends('layouts.mahasiswa')
@section('title', 'Dashboard - SCMS')

@section('content')
<div class="p-4 sm:p-6 pb-14 w-full h-full min-h-screen">
  
  @if (session('success'))
      <div class="w-full bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
          <span class="block sm:inline font-medium">{{ session('success') }}</span>
      </div>
  @endif

  <div class="grid gap-4 sm:gap-6 grid-cols-12 w-full">
    
    {{-- Hero Card Beradaptasi (Responsive) --}}
    <div class="rounded-xl p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center justify-between h-auto sm:h-[120px] overflow-hidden col-span-12 relative shadow-[0_4px_20px_rgba(0,0,0,0.04)] animate-fade-up transition-transform duration-500 hover:scale-[1.01] group" style="background: linear-gradient(90deg, rgba(0, 74, 198, 1) 0%, rgba(180, 197, 255, 1) 100%);">
      <svg class="absolute right-[-50px] top-[-50px] opacity-10" width="184" height="150" viewBox="0 0 184 150" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M91.6667 150L33.3333 118.333V68.3333L0 50L91.6667 0L183.333 50V116.667H166.667V59.1667L150 68.3333V118.333L91.6667 150ZM91.6667 80.8333L148.75 50L91.6667 19.1667L34.5833 50L91.6667 80.8333ZM91.6667 131.042L133.333 108.542V77.0833L91.6667 100L50 77.0833V108.542L91.6667 131.042Z" fill="white"/></svg>
      <div class="flex flex-col gap-1 sm:gap-2 z-10 w-full sm:w-auto">
        <div class="text-[#ffffff] font-['Manrope-Bold',_sans-serif] text-2xl sm:text-[32px] sm:leading-10 font-bold tracking-[-0.64px]">Student Dashboard</div>
        <div class="text-[#ffffff] font-['Manrope-Regular',_sans-serif] text-sm sm:text-base sm:leading-6 opacity-90">Track your academic concerns and administrative requests.</div>
      </div>
      <a href="{{ route('complaint.create') }}" class="mt-5 sm:mt-0 bg-[#ffffff] rounded-lg py-3 px-6 flex items-center justify-center gap-2 hover:bg-gray-50 transition-all-300 shadow-sm hover:shadow-md hover:-translate-y-1 active:scale-95 z-10 w-full sm:w-auto">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M9 15H11V11H15V9H11V5H9V9H5V11H9V15ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="#004AC6"/></svg>
        <span class="text-[#004ac6] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold">New Complaint</span>
      </a>
    </div>

    {{-- Kotak Angka Merenggang Sesuai Layar (1 => 2 => 4 Kolom) --}}
    @foreach ([
        ['Total', $totalComplaints, '#dbe1ff', '#004AC6', 'delay-100'],
        ['Pending', $pendingComplaints, '#ffdbcd', '#943700', 'delay-200'],
        ['In Progress', $inProgressComplaints, '#d3e4fe', '#38485D', 'delay-300'],
        ['Resolved', $resolvedComplaints, '#e7e7f3', '#434655', 'delay-400']
    ] as $card)
    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-5 col-span-12 sm:col-span-6 xl:col-span-3 shadow-[0_4px_20px_rgba(0,0,0,0.04)] animate-fade-up {{ $card[4] }} transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-default group">
      <div class="flex justify-between">
        <div class="flex flex-col gap-1">
          <div class="text-[#434655] font-['Manrope-SemiBold',_sans-serif] text-[13px] font-semibold tracking-[0.65px]">{{ $card[0] }}</div>
          <div class="text-[#191b23] text-2xl font-semibold transition-colors group-hover:text-[#004ac6]">{{ $card[1] }}</div>
        </div>
        <div class="rounded-full w-10 h-10 flex items-center justify-center transition-transform group-hover:scale-110 shrink-0" style="background-color: {{ $card[2] }}">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $card[3] }}" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        </div>
      </div>
    </div>
    @endforeach

    {{-- Grafik --}}
    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-4 sm:p-6 col-span-12 lg:col-span-8 shadow-[0_4px_20px_rgba(0,0,0,0.04)] min-h-[400px] flex flex-col animate-fade-up delay-200 transition-shadow hover:shadow-md w-full">
      <div class="border-b border-[rgba(195,198,215,0.50)] pb-2 mb-4">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Submission Activity</h3>
      </div>
      <div class="flex-1 relative w-full h-full min-h-[300px]">
        <canvas id="submissionChart"></canvas>
      </div>
    </div>

    {{-- Notifikasi --}}
    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] p-4 sm:p-6 col-span-12 lg:col-span-4 shadow-[0_4px_20px_rgba(0,0,0,0.04)] animate-fade-up delay-300 transition-shadow hover:shadow-md w-full">
      <div class="border-b border-[rgba(195,198,215,0.50)] pb-2 mb-6">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold">Recent Activity</h3>
      </div>
      <div class="pl-2 sm:pl-3 overflow-y-auto max-h-[300px]">
        <div class="border-l-2 border-[rgba(195,198,215,0.30)] flex flex-col gap-6">
          @forelse ($recentActivities as $activity)
            <div class="pl-5 sm:pl-6 flex flex-col gap-1 relative group">
              <div class="text-[#434655] text-[13px] font-semibold">{{ $activity->updated_at->diffForHumans() }}</div>
              <div class="text-[#191b23] text-base font-medium group-hover:text-[#004ac6] transition-colors">Complaint #{{ $activity->ticket_no }}</div>
              <div class="text-[#505f76] text-sm">Status updated to '{{ $activity->status }}'.</div>
              <div class="bg-[#004ac6] rounded-full border-2 border-white w-4 h-4 absolute left-[-9px] top-1 group-hover:scale-125 transition-transform"></div>
            </div>
          @empty
            <div class="pl-6 text-[#505f76] text-sm italic">Belum ada aktivitas.</div>
          @endforelse
        </div>
      </div>
    </div>

    {{-- Tabel (Sekarang bisa digeser ke kanan/kiri jika layar terlalu sempit) --}}
    <div class="bg-white rounded-xl border border-[rgba(195,198,215,0.30)] col-span-12 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.04)] animate-fade-up delay-400 w-full">
      <div class="border-b border-[rgba(195,198,215,0.50)] p-4 sm:p-6 flex justify-between items-center">
        <h3 class="text-[#191b23] font-['Manrope-SemiBold',_sans-serif] text-lg font-semibold transition-transform hover:translate-x-1">Recent Submissions</h3>
        <a href="{{ route('complaint.history') }}" class="text-[#004ac6] text-[13px] font-semibold hover:underline flex items-center gap-1 transition-all group shrink-0">
            View All
            <svg class="group-hover:translate-x-1 transition-transform" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[600px]">
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
              <tr class="border-b border-[rgba(195,198,215,0.20)] hover:bg-gray-50 transition-all duration-200 group">
                <td class="py-4 px-6 transition-transform group-hover:translate-x-1">#{{ $submission->ticket_no }}</td>
                <td class="py-4 px-6">{{ $submission->category->name ?? '-' }}</td>
                <td class="py-4 px-6 max-w-[200px] truncate" title="{{ $submission->title }}">{{ $submission->title }}</td>
                <td class="py-4 px-6 text-[#434655]">{{ $submission->created_at->format('M d, Y') }}</td>
                <td class="py-4 px-6">
                  <span class="{{ $badgeBg }} px-2.5 py-1 rounded-full text-xs font-semibold group-hover:px-4 transition-all">
                    {{ $submission->status }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-12 px-6 text-center text-[#737686] font-normal">Belum ada pengajuan keluhan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      const ctxElem = document.getElementById('submissionChart');
      if (ctxElem) {
          const ctx = ctxElem.getContext('2d');
          
          // Membuat efek gradasi warna yang elegan di bawah garis grafik
          const gradient = ctx.createLinearGradient(0, 0, 0, 300);
          gradient.addColorStop(0, 'rgba(0, 74, 198, 0.2)');
          gradient.addColorStop(1, 'rgba(0, 74, 198, 0)');

          new Chart(ctx, {
              type: 'line',
              data: {
                  // Menerima data dinamis dari DashboardController
                  labels: {!! json_encode($chartLabels ?? []) !!},
                  datasets: [{
                      label: 'Total Pengaduan',
                      data: {!! json_encode($chartData ?? []) !!},
                      borderColor: '#004ac6',
                      borderWidth: 3,
                      backgroundColor: gradient,
                      fill: true,
                      tension: 0.4, // Membuat garisnya melengkung (smooth)
                      pointBackgroundColor: '#004ac6',
                      pointHoverRadius: 6
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
      }
  });
</script>
@endsection