<x-app>
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 border border-border-subtle dark:border-gray-700 rounded-2xl shadow-sm p-6 sm:p-8">

                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-text-main dark:text-white tracking-tight">
                        Reset Password
                    </h1>
                    <p class="mt-1.5 text-sm text-text-secondary">
                        Buat password baru untuk akun Anda.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

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
                                value="{{ old('email', $email) }}"
                                required
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
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-main dark:text-white mb-1.5 tracking-wide uppercase">
                            Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary pointer-events-none">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-900/40
                                       pl-10 pr-3 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/50
                                       focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary/50
                                       focus:bg-white dark:focus:bg-gray-900/60
                                       transition"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-text-main dark:text-white mb-1.5 tracking-wide uppercase">
                            Konfirmasi Password Baru
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-text-secondary pointer-events-none">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </span>
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full rounded-xl border border-border-subtle dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-900/40
                                       pl-10 pr-3 py-2.5 text-sm text-text-main dark:text-white
                                       placeholder:text-text-secondary/50
                                       focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary/50
                                       focus:bg-white dark:focus:bg-gray-900/60
                                       transition"
                                placeholder="Ulangi password baru"
                            >
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-primary text-white font-semibold py-2.5 text-sm
                               shadow-sm hover:brightness-95 active:brightness-90 transition"
                    >
                        Simpan Password Baru
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}"
                       class="text-xs font-semibold text-text-secondary hover:text-primary transition">
                        Kembali ke login
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app>
