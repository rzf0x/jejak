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
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-600 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">{{ $isEditMode ? 'Edit Target' : 'Buat Target Baru' }}</h1>
            <p class="text-white/60">
                {{ $isEditMode ? 'Perbarui target yang sudah ada' : 'Tentukan target income dan periode waktunya' }}
            </p>
        </div>

        <!-- Alert: Already has active target -->
        @if ($hasActiveTarget && !$isEditMode)
            <div class="mb-8 p-4 bg-yellow-500/20 border border-yellow-400/30 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="text-yellow-400 font-semibold">Target Aktif Sudah Ada</h3>
                        <p class="text-yellow-200/80 text-sm mt-1">Anda sudah memiliki target aktif. Selesaikan atau
                            batalkan target tersebut terlebih dahulu sebelum membuat target baru.</p>
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="inline-flex items-center gap-2 mt-3 text-sm font-medium text-yellow-400 hover:text-yellow-300 transition-colors">
                            <span>Lihat Target Aktif</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Flash Messages -->
        @if (session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-400/30 rounded-xl text-red-300 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-400/30 rounded-xl text-green-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
            <form wire:submit="save" class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-white/80 mb-2">
                        Nama Target <span class="text-white/40">(opsional)</span>
                    </label>
                    <input type="text" id="title" wire:model="title" placeholder="Contoh: Target Februari 2026"
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                        {{ $hasActiveTarget && !$isEditMode ? 'disabled' : '' }}>
                    @error('title')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-white/80 mb-2">
                            Tanggal Mulai <span class="text-red-400">*</span>
                        </label>
                        <input type="date" id="start_date" wire:model="start_date"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all [color-scheme:dark]"
                            {{ $hasActiveTarget && !$isEditMode ? 'disabled' : '' }}>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-white/80 mb-2">
                            Tanggal Selesai <span class="text-red-400">*</span>
                        </label>
                        <input type="date" id="end_date" wire:model="end_date"
                            class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all [color-scheme:dark]"
                            {{ $hasActiveTarget && !$isEditMode ? 'disabled' : '' }}>
                        @error('end_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Target Amount -->
                <div>
                    <label for="target_amount" class="block text-sm font-medium text-white/80 mb-2">
                        Target Income <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white/60 font-medium">Rp</span>
                        <input type="text" id="target_amount" wire:model="target_amount" placeholder="10.000.000"
                            class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            {{ $hasActiveTarget && !$isEditMode ? 'disabled' : '' }} x-data
                            x-on:input="
                                let value = $el.value.replace(/\D/g, '');
                                $el.value = new Intl.NumberFormat('id-ID').format(value);
                            ">
                    </div>
                    @error('target_amount')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-white/40">Masukkan jumlah target income yang ingin dicapai</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none shadow-xl shadow-slate-900/25"
                        {{ $hasActiveTarget && !$isEditMode ? 'disabled' : '' }} wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditMode ? 'Simpan Perubahan' : 'Buat Target' }}
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

        <!-- Tips -->
        <div class="mt-8 p-6 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl">
            <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                Tips Membuat Target
            </h3>
            <ul class="space-y-2 text-white/60 text-sm">
                <li class="flex items-start gap-2">
                    <span class="text-purple-400">•</span>
                    <span>Tetapkan target yang realistis berdasarkan kemampuan dan kondisi saat ini</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-400">•</span>
                    <span>Periode 1 bulan adalah waktu yang ideal untuk memulai</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-purple-400">•</span>
                    <span>Catat progress setiap hari untuk hasil tracking yang akurat</span>
                </li>
            </ul>
        </div>
    </main>
</div>
