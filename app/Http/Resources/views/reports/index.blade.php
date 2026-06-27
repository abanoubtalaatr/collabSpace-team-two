@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    {{-- ── KPI Cards ── --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Task Completion Rate</p>
            <h2 class="text-4xl font-bold mt-1">{{ $taskRate }} %</h2>
            <p class="text-green-500 text-sm mt-1">+3% From last month</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Projects Completion Rate</p>
            <h2 class="text-4xl font-bold mt-1">{{ $projectRate }} %</h2>
            <p class="text-green-500 text-sm mt-1">+6% From last month</p>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <p class="text-sm text-gray-500">Teams Activity Rate</p>
            <h2 class="text-4xl font-bold mt-1">{{ $teamRate }} %</h2>
            <p class="text-red-400 text-sm mt-1">-4% From last month</p>
        </div>
    </div>

    {{-- ── Charts Row ── --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- Bar Chart --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <h3 class="font-semibold mb-4">Task Completion Time vs Deadline</h3>
            <canvas id="barChart" height="200"></canvas>
        </div>

        {{-- Area Chart --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Projects Progress</h3>
                <select class="text-sm border rounded px-2 py-1">
                    <option>All Projects</option>
                </select>
            </div>
            <canvas id="areaChart" height="200"></canvas>
        </div>
    </div>

    {{-- ── Bottom Row ── --}}
    <div class="grid grid-cols-2 gap-4">

        {{-- Line Chart --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Worker Activity Rate</h3>
                <select class="text-sm border rounded px-2 py-1">
                    <option>Monthly</option>
                </select>
            </div>
            <canvas id="lineChart" height="200"></canvas>
        </div>

        {{-- Submit Report Form --}}
        <div class="bg-white rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Submit a detailed report</h3>
                <span class="text-blue-500 cursor-pointer text-lg">✦</span>
            </div>

            @if(session('success'))
                <div class="text-green-600 text-sm mb-3">{{ session('success') }}</div>
            @endif

            <form action="{{ route('reports.submit') }}" method="POST" class="space-y-3">
                @csrf
                <select name="report_type"
                    class="w-full border rounded-lg px-3 py-2 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400">
                    <option value="" disabled selected>Select Report Type</option>
                    <option value="project">Project Report</option>
                    <option value="task">Task Report</option>
                    <option value="team">Team Report</option>
                    <option value="user">User Report</option>
                </select>

                <input type="text" name="note" placeholder="Add Note"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-400" />

                <div class="grid grid-cols-2 gap-3">
                    <input type="date" name="start_date"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400" />
                    <input type="date" name="end_date"
                        class="w-full border rounded-lg px-3 py-2 text-sm text-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400" />
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($barLabels);

// Bar Chart
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Actual Time',
            data: @json($avgActualTime),
            backgroundColor: '#3b82f6',
            borderRadius: 4,
        }, {
            label: 'Deadline',
            data: @json($avgDeadlineTime),
            backgroundColor: '#93c5fd',
            borderRadius: 4,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// Area Chart
new Chart(document.getElementById('areaChart'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            data: @json($progressData),
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,0.15)',
            fill: true,
            tension: 0.4,
            pointRadius: 0,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { min: 0, max: 100 } } }
});

// Line Chart
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            data: @json($activityData),
            borderColor: '#3b82f6',
            backgroundColor: 'transparent',
            tension: 0.4,
            pointRadius: 0,
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection