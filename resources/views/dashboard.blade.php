<x-app-layout>
    <div class="w-full bg-transparent p-6 font-sans">
        
        <!-- Title & Subtitle -->
        <div class="mb-6">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Engineering 1</h1>
            <p class="text-xs font-bold text-slate-500">portal record actiivty engineering production1</p>
        </div>

        <!-- 4 Metric Cards Grid - Kotak Ujung Melengkung Dikit + Shadow Biru Tua -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: Merah / Pink -->
            <div class="relative rounded-lg bg-gradient-to-r from-[#ff6b81] to-[#ff4757] h-32 transition-transform hover:-translate-y-1 shadow-[2px_3px_0px_0px_#1e3a8a]">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="absolute -right-2 -top-2 w-20 h-20 rounded-full bg-white/10 pointer-events-none"></div>
            </div>

            <!-- Card 2: Biru Muda -->
            <div class="relative rounded-lg bg-gradient-to-r from-[#38bdf8] to-[#0ea5e9] h-32 transition-transform hover:-translate-y-1 shadow-[2px_3px_0px_0px_#1e3a8a]">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="absolute -right-2 -top-2 w-20 h-20 rounded-full bg-white/10 pointer-events-none"></div>
            </div>

            <!-- Card 3: Biru Tua -->
            <div class="relative rounded-lg bg-gradient-to-r from-[#2563eb] to-[#1d4ed8] h-32 transition-transform hover:-translate-y-1 shadow-[2px_3px_0px_0px_#1e3a8a]">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="absolute -right-2 -top-2 w-20 h-20 rounded-full bg-white/10 pointer-events-none"></div>
            </div>

            <!-- Card 4: Ungu -->
            <div class="relative rounded-lg bg-gradient-to-r from-[#a855f7] to-[#8b5cf6] h-32 transition-transform hover:-translate-y-1 shadow-[2px_3px_0px_0px_#1e3a8a]">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 pointer-events-none"></div>
                <div class="absolute -right-2 -top-2 w-20 h-20 rounded-full bg-white/10 pointer-events-none"></div>
            </div>

        </div>

    </div>
</x-app-layout>