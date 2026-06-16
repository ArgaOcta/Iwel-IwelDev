<x-app-layout>
    <div class="py-8 px-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded shadow">
                <h3 class="font-semibold">Total Complaints</h3>
                <p class="text-3xl font-bold">{{ $totalComplaints }}</p>
            </div>

            <div class="bg-yellow-100 p-5 rounded shadow">
                <h3 class="font-semibold">Pending</h3>
                <p class="text-3xl font-bold">{{ $pendingComplaints }}</p>
            </div>

            <div class="bg-blue-100 p-5 rounded shadow">
                <h3 class="font-semibold">In Progress</h3>
                <p class="text-3xl font-bold">{{ $inProgressComplaints }}</p>
            </div>

            <div class="bg-green-100 p-5 rounded shadow">
                <h3 class="font-semibold">Resolved</h3>
                <p class="text-3xl font-bold">{{ $resolvedComplaints }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow mb-8">
            <h2 class="text-xl font-bold mb-4">Complaint Trends</h2>
            <canvas id="complaintChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">Recent Complaints</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead>
                        <tr>
                            <th class="pb-3">Ticket</th>
                            <th class="pb-3">Student</th>
                            <th class="pb-3">Category</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentComplaints as $complaint)
                            <tr class="border-t">
                                <td class="py-3">{{ $complaint->ticket_no }}</td>
                                <td class="py-3">{{ $complaint->user->name }}</td>
                                <td class="py-3">{{ $complaint->category->name }}</td>
                                <td class="py-3">{{ $complaint->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('complaintChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Complaints',
                    data: @json($chartData),
                }],
            },
        });
    </script>
</x-app-layout>