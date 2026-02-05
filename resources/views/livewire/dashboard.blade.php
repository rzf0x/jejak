<div class="min-h-screen bg-slate-800">
    <!-- Navigation -->
    <nav class="border-b border-white/10 bg-black/20 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Jejak</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- User Info -->
                    <div class="flex items-center gap-3">
                        @if (auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                class="w-10 h-10 rounded-full ring-2 ring-purple-500/50">
                        @else
                            <div
                                class="w-10 h-10 rounded-full bg-slate-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/60">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($activeTarget)
            <!-- Welcome Header -->
            <div class="mb-8">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">
                        {{ $activeTarget->title ?? 'Target Aktif' }}
                    </h1>
                    <a href="{{ route('targets.edit', $activeTarget) }}" wire:navigate
                        class="p-2 text-white/50 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-colors"
                        title="Edit Target">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </a>
                </div>
                <p class="text-white/60">
                    {{ $activeTarget->start_date->format('d M Y') }} - {{ $activeTarget->end_date->format('d M Y') }}
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card: Target Income -->
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <span class="text-xs text-white/40 bg-white/10 px-2 py-1 rounded-full">Target</span>
                    </div>
                    <p class="text-white/60 text-sm mb-1">Target Income</p>
                    <p class="text-2xl font-bold text-white">@rupiah($activeTarget->target_amount)</p>
                </div>

                <!-- Card: Total Income Saat Ini -->
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs text-green-400 bg-green-500/20 px-2 py-1 rounded-full">Tercapai</span>
                    </div>
                    <p class="text-white/60 text-sm mb-1">Total Income</p>
                    <p class="text-2xl font-bold text-green-400">@rupiah($totalIncome)</p>
                </div>

                <!-- Card: Sisa Target -->
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-xs text-orange-400 bg-orange-500/20 px-2 py-1 rounded-full">Sisa</span>
                    </div>
                    <p class="text-white/60 text-sm mb-1">Sisa Target</p>
                    <p class="text-2xl font-bold text-orange-400">@rupiah($remainingTarget)
                    </p>
                </div>

                <!-- Card: Sisa Hari -->
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span
                            class="text-xs text-purple-400 bg-purple-500/20 px-2 py-1 rounded-full">{{ $totalDays }}
                            hari total</span>
                    </div>
                    <p class="text-white/60 text-sm mb-1">Sisa Hari</p>
                    <p class="text-2xl font-bold text-purple-400">{{ $remainingDays }} <span
                            class="text-lg font-normal">hari</span></p>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-white">Progress Target</h2>
                    <span
                        class="text-2xl font-bold {{ $progressPercentage >= 100 ? 'text-green-400' : ($progressPercentage >= 50 ? 'text-yellow-400' : 'text-white') }}">
                        {{ $progressPercentage }}%
                    </span>
                </div>

                <!-- Progress Bar -->
                <div class="relative h-4 bg-white/10 rounded-full overflow-hidden mb-4">
                    <div class="absolute inset-0 bg-slate-500 rounded-full transition-all duration-500 ease-out"
                        style="width: {{ min(100, $progressPercentage) }}%">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 animate-pulse">
                    </div>
                </div>

                <!-- Progress Info -->
                <div class="flex items-center justify-between text-sm">
                    <span class="text-white/60">
                        @rupiah($totalIncome) dari @rupiah($activeTarget->target_amount)
                    </span>
                    @if ($remainingDays > 0 && $remainingTarget > 0)
                        <span class="text-white/60">
                            ≈ @rupiah(ceil($remainingTarget / $remainingDays))/hari
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('progress.create') }}" wire:navigate
                    class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl shadow-slate-900/25">
                    <svg class="w-6 h-6 transition-transform group-hover:rotate-90" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Progress Hari Ini</span>
                </a>
                <a href="{{ route('progress.index') }}" wire:navigate
                    class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold rounded-2xl transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span>Lihat Riwayat</span>
                </a>
            </div>
        @else
            <!-- Empty State - No Active Target -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Target Aktif</h2>
                <p class="text-white/60 text-center mb-8 max-w-md">
                    Mulai perjalananmu dengan membuat target income pertama. Tetapkan tujuan dan pantau progressnya
                    setiap hari.
                </p>
                <a href="{{ route('targets.create') }}" wire:navigate
                    class="inline-flex items-center gap-3 px-8 py-4 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-xl shadow-slate-900/25">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Target Baru</span>
                </a>
            </div>
        @endif
    </main>
</div>
