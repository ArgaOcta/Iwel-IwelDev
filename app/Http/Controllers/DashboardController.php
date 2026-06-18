<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Mencegah double redirect
        if ($user->role === 'superadmin' || $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $totalComplaints = Complaint::where('user_id', $user->id)->count();
        $pendingComplaints = Complaint::where('user_id', $user->id)->whereIn('status', ['Pending', 'Reviewing'])->count();
        $inProgressComplaints = Complaint::where('user_id', $user->id)->where('status', 'In Progress')->count();
        $resolvedComplaints = Complaint::where('user_id', $user->id)->whereIn('status', ['Resolved', 'Closed'])->count();

        $recentActivities = Complaint::where('user_id', $user->id)->orderBy('updated_at', 'desc')->take(3)->get();
        $recentSubmissions = Complaint::with('category')->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M'); 
            $chartData[] = Complaint::where('user_id', $user->id)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return view('mahasiswa.dashboard', compact(
            'totalComplaints', 'pendingComplaints', 'inProgressComplaints', 'resolvedComplaints',
            'recentActivities', 'recentSubmissions', 'chartLabels', 'chartData'
        ));
    }

    public function notifications(Request $request)
    {
        $user = $request->user();
        $notifications = \App\Models\AuditLog::with(['complaint', 'user'])
            ->whereHas('complaint', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.notification', compact('notifications'));
    }
}