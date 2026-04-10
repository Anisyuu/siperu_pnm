<x-app>
    <div class="min-h-screen flex w-full bg-gray-100">

        <x-newsidebar></x-newsidebar>

        <main class="flex-1 m-3">
            {{ $slot }}
        </main>
    </div>
</x-app>
