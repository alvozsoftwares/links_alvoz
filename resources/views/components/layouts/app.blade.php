<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        @if(isset($title))
            <header class="w-full shadow px-6 lg:px-8 py-4 text-2xl font-bold text-primary bg-white dark:bg-zinc-900 dark:text-white">
                {{ $title }}
            </header>
        @endif
        <div class="w-full p-6 lg:p-8">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts.app.sidebar>
