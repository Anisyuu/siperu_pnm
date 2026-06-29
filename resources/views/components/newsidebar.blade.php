<aside class="hidden md:flex sticky top-0 h-screen w-80 flex-col dark:bg-[#111] transition-all">
    <div class="flex m-3 rounded-xl shadow-sm bg-white dark:bg-[#1d1d1d] h-full flex-col justify-between p-4 border border-gray-100 dark:border-gray-800">
        <div class="flex flex-col gap-1">

            <div class="px-3 py-4 flex justify-center items-center gap-3 mb-2">
                <span class="text-gray-900 dark:text-white text-2xl font-black tracking-tight">
                    PinjamRuang<span class="text-primary text-blue-600">.</span>
                </span>
            </div>

            <nav class="flex flex-col gap-1">

                @php
                    $activeClass = "bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400";
                    $inactiveClass = "text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 transition-all duration-200";
                    $iconActive = "text-blue-600 dark:text-blue-400";
                    $iconInactive = "text-gray-400 group-hover:text-gray-600";
                @endphp

                @hasRole('kasubag')
                    <a href="{{ route('kasubag.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-house w-5 {{ request()->routeIs('kasubag.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('kasubag.kelola-jadwal') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.kelola-jadwal') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('kasubag.kelola-jadwal') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>

                    <a href="{{ route('kasubag.list-user') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.list-user') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-user w-5 {{ request()->routeIs('kasubag.list-user') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Kelola Pengguna</span>
                    </a>

                    <div class="flex flex-col" data-dropdown-wrapper>
                        @php
                            $isRuanganActive = request()->routeIs('kasubag.jenis-ruang.*')
                                || request()->routeIs('kasubag.kampus.*');
                        @endphp

                        <button
                            type="button"
                            data-dropdown-trigger
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isRuanganActive ? 'text-blue-600' : $inactiveClass }}"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Ruangan</span>
                            </div>

                            <i data-dropdown-icon
                                class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isRuanganActive ? 'rotate-180' : '' }}"></i>
                        </button>

                        <div
                            data-dropdown-menu
                            class="{{ $isRuanganActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1"
                        >
                            <a href="{{ route('kasubag.jenis-ruang.index') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.jenis-ruang.*') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">
                                Jenis Ruangan
                            </a>

                            <a href="{{ route('kasubag.kampus.index') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.kampus.*') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">
                                Lokasi
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('kasubag.alur-verifikasi.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.alur-verifikasi.*') ? $activeClass : $inactiveClass }}">
                        <i class="fa-solid fa-road w-5 {{ request()->routeIs('kasubag.alur-verifikasi.*') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Alur Verifikasi</span>
                    </a>

                    <a href="{{ route('kasubag.verifikasi-peminjaman') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kasubag.verifikasi-peminjaman') ? $activeClass : $inactiveClass }}">
                        <i class="fa-solid fa-list-check w-5 {{ request()->routeIs('kasubag.verifikasi-peminjaman') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Verifikasi Peminjaman</span>
                    </a>

                    <div class="flex flex-col" data-dropdown-wrapper>
                        @php
                            $isRiwayatActive = request()->routeIs('kasubag.riwayat-verifikasi')
                                || request()->routeIs('kasubag.riwayat-peminjaman');
                        @endphp

                        <button
                            type="button"
                            data-dropdown-trigger
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isRiwayatActive ? 'text-blue-600' : $inactiveClass }}"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-clock-rotate-left w-5"></i>
                                <span class="text-sm font-semibold">Riwayat</span>
                            </div>

                            <i data-dropdown-icon
                                class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isRiwayatActive ? 'rotate-180' : '' }}"></i>
                        </button>

                        <div
                            data-dropdown-menu
                            class="{{ $isRiwayatActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 dark:border-gray-700 flex flex-col gap-1"
                        >
                            <a href="{{ route('kasubag.riwayat-verifikasi') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">
                                Riwayat Verifikasi
                            </a>

                            <a href="{{ route('kasubag.riwayat-peminjaman') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kasubag.riwayat-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500 hover:text-blue-600' }}">
                                Riwayat Peminjaman
                            </a>
                        </div>
                    </div>
                @endhasRole

                @hasRole('sarpras')
                    <a href="{{ route('sarpras.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('sarpras.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-house w-5 {{ request()->routeIs('sarpras.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('sarpras.jadwal-ruangan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('sarpras.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('sarpras.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>

                    <div class="flex flex-col" data-dropdown-wrapper>
                        @php
                            $isPeminjamanSarprasActive = request()->routeIs('sarpras.verifikasi-peminjaman')
                                || request()->routeIs('sarpras.riwayat-verifikasi');
                        @endphp

                        <button
                            type="button"
                            data-dropdown-trigger
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isPeminjamanSarprasActive ? 'text-blue-600' : $inactiveClass }}"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Peminjaman</span>
                            </div>

                            <i data-dropdown-icon
                                class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isPeminjamanSarprasActive ? 'rotate-180' : '' }}"></i>
                        </button>

                        <div
                            data-dropdown-menu
                            class="{{ $isPeminjamanSarprasActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 flex flex-col gap-1"
                        >
                            <a href="{{ route('sarpras.verifikasi-peminjaman') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('sarpras.verifikasi-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Verifikasi
                            </a>

                            <a href="{{ route('sarpras.riwayat-verifikasi') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('sarpras.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Riwayat
                            </a>
                        </div>
                    </div>
                @endhasRole

                @hasRole('kalab')
                    <a href="{{ route('kalab.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kalab.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-house w-5 {{ request()->routeIs('kalab.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('kalab.jadwal-ruangan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('kalab.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('kalab.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>

                    <div class="flex flex-col" data-dropdown-wrapper>
                        @php
                            $isPeminjamanKalabActive = request()->routeIs('kalab.verifikasi-peminjaman')
                                || request()->routeIs('kalab.riwayat-verifikasi');
                        @endphp

                        <button
                            type="button"
                            data-dropdown-trigger
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isPeminjamanKalabActive ? 'text-blue-600' : $inactiveClass }}"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Peminjaman</span>
                            </div>

                            <i data-dropdown-icon
                                class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isPeminjamanKalabActive ? 'rotate-180' : '' }}"></i>
                        </button>

                        <div
                            data-dropdown-menu
                            class="{{ $isPeminjamanKalabActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 flex flex-col gap-1"
                        >
                            <a href="{{ route('kalab.verifikasi-peminjaman') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kalab.verifikasi-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Verifikasi
                            </a>

                            <a href="{{ route('kalab.riwayat-verifikasi') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('kalab.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Riwayat
                            </a>
                        </div>
                    </div>
                @endhasRole

                @hasRole('pimpinan')
                    <a href="{{ route('pimpinan.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('pimpinan.dashboard') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-house w-5 {{ request()->routeIs('pimpinan.dashboard') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Dashboard</span>
                    </a>

                    <a href="{{ route('pimpinan.jadwal-ruangan') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs('pimpinan.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                        <i class="fa-regular fa-calendar w-5 {{ request()->routeIs('pimpinan.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                        <span class="text-sm font-semibold">Jadwal</span>
                    </a>

                    <div class="flex flex-col" data-dropdown-wrapper>
                        @php
                            $isPimpinanActive = request()->routeIs('pimpinan.verifikasi-peminjaman')
                                || request()->routeIs('pimpinan.riwayat-verifikasi');
                        @endphp

                        <button
                            type="button"
                            data-dropdown-trigger
                            class="flex items-center justify-between px-3 py-2.5 rounded-lg group {{ $isPimpinanActive ? 'text-blue-600' : $inactiveClass }}"
                        >
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-building w-5"></i>
                                <span class="text-sm font-semibold">Peminjaman</span>
                            </div>

                            <i data-dropdown-icon
                                class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 {{ $isPimpinanActive ? 'rotate-180' : '' }}"></i>
                        </button>

                        <div
                            data-dropdown-menu
                            class="{{ $isPimpinanActive ? '' : 'hidden' }} ml-9 mt-1 border-l border-gray-200 flex flex-col gap-1"
                        >
                            <a href="{{ route('pimpinan.verifikasi-peminjaman') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('pimpinan.verifikasi-peminjaman') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Verifikasi
                            </a>

                            <a href="{{ route('pimpinan.riwayat-verifikasi') }}"
                                class="pl-4 py-2 text-sm {{ request()->routeIs('pimpinan.riwayat-verifikasi') ? 'text-blue-600 font-bold' : 'text-gray-500' }}">
                                Riwayat
                            </a>
                        </div>
                    </div>
                @endhasRole

                @foreach(['ormawa', 'mahasiswa', 'dosen', 'karyawan'] as $role)
                    @hasRole($role)
                        <a href="{{ route($role.'.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.dashboard') ? $activeClass : $inactiveClass }}">
                            <i class="fa-regular fa-house w-5 {{ request()->routeIs($role.'.dashboard') ? $iconActive : $iconInactive }}"></i>
                            <span class="text-sm font-semibold">Dashboard</span>
                        </a>

                        <a href="{{ route($role.'.jadwal-ruangan') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.jadwal-ruangan') ? $activeClass : $inactiveClass }}">
                            <i class="fa-regular fa-calendar w-5 {{ request()->routeIs($role.'.jadwal-ruangan') ? $iconActive : $iconInactive }}"></i>
                            <span class="text-sm font-semibold">Jadwal</span>
                        </a>

                        <a href="{{ route($role.'.list-peminjaman') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.list-peminjaman') ? $activeClass : $inactiveClass }}">
                            <i class="fa-solid fa-list-check w-5 {{ request()->routeIs($role.'.list-peminjaman') ? $iconActive : $iconInactive }}"></i>
                            <span class="text-sm font-semibold">Peminjaman</span>
                        </a>

                        <a href="{{ route($role.'.riwayat-peminjaman') }}"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg group {{ request()->routeIs($role.'.riwayat-peminjaman') ? $activeClass : $inactiveClass }}">
                            <i class="fa-solid fa-clock-rotate-left w-5 {{ request()->routeIs($role.'.riwayat-peminjaman') ? $iconActive : $iconInactive }}"></i>
                            <span class="text-sm font-semibold">Riwayat</span>
                        </a>
                    @endhasRole
                @endforeach

            </nav>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-100 dark:border-gray-800">

        @php
            $unreadNotificationCount = auth()->user()->unreadNotifications()->count();
        @endphp

        <button
            id="notificationButton"
            type="button"
            class="relative mb-3 flex w-full items-center justify-between gap-3 rounded-xl border border-blue-50 bg-white px-3 py-2.5 text-slate-700 transition-all duration-200 hover:border-blue-100 hover:bg-blue-50 group"
        >
            <div class="flex items-center gap-3">
                <div class="relative flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition-colors duration-200 group-hover:bg-blue-100">
                    <i class="fa-regular fa-bell text-sm"></i>

                    <span
                        id="notification-badge"
                        class="{{ $unreadNotificationCount > 0 ? '' : 'hidden' }} absolute -right-1.5 -top-1.5 min-w-[18px] rounded-full bg-red-500 px-1 text-center text-[10px] font-bold leading-[18px] text-white ring-2 ring-white"
                    >
                        {{ $unreadNotificationCount }}
                    </span>
                </div>

                <div class="text-left">
                    <div class="text-sm font-semibold leading-tight text-slate-800 group-hover:text-blue-600">
                        Notifikasi
                    </div>
                    <div class="text-[11px] text-slate-400 leading-tight">
                        Lihat pemberitahuan terbaru
                    </div>
                </div>
            </div>

            <i class="fa-solid fa-chevron-right text-[11px] text-slate-300 group-hover:text-blue-500"></i>
        </button>

        @php
            $initials = collect(explode(' ', auth()->user()->nama_lengkap))
                ->take(2)
                ->map(fn($w) => strtoupper($w[0]))
                ->implode('');
        @endphp

        <a href="{{ route('profile') }}"
            class="flex w-full items-center gap-3 mb-3 px-3 py-2.5 border rounded-xl transition-colors duration-150 group
            {{ request()->routeIs('profile') ? 'bg-blue-50 border-blue-100' : 'bg-white border-blue-50 hover:bg-blue-50 hover:border-blue-100' }}">

            <div class="w-9 h-9 rounded-lg uppercase bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold flex-shrink-0
                {{ request()->routeIs('profile') ? 'bg-blue-100' : 'group-hover:bg-blue-100' }}">
                {{ $initials }}
            </div>

            <div class="flex-1 text-left overflow-hidden">
                <div class="text-sm font-semibold truncate leading-tight
                    {{ request()->routeIs('profile') ? 'text-blue-600' : 'text-slate-800 group-hover:text-blue-600' }}">
                    {{ auth()->user()->nama_lengkap }}
                </div>

                <div class="text-[11px] text-slate-400 mt-0.5 truncate leading-tight">
                    {{ auth()->user()->roles->first()->nama ?? '-' }}
                </div>
            </div>

            <i class="fa-solid fa-chevron-right text-[11px] text-slate-300 group-hover:text-blue-500"></i>
        </a>

            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf

                <button
                    id="logoutButton"
                    type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-300 font-bold text-sm"
                >
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
</aside>

<div
    id="notificationModal"
    class="fixed inset-0 z-[9998] hidden"
    aria-labelledby="notificationModalTitle"
    role="dialog"
    aria-modal="true"
>
    <div
        id="notificationOverlay"
        class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
    ></div>

    <div class="absolute right-4 top-4 w-[380px] max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/20">

        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h2 id="notificationModalTitle" class="text-base font-black text-slate-900">
                    Notifikasi
                </h2>

                <p class="mt-0.5 text-xs text-slate-500">
                    Daftar pemberitahuan akun Anda
                </p>
            </div>

            <button
                id="notificationClose"
                type="button"
                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-400 hover:bg-slate-100 hover:text-slate-700"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-3">
            <span id="notificationStatus" class="text-xs font-semibold text-slate-400">
                Memuat notifikasi...
            </span>

            <button
                id="markAllNotificationRead"
                type="button"
                class="text-xs font-bold text-blue-600 hover:text-blue-800"
            >
                Tandai semua dibaca
            </button>
        </div>

        <div
            id="notificationList"
            class="max-h-[420px] overflow-y-auto divide-y divide-slate-100"
        >
            <div class="px-5 py-6 text-center text-sm text-slate-400">
                Memuat...
            </div>
        </div>

        <div
            id="notificationEmpty"
            class="hidden px-5 py-10 text-center"
        >
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <i class="fa-regular fa-bell-slash"></i>
            </div>

            <p class="mt-3 text-sm font-bold text-slate-700">
                Belum ada notifikasi
            </p>

            <p class="mt-1 text-xs text-slate-400">
                Notifikasi peminjaman akan muncul di sini.
            </p>
        </div>
    </div>
</div>

@push("js")
<script>
document.addEventListener("DOMContentLoaded", function () {
    /*
    |--------------------------------------------------------------------------
    | Dropdown Sidebar
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('[data-dropdown-trigger]').forEach((button) => {
        button.addEventListener('click', function () {
            const wrapper = button.closest('[data-dropdown-wrapper]');

            if (!wrapper) return;

            const menu = wrapper.querySelector('[data-dropdown-menu]');
            const icon = button.querySelector('[data-dropdown-icon]');

            if (!menu) return;

            const isHidden = menu.classList.toggle('hidden');

            if (icon) {
                icon.classList.toggle('rotate-180', !isHidden);
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Notification Modal
    |--------------------------------------------------------------------------
    */
    const notificationButton = document.getElementById('notificationButton');
    const notificationModal = document.getElementById('notificationModal');
    const notificationOverlay = document.getElementById('notificationOverlay');
    const notificationClose = document.getElementById('notificationClose');
    const notificationList = document.getElementById('notificationList');
    const notificationEmpty = document.getElementById('notificationEmpty');
    const notificationStatus = document.getElementById('notificationStatus');
    const notificationBadge = document.getElementById('notification-badge');
    const markAllNotificationRead = document.getElementById('markAllNotificationRead');

    const csrfToken = @json(csrf_token());

    function openNotificationModal() {
        if (!notificationModal) return;

        notificationModal.classList.remove('hidden');
        loadNotifications();
    }

    function closeNotificationModal() {
        if (!notificationModal) return;

        notificationModal.classList.add('hidden');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function setBadge(count) {
        if (!notificationBadge) return;

        count = parseInt(count || 0);

        if (count > 0) {
            notificationBadge.innerText = count > 99 ? '99+' : count;
            notificationBadge.classList.remove('hidden');
        } else {
            notificationBadge.innerText = '0';
            notificationBadge.classList.add('hidden');
        }
    }

    async function loadUnreadCount() {
        try {
            const response = await fetch('{{ route('notifications.unread-count') }}', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) return;

            const data = await response.json();

            setBadge(data.count);
        } catch (error) {
            console.error('Gagal mengambil jumlah notifikasi:', error);
        }
    }

    function renderNotifications(notifications) {
        if (!notificationList || !notificationEmpty || !notificationStatus) return;

        notificationList.innerHTML = '';

        if (!notifications || notifications.length === 0) {
            notificationEmpty.classList.remove('hidden');
            notificationStatus.innerText = 'Tidak ada notifikasi';
            return;
        }

        notificationEmpty.classList.add('hidden');

        const unreadCount = notifications.filter(item => !item.read_at).length;
        notificationStatus.innerText = `${notifications.length} notifikasi, ${unreadCount} belum dibaca`;

        notifications.forEach(item => {
            const data = item.data || {};

            const title = data.title || 'Notifikasi';
            const message = data.message || 'Ada notifikasi baru.';
            const time = item.created_at || '';
            const isUnread = !item.read_at;

            const type = data.type || '';
            const iconClass = type.includes('verifikasi') ? 'fa-list-check' : 'fa-bell';

            const itemEl = document.createElement('button');

            itemEl.type = 'button';
            itemEl.className = `
                flex w-full gap-3 px-5 py-4 text-left transition
                ${isUnread ? 'bg-blue-50/70 hover:bg-blue-50' : 'bg-white hover:bg-slate-50'}
            `;

            itemEl.innerHTML = `
                <div class="mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl ${isUnread ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-slate-100 text-slate-500'}">
                    <i class="fa-solid ${iconClass} text-sm"></i>
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <p class="text-sm font-bold text-slate-800 leading-5">
                            ${escapeHtml(title)}
                        </p>

                        ${isUnread ? '<span class="mt-1 h-2 w-2 flex-shrink-0 rounded-full bg-blue-500"></span>' : ''}
                    </div>

                    <p class="mt-1 text-xs text-slate-500 leading-5">
                        ${escapeHtml(message)}
                    </p>

                    <p class="mt-2 text-[11px] font-semibold text-slate-400">
                        ${escapeHtml(time)}
                    </p>
                </div>
            `;

            itemEl.addEventListener('click', async () => {
                await markNotificationAsRead(item.id);
            });

            notificationList.appendChild(itemEl);
        });
    }

    async function loadNotifications() {
        if (!notificationList) return;

        notificationList.innerHTML = `
            <div class="px-5 py-6 text-center text-sm text-slate-400">
                Memuat notifikasi...
            </div>
        `;

        try {
            const response = await fetch('{{ route('notifications.index') }}', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                notificationList.innerHTML = `
                    <div class="px-5 py-6 text-center text-sm text-red-500">
                        Gagal memuat notifikasi.
                    </div>
                `;
                return;
            }

            const notifications = await response.json();

            renderNotifications(notifications);
            loadUnreadCount();

        } catch (error) {
            console.error('Gagal memuat notifikasi:', error);

            notificationList.innerHTML = `
                <div class="px-5 py-6 text-center text-sm text-red-500">
                    Terjadi kesalahan saat memuat notifikasi.
                </div>
            `;
        }
    }

    async function markNotificationAsRead(id) {
        try {
            const response = await fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) return;

            await loadNotifications();
            await loadUnreadCount();

        } catch (error) {
            console.error('Gagal menandai notifikasi:', error);
        }
    }

    async function markAllAsRead() {
        try {
            const response = await fetch('{{ route('notifications.read-all') }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) return;

            await loadNotifications();
            await loadUnreadCount();

        } catch (error) {
            console.error('Gagal menandai semua notifikasi:', error);
        }
    }

    notificationButton?.addEventListener('click', openNotificationModal);
    notificationOverlay?.addEventListener('click', closeNotificationModal);
    notificationClose?.addEventListener('click', closeNotificationModal);
    markAllNotificationRead?.addEventListener('click', markAllAsRead);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeNotificationModal();
        }
    });
    
    /*
    |--------------------------------------------------------------------------
    | Polling Notifikasi
    |--------------------------------------------------------------------------
    | Cek notifikasi setiap 10 detik tanpa Reverb.
    */
    loadUnreadCount();

    setInterval(() => {
        loadUnreadCount();

        if (notificationModal && !notificationModal.classList.contains('hidden')) {
            loadNotifications();
        }
    }, 10000);

    });
</script>
@endpush
