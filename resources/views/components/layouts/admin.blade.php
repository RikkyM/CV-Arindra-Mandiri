<x-app :title="$title">
    <section class="h-screen w-full bg-yellow-500 flex">
        <x-sidebar.sidebar />
        <main class="w-full p-10">
            {{ $slot }}
        </main>
    </section>
</x-app>
