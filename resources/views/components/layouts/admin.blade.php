<x-app :title="$title">
    <section class="h-screen w-full flex overflow-auto">
        <x-sidebar.sidebar />
        <main class="w-full p-10">
            {{ $slot }}
        </main>
    </section>
</x-app>
