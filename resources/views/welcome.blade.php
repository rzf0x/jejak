<x-layouts.app title="Jejak - Mulai Perjalananmu">
    <div class="min-h-screen bg-slate-800 flex flex-col">
        <!-- Navigation -->
        <nav class="border-b border-white/10 bg-black/20 backdrop-blur-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-14 bg-slate-600 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">Jejak</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-slate-600 rounded-xl hover:bg-slate-500 transition-all duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-slate-600 rounded-xl hover:bg-slate-500 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                            Mulai <span class="text-slate-400">Perjalananmu</span>
                            <br>Bersama Kami
                        </h1>
                        <p class="text-lg md:text-xl text-white/70 mb-8 max-w-xl mx-auto lg:mx-0">
                            Jejak adalah platform yang membantu Anda mencapai tujuan dengan cara yang lebih terorganisir
                            dan efisien.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            @guest
                                <a href="{{ route('login') }}" wire:navigate
                                    class="inline-flex items-center justify-center gap-2 px-8 py-4 text-lg font-semibold text-white bg-slate-600 rounded-2xl hover:bg-slate-500 transition-all duration-200 transform hover:scale-105 shadow-xl shadow-slate-900/25">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                                        <path fill="#fff"
                                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                        <path fill="#fff"
                                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                        <path fill="#fff"
                                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                        <path fill="#fff"
                                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                    </svg>
                                    Masuk dengan Google
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" wire:navigate
                                    class="inline-flex items-center justify-center gap-2 px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-xl shadow-purple-500/25">
                                    Ke Dashboard
                                </a>
                            @endguest
                        </div>
                    </div>

                    <!-- Illustration -->
                    <div class="hidden lg:flex justify-center">
                        <div class="relative">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur-2xl opacity-30">
                            </div>
                            <div class="relative bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8">
                                <div class="grid grid-cols-2 gap-4">
                                    <div
                                        class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-2xl p-6 border border-white/10">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-600 rounded-xl mb-4">
                                        </div>
                                        <div class="h-3 bg-white/20 rounded w-3/4 mb-2"></div>
                                        <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-2xl p-6 border border-white/10">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-xl mb-4">
                                        </div>
                                        <div class="h-3 bg-white/20 rounded w-3/4 mb-2"></div>
                                        <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-2xl p-6 border border-white/10">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-600 rounded-xl mb-4">
                                        </div>
                                        <div class="h-3 bg-white/20 rounded w-3/4 mb-2"></div>
                                        <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-2xl p-6 border border-white/10">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-pink-400 to-rose-600 rounded-xl mb-4">
                                        </div>
                                        <div class="h-3 bg-white/20 rounded w-3/4 mb-2"></div>
                                        <div class="h-2 bg-white/10 rounded w-1/2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-white/10 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-white/50 text-sm">
                    &copy; {{ date('Y') }} Jejak. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</x-layouts.app>
