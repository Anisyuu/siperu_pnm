<x-app>
    <div class="min-h-screen flex h-screen w-full overflow-hidden bg-gray-100 ">

        <x-newsidebar></x-newsidebar>
        
        <main class="flex-1 m-3 max-h-screen overflow-y-auto ">
            {{ $slot }}
        </main>
    </div>
</x-app>
