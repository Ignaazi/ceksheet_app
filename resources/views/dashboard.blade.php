<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Title & Subtitle -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Executive Operations Dashboard</h1>
            <p class="text-sm text-gray-500">Unified delivery, growth, and reliability signals for daily decision-making.</p>
        </div>

        <!-- 4 Metric Cards Top Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            <!-- Card 1: Net Revenue -->
            <div class="bg-emerald-50/60 border border-emerald-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-lg">
                        $
                    </div>
                </div>
                <span class="text-xs font-bold tracking-wider text-gray-500 uppercase">Net Revenue</span>
                <div class="text-2xl font-extrabold text-gray-800 mt-1">$94.2K</div>
                <div class="text-xs font-semibold text-emerald-600 mt-2 flex items-center gap-1">
                    <span>↗ 9.4%</span>
                </div>
            </div>

            <!-- Card 2: Qualified Leads -->
            <div class="bg-blue-50/60 border border-blue-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <span class="text-xs font-bold tracking-wider text-gray-500 uppercase">Qualified Leads</span>
                <div class="text-2xl font-extrabold text-gray-800 mt-1">1,284</div>
                <div class="text-xs font-semibold text-emerald-600 mt-2 flex items-center gap-1">
                    <span>↗ 6.1%</span>
                </div>
            </div>

            <!-- Card 3: Avg. Cycle Time -->
            <div class="bg-amber-50/60 border border-amber-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <span class="text-xs font-bold tracking-wider text-gray-500 uppercase">Avg. Cycle Time</span>
                <div class="text-2xl font-extrabold text-gray-800 mt-1">4.2d</div>
                <div class="text-xs font-semibold text-amber-600 mt-2 flex items-center gap-1">
                    <span>↘ 3.5%</span>
                </div>
            </div>

            <!-- Card 4: Retention -->
            <div class="bg-indigo-50/60 border border-indigo-100 p-5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <span class="text-xs font-bold tracking-wider text-gray-500 uppercase">Retention</span>
                <div class="text-2xl font-extrabold text-gray-800 mt-1">92.7%</div>
                <div class="text-xs font-semibold text-emerald-600 mt-2 flex items-center gap-1">
                    <span>↗ 1.8%</span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid (Chart + Recent Activity) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Performance Curve Chart (2 Columns) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Performance Curve</h3>
                    <div class="inline-flex rounded-lg bg-gray-100 p-1 text-xs font-semibold text-gray-600">
                        <button class="px-3 py-1 bg-indigo-600 text-white rounded-md shadow-sm">MONTH</button>
                        <button class="px-3 py-1 hover:text-gray-900">WEEK</button>
                        <button class="px-3 py-1 hover:text-gray-900">DAY</button>
                    </div>
                </div>

                <!-- Stats summary inside chart card -->
                <div class="grid grid-cols-3 gap-4 p-4 bg-gray-50/70 rounded-xl mb-6 border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Revenue</p>
                        <p class="text-lg font-bold text-gray-800">$94.2K</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Cost</p>
                        <p class="text-lg font-bold text-gray-800">$57.6K</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-bold uppercase">Margin</p>
                        <p class="text-lg font-bold text-gray-800">$36.6K</p>
                    </div>
                </div>

                <!-- Area tempat Grafik/Chart -->
                <div class="h-64 bg-gray-50 rounded-xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 text-sm">
                    <svg class="w-12 h-12 mb-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <span>Chart Area (Bisa dipasang ApexCharts / Chart.js di sini)</span>
                </div>
            </div>

            <!-- Right Side: Recent Activity (1 Column) -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 text-lg">Recent Activity</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:underline">View</a>
                </div>
                <p class="text-xs text-gray-400 mb-4">Last 2 hours</p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed"><strong class="text-gray-800">Alex Thompson</strong> completed purchase workflow update.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed"><strong class="text-gray-800">Sarah Wilson</strong> submitted dashboard UX revisions.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed">Storage usage crossed 80% on media bucket.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed">Deployment <span class="font-mono text-gray-800 font-semibold">v3.2.1</span> passed production checks.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed">New lead batch synced from CRM integrations.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 mt-1.5 shrink-0"></span>
                        <p class="text-xs text-gray-600 leading-relaxed">Billing retry required for invoice <strong class="text-gray-800">#INV-8043</strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>