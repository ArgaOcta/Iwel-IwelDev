<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalComplaints = Complaint::count();

        $pendingComplaints = Complaint::whereIn(
            'status',
            ['Pending', 'Reviewing']
        )->count();

        $inProgressComplaints = Complaint::where(
            'status',
            'In Progress'
        )->count();

        $resolvedComplaints = Complaint::whereIn(
            'status',
            ['Resolved', 'Closed']
        )->count();

        $recentComplaints = Complaint::with([
            'user',
            'category'
        ])
        ->latest()
        ->take(5)
        ->get();

        $recentActivities = AuditLog::with([
            'user',
            'complaint'
        ])
        ->latest('created_at')
        ->take(5)
        ->get();

        $chartLabels = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = Carbon::now()->subMonths($i);

            $chartLabels[] = $month->format('M');

            $chartData[] = Complaint::whereMonth(
                'created_at',
                $month->month
            )
            ->whereYear(
                'created_at',
                $month->year
            )
            ->count();
        }

        return view(
            'admin.dashboard',
            compact(
                'totalComplaints',
                'pendingComplaints',
                'inProgressComplaints',
                'resolvedComplaints',
                'recentComplaints',
                'recentActivities',
                'chartLabels',
                'chartData'
            )
        );
    }

    public function complaints(Request $request)
    {
        $query = Complaint::with([
            'user',
            'category'
        ]);

        // Filter 1: Search berdasarkan tiket atau judul
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_no', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        // Filter 2: Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'All') {
            $query->where('status', $request->status);
        }

        // Sorting
        if ($request->get('sort') === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc'); // Default terbaru
        }

        $complaints = $query->paginate(10)->withQueryString();

        return view(
            'admin.complaints',
            compact('complaints')
        );
    }

    public function show($id)
    {
        $complaint = Complaint::with([
            'user',
            'category',
            'attachments',
            'auditLogs'
        ])->findOrFail($id);

        return view(
            'admin.show',
            compact('complaint')
        );
    }

    public function update($id)
    {
        $complaint = Complaint::findOrFail($id);

        request()->validate([
            'status' => 'required|in:Pending,Reviewing,In Progress,Resolved,Rejected,Closed'
        ]);

        $oldStatus = $complaint->status;
        $newStatus = request('status');

        if ($oldStatus !== $newStatus) {
            $complaint->update(['status' => $newStatus]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'complaint_id' => $complaint->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
            ]);
        }

        return redirect()->route('admin.show', $complaint->id)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}