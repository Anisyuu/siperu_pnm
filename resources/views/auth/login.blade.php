<x-app>
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">

            <div class="bg-white dark:bg-gray-800 border border-border-subtle dark:border-gray-700 rounded-2xl shadow-sm p-6 sm:p-8">

                {{-- Header --}}
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-text-main dark:text-white tracking-tight">
                        Selamat Datang
                    </h1>
                    <p class="mt-1.5 text-sm text-text-secondary">
                        Masuk ke Sistem Informasi Peminjaman Ruangan
                    </p>
                </div>

                {{-- Global error --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-semibold text-text-main dark:text-white mb-1.5 tracking-wide uppercase">
                            Email
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary pointer-events-none">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-900/40
                                       pl-10 pr-3 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/50
                                       focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary/50
                                       focus:bg-white dark:focus:bg-gray-900/60
                                       transition"
                                placeholder="contoh@domain.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-300">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-semibold text-text-main dark:text-white mb-1.5 tracking-wide uppercase">
                            Password
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary pointer-events-none">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-900/40
                                       pl-10 pr-12 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/50
                                       focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary/50
                                       focus:bg-white dark:focus:bg-gray-900/60
                                       transition"
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

                    <div class="flex justify-end">
                        <a href="{{ route('password.request') }}"
                        class="text-xs font-semibold text-primary hover:underline">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-1">
                        <button
                            id="loginButton"
                            type="submit"
                            class="w-full rounded-xl bg-primary text-white font-semibold py-2.5 text-sm
                                   shadow-sm hover:brightness-95 active:brightness-90 transition"
                        >
                            Masuk
                        </button>
                    </div>
                </form>

                {{-- Google --}}
                <div class="mt-3">
                    <div class="flex items-center gap-2 my-3">
                        <div class="flex-1 h-px bg-border-subtle dark:bg-gray-700"></div>
                        <span class="text-xs text-text-secondary uppercase tracking-widest">atau</span>
                        <div class="flex-1 h-px bg-border-subtle dark:bg-gray-700"></div>
                    </div>
                    <a href="{{ route('google.redirect') }}"
                        id="googleLoginButton"
                        class="w-full inline-flex items-center justify-center gap-2 rounded-xl
                               border border-border-subtle dark:border-gray-700
                               bg-white dark:bg-gray-800 px-4 py-2.5 text-sm font-medium
                               hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                        <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                            <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/>
                            <path d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                            <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 6.29C4.672 4.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>
                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-text-secondary/60 mt-3">
                    © {{ date('Y') }} — Sistem Informasi Peminjaman Ruangan
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 1800,
                showConfirmButton: false
            });
        </script>
    @endif

    <script>
        /* ── Toggle password ── */
        const toggle = document.getElementById('togglePassword');
        const input  = document.getElementById('password');
        const icon   = document.getElementById('eyeIcon');
        toggle?.addEventListener('click', () => {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
        });

        // /* ── SweetAlert loading ── */
        // const loginForm        = document.getElementById('loginForm');
        // const loginButton      = document.getElementById('loginButton');
        // const googleLoginButton = document.getElementById('googleLoginButton');

        // loginForm?.addEventListener('submit', function () {
        //     loginButton.disabled = true;
        //     loginButton.classList.add('opacity-70', 'cursor-not-allowed');
        //     Swal.fire({
        //         title: 'Sedang login...',
        //         text: 'Mohon tunggu sebentar.',
        //         allowOutsideClick: false,
        //         allowEscapeKey: false,
        //         showConfirmButton: false,
        //         didOpen: () => { Swal.showLoading(); }
        //     });
        // });

        // googleLoginButton?.addEventListener('click', function () {
        //     Swal.fire({
        //         title: 'Menghubungkan ke Google...',
        //         text: 'Mohon tunggu sebentar.',
        //         allowOutsideClick: false,
        //         allowEscapeKey: false,
        //         showConfirmButton: false,
        //         didOpen: () => { Swal.showLoading(); }
        //     });
        // });
    </script>
</x-app>
