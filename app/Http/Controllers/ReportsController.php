<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index()
    {
        // ── KPI Cards ──
        $totalTasks      = Task::count();
        $completedTasks  = Task::where('status', 'completed')->count();
        $taskRate        = $totalTasks > 0 ? round($completedTasks / $totalTasks * 100) : 0;

        $totalProjects     = Project::count();
        $completedProjects = Project::where('status', 'completed')->count();
        $projectRate       = $totalProjects > 0 ? round($completedProjects / $totalProjects * 100) : 0;

        $totalUsers  = User::count();
        $activeUsers = User::where('last_active_at', '>=', now()->subDays(30))->count();
        $teamRate    = $totalUsers > 0 ? round($activeUsers / $totalUsers * 100) : 0;

        // ── Bar Chart: Task Completion Time vs Deadline (آخر 12 شهر) ──
        $months = collect(range(11, 0))->map(fn($i) => Carbon::now()->subMonths($i));

        $barLabels       = $months->map(fn($m) => $m->format('M'))->values();
        $avgActualTime   = $months->map(fn($m) =>
            Task::whereMonth('completed_at', $m->month)
                ->whereYear('completed_at', $m->year)
                ->avg('actual_hours') ?? 0
        )->values();
        $avgDeadlineTime = $months->map(fn($m) =>
            Task::whereMonth('deadline', $m->month)
                ->whereYear('deadline', $m->year)
                ->avg('estimated_hours') ?? 0
        )->values();

        // ── Area Chart: Projects Progress (آخر 12 شهر) ──
        $progressData = $months->map(fn($m) =>
            Project::whereMonth('updated_at', $m->month)
                   ->whereYear('updated_at', $m->year)
                   ->avg('progress') ?? 0
        )->values();

        // ── Line Chart: Worker Activity Rate ──
        $activityData = $months->map(fn($m) =>
            User::whereMonth('last_active_at', $m->month)
                ->whereYear('last_active_at', $m->year)
                ->count()
        )->values();

        return view('reports.index', compact(
            'taskRate', 'projectRate', 'teamRate',
            'barLabels', 'avgActualTime', 'avgDeadlineTime',
            'progressData', 'activityData'
        ));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'note'        => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        // هنا تضيف logic الـ report generation
        return back()->with('success', 'Report submitted successfully.');
    }
}