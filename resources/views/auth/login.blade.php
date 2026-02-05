<x-layouts.app title="Login - Jejak">
    <div class="min-h-screen bg-gradient-mesh flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Background decorations -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400/30 rounded-full blur-3xl animate-float"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-400/30 rounded-full blur-3xl animate-float"
                style="animation-delay: -3s;"></div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full blur-3xl">
            </div>
        </div>

        <!-- Login Card -->
        <div class="w-full max-w-md relative z-10">
            <div class="glass-effect rounded-3xl p-8 md:p-10 shadow-2xl">
                <!-- Logo & Header -->
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4 backdrop-blur-sm">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang</h1>
                    <p class="text-white/70">Masuk untuk melanjutkan ke Jejak</p>
                </div>

                <!-- Error Message -->
                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-500/20 border border-red-400/30 rounded-xl text-red-100 text-sm text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}"
                    class="group w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl">
                    <svg class="w-6 h-6" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <!-- Divider -->
                <div class="flex items-center gap-4 my-8">
                    <div class="flex-1 h-px bg-white/20"></div>
                    <span class="text-white/50 text-sm">atau</span>
                    <div class="flex-1 h-px bg-white/20"></div>
                </div>

                <!-- Info -->
                <div class="text-center">
                    <p class="text-white/60 text-sm">
                        Dengan masuk, Anda menyetujui
                        <a href="#" class="text-white/90 hover:text-white underline">Ketentuan Layanan</a>
                        dan
                        <a href="#" class="text-white/90 hover:text-white underline">Kebijakan Privasi</a>
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <p class="text-center text-white/50 text-sm mt-8">
                &copy; {{ date('Y') }} Jejak. All rights reserved.
            </p>
        </div>
    </div>
</x-layouts.app>
