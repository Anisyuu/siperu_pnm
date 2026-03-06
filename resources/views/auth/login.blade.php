<x-app>
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            {{-- Card --}}
            <div class="bg-white dark:bg-gray-800 border border-border-subtle dark:border-gray-700 rounded-2xl shadow-sm p-6 sm:p-8">

                {{-- Header --}}
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-text-main dark:text-white tracking-tight">
                    Login
                </h1>
                <p class="mt-2 text-sm text-text-secondary">
                    Silakan masuk menggunakan akun Anda.
                </p>
            </div>

                {{-- Global error --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post')}}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-text-main dark:text-white mb-1">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700 bg-white dark:bg-gray-900/40
                                       pl-10 pr-3 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/70
                                       focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40"
                                placeholder="contoh@domain.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-text-main dark:text-white mb-1">
                            Password
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary">
                                <i class="fa-solid fa-lock"></i>
                            </span>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700 bg-white dark:bg-gray-900/40
                                       pl-10 pr-12 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/70
                                       focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/40"
                                placeholder="Masukkan password"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-3 flex items-center text-text-secondary hover:text-text-main dark:hover:text-white transition-colors"
                                aria-label="Toggle password"
                            >
                                <i id="eyeIcon" class="fa-regular fa-eye"></i>
                            </button>

                        </div>

                        @error('password')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-primary text-white font-semibold py-2.5
                                   shadow-sm hover:brightness-95 active:brightness-90 transition"
                        >
                            Login
                        </button>
                    </div>
                </form>

                <div class = "mt-3">
                    <a href="{{ route('google.redirect') }}"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-border-subtle dark:border-gray-700
                                bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-semibold
                                hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <i class="fa-brands fa-google"></i>
                            Login dengan Google
                    </a>
                </div>
                {{-- Footer note --}}
                    <p class="text-center text-xs text-text-secondary mt-4">
                        © {{ date('Y') }} SIPERU — Sistem Informasi Peminjaman Ruangan
                    </p>

            </div>
        </div>
    </div>

    {{-- Toggle password script (tanpa framework) --}}
    <script>
        const toggle = document.getElementById('togglePassword');
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        toggle?.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });
    </script>
</x-app>
