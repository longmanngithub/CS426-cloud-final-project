@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Dashboard Overview</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Welcome back, Admin. Here's what's happening today.</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md hover:-translate-y-1">
            <div class="h-16 w-16 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center shrink-0">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Users</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalUsers }}</h3>
            </div>
        </div>

        <!-- Total Organizers Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md hover:-translate-y-1">
            <div class="h-16 w-16 bg-purple-50 dark:bg-purple-900/30 rounded-2xl flex items-center justify-center shrink-0">
                <i class="fas fa-briefcase text-purple-600 text-2xl"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Organizers</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalOrganizers }}</h3>
            </div>
        </div>

        <!-- Total Events Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 flex items-center transition-all hover:shadow-md hover:-translate-y-1">
            <div class="h-16 w-16 bg-pink-50 dark:bg-pink-900/30 rounded-2xl flex items-center justify-center shrink-0">
                <i class="fas fa-calendar-alt text-pink-600 text-2xl"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total Events</p>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalEvents }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <!-- Registration Comparison -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Registration Trends</h2>
                <select id="regFilter" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2">
                    <option value="30days">Last 30 Days</option>
                    <option value="6months">Last 6 Months</option>
                    <option value="1year" selected>Last 1 Year</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>

        <!-- Monthly Event Posts -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Events Legend</h2>
                <select id="eventFilter" class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block p-2">
                    <option value="30days">Last 30 Days</option>
                    <option value="6months">Last 6 Months</option>
                    <option value="1year" selected>Last 1 Year</option>
                </select>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="eventsChart"></canvas>
            </div>
        </div>

        <!-- User Distribution -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 lg:col-span-2 flex flex-col items-center">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 self-start">User vs Organizer Distribution</h2>
            <div class="relative h-64 w-64">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.manage_users') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                <div class="h-10 w-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 mr-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-cog"></i>
                </div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Manage Users</span>
            </a>
            <a href="{{ route('admin.manage_organizers') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                <div class="h-10 w-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 mr-3 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-user-tie"></i>
                </div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Manage Organizers</span>
            </a>
            <a href="{{ route('admin.manage_events') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                <div class="h-10 w-10 bg-pink-100 dark:bg-pink-900/30 rounded-lg flex items-center justify-center text-pink-600 mr-3 group-hover:bg-pink-600 group-hover:text-white transition-colors">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Manage Events</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">New Users</h2>
                <a href="{{ route('admin.manage_users') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 font-bold text-xs">
                                        {{ substr($user->first_name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No recent users.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Events -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Events</h2>
                <a href="{{ route('admin.manage_events') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentEvents as $event)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center text-pink-600 text-xs">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">by {{ $event->organizer->first_name ?? 'Unknown' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300">
                                    Active
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No recent events.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fullData = {!! json_encode($chartData) !!};
        const isDark = document.documentElement.classList.contains('dark');

        function getChartColors() {
            const dark = document.documentElement.classList.contains('dark');
            return {
                textColor: dark ? '#e5e7eb' : '#374151',
                gridColor: dark ? 'rgba(75, 85, 99, 0.4)' : '#f0f0f0',
                legendColor: dark ? '#d1d5db' : '#374151',
                centerNumberColor: dark ? '#f9fafb' : '#111827',
                centerLabelColor: dark ? '#9ca3af' : '#6b7280'
            };
        }

        function buildCommonOptions() {
            const colors = getChartColors();
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { font: { family: 'Inter', size: 12 }, usePointStyle: true, padding: 20, color: colors.legendColor }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4], color: colors.gridColor }, ticks: { font: { family: 'Inter' }, color: colors.textColor } },
                    x: { grid: { display: false }, ticks: { font: { family: 'Inter' }, color: colors.textColor } }
                }
            };
        }

        // Helper to slice data based on filter
        function sliceData(dataObj, range) {
            const total = dataObj.labels.length;
            let sliceCount = total;

            if (range === '6months') sliceCount = 6;

            let source = dataObj;

            return {
                labels: source.labels.slice(-sliceCount),
                events: source.events ? source.events.slice(-sliceCount) : [],
                users: source.users ? source.users.slice(-sliceCount) : [],
                organizers: source.organizers ? source.organizers.slice(-sliceCount) : []
            };
        }

        // Plugin to draw text in center of doughnut
        const centerTextPlugin = {
            id: 'centerText',
            afterDraw: function(chart) {
                if (chart.config.type !== 'doughnut') return;

                const { ctx, chartArea: { top, bottom, left, right } } = chart;
                const centerX = (left + right) / 2;
                const centerY = (top + bottom) / 2;
                const colors = getChartColors();

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                // Draw Number
                ctx.font = 'bold 30px Inter, sans-serif';
                ctx.fillStyle = colors.centerNumberColor;
                ctx.fillText("{!! $userVsOrg['total'] !!}", centerX, centerY - 10);

                // Draw Label
                ctx.font = '500 12px Inter, sans-serif';
                ctx.fillStyle = colors.centerLabelColor;
                ctx.fillText('TOTAL', centerX, centerY + 15);

                ctx.restore();
            }
        };

        // --- 1. Registration Trends ---
        const regCtx = document.getElementById('registrationChart');
        let regChart = new Chart(regCtx, {
            type: 'line',
            data: {
                labels: fullData.monthly.labels,
                datasets: [
                    {
                        label: 'Users',
                        data: fullData.monthly.users,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Organizers',
                        data: fullData.monthly.organizers,
                        borderColor: '#9333ea',
                        backgroundColor: 'rgba(147, 51, 234, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: buildCommonOptions()
        });

        document.getElementById('regFilter').addEventListener('change', function(e) {
            const range = e.target.value;
            let sourceData = (range === '30days') ? fullData.daily : fullData.monthly;
            let sliced = sliceData(sourceData, range);

            regChart.data.labels = sliced.labels;
            regChart.data.datasets[0].data = sliced.users;
            regChart.data.datasets[1].data = sliced.organizers;
            regChart.update();
        });

        // --- 2. Monthly/Daily Events ---
        const eventCtx = document.getElementById('eventsChart');
        let eventChart = new Chart(eventCtx, {
            type: 'bar',
            data: {
                labels: fullData.monthly.labels,
                datasets: [{
                    label: 'Events Posted',
                    data: fullData.monthly.events,
                    backgroundColor: '#db2777',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: buildCommonOptions()
        });

        document.getElementById('eventFilter').addEventListener('change', function(e) {
            const range = e.target.value;
            let sourceData = (range === '30days') ? fullData.daily : fullData.monthly;
            let sliced = sliceData(sourceData, range);

            eventChart.data.labels = sliced.labels;
            eventChart.data.datasets[0].data = sliced.events;
            eventChart.update();
        });

        // --- 3. User Vs Organizer Chart ---
        const colors = getChartColors();
        let distChart = new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Users', 'Organizers'],
                datasets: [{
                    data: [{!! $userVsOrg['users'] !!}, {!! $userVsOrg['organizers'] !!}],
                    backgroundColor: ['#2563eb', '#9333ea'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 12 }, usePointStyle: true, padding: 20, color: colors.legendColor } }
                },
                cutout: '75%'
            },
            plugins: [centerTextPlugin]
        });

        // --- Update all charts when theme changes ---
        function updateChartsForTheme() {
            const colors = getChartColors();
            const opts = buildCommonOptions();

            // Update registration chart
            regChart.options.scales = opts.scales;
            regChart.options.plugins.legend.labels.color = colors.legendColor;
            regChart.update();

            // Update events chart
            eventChart.options.scales = opts.scales;
            eventChart.options.plugins.legend.labels.color = colors.legendColor;
            eventChart.update();

            // Update distribution chart
            distChart.options.plugins.legend.labels.color = colors.legendColor;
            distChart.update();
        }

        // Listen for theme changes via MutationObserver on <html> class
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    updateChartsForTheme();
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });
    });
</script>
@endpush
@endsection
