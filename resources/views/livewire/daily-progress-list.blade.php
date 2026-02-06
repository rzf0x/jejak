<div class="min-h-screen bg-slate-800">
    <!-- Navigation -->
    <nav class="border-b border-white/10 bg-black/20 backdrop-blur-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-slate-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Jejak</span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden sm:inline">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">Riwayat Progress</h1>
                <p class="text-white/60">{{ $activeTarget?->title ?? 'Target Aktif' }}</p>
            </div>

            @if ($activeTarget)
                <div class="flex gap-2">
                    <button wire:click="exportCsv"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Export CSV</span>
                    </button>

                    <a href="{{ route('progress.create') }}" wire:navigate
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Progress</span>
                    </a>
                </div>
            @endif
        </div>

        @if ($activeTarget)
            <!-- Summary Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                    <p class="text-white/60 text-xs mb-1">Total Hari</p>
                    <p class="text-xl font-bold text-white">{{ $progressList->total() }}</p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                    <p class="text-white/60 text-xs mb-1">Total Income</p>
                    <p class="text-xl font-bold text-green-400">@rupiah($activeTarget->dailyProgress->sum('income'))</p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                    <p class="text-white/60 text-xs mb-1">Rata-rata/Hari</p>
                    <p class="text-xl font-bold text-purple-400">
                        @rupiah($progressList->total() > 0 ? $activeTarget->dailyProgress->sum('income') / $progressList->total() : 0)
                    </p>
                </div>
                <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                    <p class="text-white/60 text-xs mb-1">Income Tertinggi</p>
                    <p class="text-xl font-bold text-yellow-400">@rupiah($activeTarget->dailyProgress->max('income') ?? 0)</p>
                </div>
            </div>

            <!-- Progress List -->
            @if ($progressList->count() > 0)
                <div class="space-y-3">
                    @foreach ($progressList as $progress)
                        <div wire:click="showDetail({{ $progress->id }})"
                            class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4 hover:bg-white/10 transition-all duration-200 cursor-pointer group">
                            <div class="flex items-center gap-4">
                                <!-- Date -->
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 border border-white/10 rounded-xl flex flex-col items-center justify-center">
                                    <span
                                        class="text-2xl font-bold text-white">{{ $progress->date->format('d') }}</span>
                                    <span class="text-xs text-white/60">{{ $progress->date->format('M') }}</span>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-white/60 text-sm">{{ $progress->date->translatedFormat('l') }}</span>
                                        @if ($progress->date->isToday())
                                            <span
                                                class="px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">Hari
                                                ini</span>
                                        @endif
                                    </div>
                                    <p class="text-lg font-bold text-green-400 mb-1">
                                        @rupiah($progress->income)
                                    </p>
                                    @if ($progress->achievement)
                                        <p class="text-white/60 text-sm truncate">
                                            {{ Str::limit($progress->achievement, 60) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Arrow -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-white/40 group-hover:text-white/80 group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $progressList->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div
                    class="flex flex-col items-center justify-center py-16 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Belum Ada Progress</h3>
                    <p class="text-white/60 text-center mb-6 max-w-sm">Mulai catat progress harianmu untuk memantau
                        perkembangan target income.</p>
                    <a href="{{ route('progress.create') }}" wire:navigate
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tambah Progress Pertama</span>
                    </a>
                </div>
            @endif
        @else
            <!-- No Active Target -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Tidak Ada Target Aktif</h2>
                <p class="text-white/60 text-center mb-8 max-w-md">
                    Buat target terlebih dahulu untuk mulai mencatat progress.
                </p>
                <a href="{{ route('targets.create') }}" wire:navigate
                    class="inline-flex items-center gap-3 px-8 py-4 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-2xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Target Baru</span>
                </a>
            </div>
        @endif
    </main>

    <!-- Detail Modal -->
    @if ($showModal && $selectedProgress)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <!-- Modal -->
            <div class="flex min-h-full items-center justify-center p-4">
                <div
                    class="relative w-full max-w-lg bg-slate-900 border border-white/10 rounded-2xl shadow-2xl transform transition-all">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-6 border-b border-white/10">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Detail Progress</h3>
                            <p class="text-sm text-white/60">
                                {{ $selectedProgress->date->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <button wire:click="closeModal"
                            class="p-2 text-white/60 hover:text-white hover:bg-white/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-6">
                        <!-- Income -->
                        <div
                            class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-500/30 rounded-xl p-4">
                            <p class="text-green-400 text-sm mb-1">Income</p>
                            <p class="text-white">@rupiah($selectedProgress->income)</p>
                        </div>

                        <!-- Achievement -->
                        @if ($selectedProgress->achievement)
                            <div>
                                <h4 class="text-sm font-medium text-white/60 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    Pencapaian
                                </h4>
                                <p class="text-white/80 bg-white/5 rounded-lg p-3">
                                    {{ $selectedProgress->achievement }}</p>
                            </div>
                        @endif

                        <!-- Lesson Learned -->
                        @if ($selectedProgress->lesson_learned)
                            <div>
                                <h4 class="text-sm font-medium text-white/60 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    Pelajaran yang Didapat
                                </h4>
                                <p class="text-white/80 bg-white/5 rounded-lg p-3">
                                    {{ $selectedProgress->lesson_learned }}</p>
                            </div>
                        @endif

                        <!-- Improvement Plan -->
                        @if ($selectedProgress->improvement_plan)
                            <div>
                                <h4 class="text-sm font-medium text-white/60 mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    Rencana Perbaikan
                                </h4>
                                <p class="text-white/80 bg-white/5 rounded-lg p-3">
                                    {{ $selectedProgress->improvement_plan }}</p>
                            </div>
                        @endif

                        <!-- Empty reflection message -->
                        @if (!$selectedProgress->achievement && !$selectedProgress->lesson_learned && !$selectedProgress->improvement_plan)
                            <div class="text-center py-4">
                                <p class="text-white/40 text-sm">Tidak ada catatan refleksi untuk hari ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end gap-3 p-6 border-t border-white/10">
                        <button wire:click="deleteProgress({{ $selectedProgress->id }})"
                            wire:confirm="Apakah Anda yakin ingin menghapus progress ini?"
                            class="px-4 py-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                        <button wire:click="closeModal"
                            class="px-4 py-2 text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
