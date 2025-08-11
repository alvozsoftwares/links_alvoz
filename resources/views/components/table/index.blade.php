<div {{ $attributes->merge(['class' => 'w-full overflow-hidden border dark:border-zinc-600']) }}>
    <div class="w-full overflow-x-auto">
        <table class="w-full table-auto">
            {{ $slot }}
        </table>
    </div>
</div>