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
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($activeTarget)
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-600 rounded-2xl mb-4">
                    @if ($isEditMode)
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    @endif
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    {{ $isEditMode ? 'Edit Progress Hari Ini' : 'Tambah Progress Hari Ini' }}
                </h1>
                <p class="text-white/60">{{ $activeTarget->title ?? 'Target Aktif' }}</p>
            </div>

            <!-- Date Badge -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span
                        class="text-white font-medium">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-500/20 border border-red-400/30 rounded-xl text-red-300 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Edit Mode Banner -->
            @if ($isEditMode)
                <div class="mb-6 p-4 bg-yellow-500/20 border border-yellow-400/30 rounded-xl">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-yellow-200 text-sm">Anda sudah memiliki progress untuk hari ini. Form ini akan
                            memperbarui data yang sudah ada.</p>
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
                <form wire:submit="save" class="space-y-6">
                    <!-- Income -->
                    <div>
                        <label for="income" class="block text-sm font-medium text-white/80 mb-2">
                            Income Hari Ini <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 font-medium">Rp</span>
                            <input type="text" id="income" wire:model="income" placeholder="0"
                                class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-lg font-semibold"
                                x-data
                                x-on:input="
                                    let value = $el.value.replace(/\D/g, '');
                                    $el.value = new Intl.NumberFormat('id-ID').format(value);
                                ">
                        </div>
                        @error('income')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-white/40">Masukkan total income yang diperoleh hari ini</p>
                    </div>

                    <!-- Achievement -->
                    <div>
                        <label for="achievement" class="block text-sm font-medium text-white/80 mb-2">
                            Pencapaian Hari Ini
                            <span class="text-white/40 font-normal">(opsional)</span>
                        </label>
                        <textarea id="achievement" wire:model="achievement" rows="3" placeholder="Apa yang berhasil kamu capai hari ini?"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none"></textarea>
                        @error('achievement')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lesson Learned -->
                    <div>
                        <label for="lesson_learned" class="block text-sm font-medium text-white/80 mb-2">
                            Pelajaran yang Didapat
                            <span class="text-white/40 font-normal">(opsional)</span>
                        </label>
                        <textarea id="lesson_learned" wire:model="lesson_learned" rows="3"
                            placeholder="Apa pelajaran berharga yang kamu dapat hari ini?"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none"></textarea>
                        @error('lesson_learned')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Improvement Plan -->
                    <div>
                        <label for="improvement_plan" class="block text-sm font-medium text-white/80 mb-2">
                            Rencana Perbaikan
                            <span class="text-white/40 font-normal">(opsional)</span>
                        </label>
                        <textarea id="improvement_plan" wire:model="improvement_plan" rows="3"
                            placeholder="Apa yang akan kamu perbaiki untuk besok?"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none"></textarea>
                        @error('improvement_plan')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-xl"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed transform-none">
                            <span wire:loading.remove wire:target="save">
                                {{ $isEditMode ? 'Perbarui Progress' : 'Simpan Progress' }}
                            </span>
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Stats -->
            @if ($activeTarget)
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                        <p class="text-white/60 text-sm mb-1">Target Income</p>
                        <p class="text-white font-bold">@rupiah($activeTarget->target_amount)</p>
                    </div>
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-xl p-4">
                        <p class="text-white/60 text-sm mb-1">Progress Tercatat</p>
                        <p class="text-white font-bold">{{ $activeTarget->dailyProgress()->count() }} hari</p>
                    </div>
                </div>
            @endif

            <!-- Motivation Quote -->
            <div class="mt-8 p-6 bg-slate-600/30 border border-white/10 rounded-2xl text-center">
                <p class="text-white/80 italic">"Konsistensi adalah kunci. Satu langkah kecil setiap hari akan
                    membawamu jauh."</p>
            </div>
        @else
            <!-- No Active Target State -->
            <div class="flex flex-col items-center justify-center py-20">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Tidak Ada Target Aktif</h2>
                <p class="text-white/60 text-center mb-8 max-w-md">
                    Anda perlu membuat target terlebih dahulu sebelum dapat mencatat progress harian.
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
