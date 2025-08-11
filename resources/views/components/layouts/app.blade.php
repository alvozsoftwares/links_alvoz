<x-layouts.app.sidebar :title="$title ?? null">
    <header class="w-full shadow px-6 py-4 text-2xl font-bold text-primary bg-white">
        {{ $title ?? null }}
    </header>
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
