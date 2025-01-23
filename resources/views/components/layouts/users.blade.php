<x-app :title="$title">
    <x-navbar.navbar />
    <main class="h-max">
        {{ $slot }}
    </main>
</x-app>