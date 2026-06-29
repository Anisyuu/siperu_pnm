<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'SiPeru') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />
</head>

<body class="antialiased">
    @include('sweetalert::alert')

    {{ $slot }}

    @stack('js')


    @auth
    {{-- TOAST CONTAINER --}}
    <div id="toast-container"
        class="fixed top-5 right-5 z-[9999] flex w-full max-w-sm flex-col gap-3 pointer-events-none">
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function showToast({
                title = 'Notifikasi',
                message = 'Ada notifikasi baru.',
                type = 'info',
                duration = 5000
            }) {
                const container = document.getElementById('toast-container');

                if (!container) return;

                const config = {
                    success: {
                        icon: 'fa-circle-check',
                        iconBg: 'bg-emerald-100',
                        iconText: 'text-emerald-600',
                        border: 'border-emerald-200',
                        bar: 'bg-emerald-500',
                    },
                    error: {
                        icon: 'fa-circle-xmark',
                        iconBg: 'bg-red-100',
                        iconText: 'text-red-600',
                        border: 'border-red-200',
                        bar: 'bg-red-500',
                    },
                    warning: {
                        icon: 'fa-triangle-exclamation',
                        iconBg: 'bg-amber-100',
                        iconText: 'text-amber-600',
                        border: 'border-amber-200',
                        bar: 'bg-amber-500',
                    },
                    info: {
                        icon: 'fa-bell',
                        iconBg: 'bg-blue-100',
                        iconText: 'text-blue-600',
                        border: 'border-blue-200',
                        bar: 'bg-blue-500',
                    }
                };

                const style = config[type] || config.info;

                const toast = document.createElement('div');

                toast.className = `
                    pointer-events-auto relative overflow-hidden rounded-2xl border ${style.border}
                    bg-white/95 shadow-lg shadow-slate-900/10 backdrop-blur
                    transform transition-all duration-300 ease-out
                    translate-x-6 opacity-0
                `;

                toast.innerHTML = `
                    <div class="flex gap-3 p-4">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl ${style.iconBg}">
                            <i class="fa-solid ${style.icon} ${style.iconText} text-lg"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-sm font-bold text-slate-900 leading-5">
                                        ${escapeHtml(title)}
                                    </p>
                                    <p class="mt-0.5 text-sm text-slate-600 leading-5">
                                        ${escapeHtml(message)}
                                    </p>
                                </div>

                                <button type="button"
                                    class="toast-close -mt-1 rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition">
                                    <i class="fa-solid fa-xmark text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 h-1 w-full bg-slate-100">
                        <div class="toast-progress h-full ${style.bar}" style="width: 100%;"></div>
                    </div>
                `;

                container.appendChild(toast);

                requestAnimationFrame(() => {
                    toast.classList.remove('translate-x-6', 'opacity-0');
                    toast.classList.add('translate-x-0', 'opacity-100');
                });

                const progress = toast.querySelector('.toast-progress');

                if (progress) {
                    progress.style.transition = `width ${duration}ms linear`;

                    requestAnimationFrame(() => {
                        progress.style.width = '0%';
                    });
                }

                const closeToast = () => {
                    toast.classList.add('translate-x-6', 'opacity-0');

                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                };

                toast.querySelector('.toast-close')?.addEventListener('click', closeToast);

                setTimeout(closeToast, duration);
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text ?? '';
                return div.innerHTML;
            }

            function resolveToastType(notification) {
                const status = (notification.status_verifikasi || notification.status || '').toLowerCase();
                const type = (notification.type || '').toLowerCase();

                if (status.includes('disetujui')) return 'success';
                if (status.includes('ditolak')) return 'error';
                if (status.includes('pending') || status.includes('diproses')) return 'warning';
                if (type.includes('pengajuan')) return 'info';

                return 'info';
            }


            let lastNotificationId = null;

            async function checkNotifications() {

                try {

                    const response = await fetch("{{ route('notifications.index') }}", {
                        headers: {
                            "Accept": "application/json"
                        }
                    });

                    if (!response.ok) return;

                    const notifications = await response.json();

                    if (!notifications.length) return;

                    const newest = notifications[0];

                    if (lastNotificationId === null) {
                        lastNotificationId = newest.id;
                        return;
                    }

                    if (newest.id !== lastNotificationId) {

                        lastNotificationId = newest.id;

                        showToast({
                            title: newest.data.title,
                            message: newest.data.message,
                            type: resolveToastType(newest.data),
                            duration: 6000
                        });

                        const badge = document.getElementById('notification-badge');

                        if (badge) {

                            let count = parseInt(badge.innerText || 0);

                            badge.innerText = count + 1;

                            badge.classList.remove('hidden');

                        }

                    }

                } catch (e) {

                    console.error(e);

                }

            }
            
                    checkNotifications();
            
                    setInterval(checkNotifications, 10000);
        });
    </script>
@endauth

</body>
</html>
