<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 font-sans">
        
        <!-- Title & Subtitle -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h1 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">Executive Operations Dashboard</h1>
                <p class="text-xs font-bold text-slate-500">Unified delivery, growth, and reliability signals for daily decision-making.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-blue-50 border border-blue-900/30 text-blue-950 text-[11px] font-black shadow-[2px_2px_0px_0px_#1e3a8a]">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Metrics
                </span>
            </div>
        </div>

        <!-- 4 Metric Cards Top Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
            
            <!-- Card 1: Net Revenue -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#54e3be] to-[#29cc97] p-5 text-white border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a] transition-transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-white/90">Net Revenue</span>
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 text-white flex items-center justify-center font-black text-lg">
                        $
                    </div>
                </div>
                <div class="text-3xl font-black tracking-tight">$94.2K</div>
                <div class="text-xs font-extrabold mt-2 text-white/90 flex items-center gap-1">
                    <span>↗ 9.4%</span>
                    <span class="opacity-75 font-normal">vs last month</span>
                </div>
            </div>

            <!-- Card 2: Qualified Leads -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#52b1ff] to-[#268fff] p-5 text-white border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a] transition-transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-white/90">Qualified Leads</span>
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black tracking-tight">1,284</div>
                <div class="text-xs font-extrabold mt-2 text-white/90 flex items-center gap-1">
                    <span>↗ 6.1%</span>
                    <span class="opacity-75 font-normal">vs last month</span>
                </div>
            </div>

            <!-- Card 3: Avg. Cycle Time -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#ffb84d] to-[#f59e0b] p-5 text-white border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a] transition-transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-white/90">Avg. Cycle Time</span>
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black tracking-tight">4.2d</div>
                <div class="text-xs font-extrabold mt-2 text-white/90 flex items-center gap-1">
                    <span>↘ 3.5%</span>
                    <span class="opacity-75 font-normal">vs last month</span>
                </div>
            </div>

            <!-- Card 4: Retention -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#ff869a] to-[#ff6078] p-5 text-white border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a] transition-transform hover:-translate-y-0.5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-black uppercase tracking-wider text-white/90">Retention</span>
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/30 text-white flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black tracking-tight">92.7%</div>
                <div class="text-xs font-extrabold mt-2 text-white/90 flex items-center gap-1">
                    <span>↗ 1.8%</span>
                    <span class="opacity-75 font-normal">vs last month</span>
                </div>
            </div>

        </div>

        <!-- Main Content Grid (Chart + Recent Activity) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Side: Performance Curve Chart (2 Columns) -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a]">
                <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="font-black text-slate-800 dark:text-white text-base tracking-tight uppercase">Performance Curve</h3>
                    <div class="inline-flex rounded-xl bg-slate-100 dark:bg-slate-800 p-1 text-xs font-black text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                        <button class="px-3 py-1 bg-blue-900 text-white rounded-lg shadow-[2px_2px_0px_0px_#1e3a8a]">MONTH</button>
                        <button class="px-3 py-1 hover:text-slate-900 dark:hover:text-white transition-colors">WEEK</button>
                        <button class="px-3 py-1 hover:text-slate-900 dark:hover:text-white transition-colors">DAY</button>
                    </div>
                </div>

                <!-- Stats summary inside chart card -->
                <div class="grid grid-cols-3 gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl mb-6 border border-slate-200 dark:border-slate-800 text-center sm:text-left">
                    <div>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Revenue</p>
                        <p class="text-lg font-black text-slate-800 dark:text-white">$94.2K</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Cost</p>
                        <p class="text-lg font-black text-slate-800 dark:text-white">$57.6K</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-wider">Margin</p>
                        <p class="text-lg font-black text-emerald-600 dark:text-emerald-400">$36.6K</p>
                    </div>
                </div>

                <!-- Area tempat Grafik/Chart -->
                <div class="h-64 bg-slate-50 dark:bg-slate-800/30 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center text-slate-400 text-xs font-bold p-4 text-center">
                    <svg class="w-10 h-10 mb-2 text-blue-900 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                    <span>Chart Area (Bisa dipasang ApexCharts / Chart.js di sini)</span>
                </div>
            </div>

            <!-- Right Side: Recent Activity (1 Column) -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-blue-900/30 shadow-[3px_3px_0px_0px_#1e3a8a] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-1 pb-2 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="font-black text-slate-800 dark:text-white text-base tracking-tight uppercase">Recent Activity</h3>
                        <a href="#" class="text-xs font-black text-blue-900 dark:text-blue-400 hover:underline">View All</a>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 mb-4">Last 2 hours updates</p>

                    <div class="space-y-3.5">
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1 shrink-0 ring-4 ring-emerald-50 dark:ring-emerald-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed"><strong class="text-slate-800 dark:text-white font-black">Alex Thompson</strong> completed purchase workflow update.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mt-1 shrink-0 ring-4 ring-blue-50 dark:ring-blue-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed"><strong class="text-slate-800 dark:text-white font-black">Sarah Wilson</strong> submitted dashboard UX revisions.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 mt-1 shrink-0 ring-4 ring-amber-50 dark:ring-amber-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed">Storage usage crossed <span class="text-amber-600 dark:text-amber-400 font-black">80%</span> on media bucket.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 mt-1 shrink-0 ring-4 ring-indigo-50 dark:ring-indigo-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed">Deployment <span class="font-mono text-slate-800 dark:text-white font-black px-1.5 py-0.5 bg-slate-100 dark:bg-slate-800 rounded">v3.2.1</span> passed production checks.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1 shrink-0 ring-4 ring-emerald-50 dark:ring-emerald-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed">New lead batch synced from CRM integrations.</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 mt-1 shrink-0 ring-4 ring-rose-50 dark:ring-rose-950"></span>
                            <p class="text-xs text-slate-600 dark:text-slate-300 font-bold leading-relaxed">Billing retry required for invoice <strong class="text-slate-800 dark:text-white font-black">#INV-8043</strong>.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-3 border-t border-slate-100 dark:border-slate-800 text-[10px] font-bold text-slate-400 text-center">
                    Auto-refreshed 1 min ago
                </div>
            </div>

        </div>
    </div>
</x-app-layout>