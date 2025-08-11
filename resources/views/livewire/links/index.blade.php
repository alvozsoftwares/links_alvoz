<div>
    <div class="w-full flex flex-wrap lg:flex-nowrap gap-4 mb-6 items-end">
        <div>
            <flux:button href="{{ route('links.create') }}" variant="primary">
                Adicionar
            </flux:button>
        </div>
        <div class="w-full">
            <flux:input label="Pesquisar" type="search" icon="magnifying-glass" placeholder="Buscar..." wire:model.live="search" />
        </div>
        <div>
            <flux:select label="Status" wire:model.live="status" class="min-w-[100px] cursor-pointer" >
                <flux:select.option>Todos</flux:select.option>
                <flux:select.option value="active">Ativo</flux:select.option>
                <flux:select.option value="inactive">Inativo</flux:select.option>
            </flux:select>
        </div>
        <div>
            <flux:select label="Paginação" wire:model.live="limit" class="min-w-[100px] cursor-pointer" >
                <flux:select.option value="5">5</flux:select.option>
                <flux:select.option value="10">10</flux:select.option>
                <flux:select.option value="25">25</flux:select.option>
                <flux:select.option value="50">50</flux:select.option>
                <flux:select.option value="100">100</flux:select.option>
                <flux:select.option value="200">200</flux:select.option>
            </flux:select>
        </div>
    </div>

    <div class="w-full">
        @if(!$data->isEmpty())
            <x-table>
                <thead>
                    <x-table.tr class="!bg-gray-100 border-gray-200 dark:!bg-zinc-800 dark:border-zinc-700">
                        <x-table.th wire:click="sort('descricao')" width="50%">Descrição</x-table.th>
                        <x-table.th wire:click="sort('uri')">URI</x-table.th>
                        <x-table.th wire:click="sort('status')">Status</x-table.th>
                        <x-table.th class="text-right">Ação</x-table.th>
                    </x-table.tr>
                </thead>
                <tbody>
                    @foreach ($data as $item) 
                        <x-table.tr>
                            <x-table.td>{{ $item->descricao }}</x-table.td>
                            <x-table.td class="truncate">{{ $item->uri }}</x-table.td>
                            <x-table.td>{{ $item->status }}</x-table.td>
                            <x-table.td class="text-right">
                                <flux:button icon="pencil-square" class="cursor-pointer" href="{{ route('links.edit', $item->id) }}"></flux:button>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </tbody>
            </x-table>
            {{ $data->links() }}
        @else
            <p>Sem dados para exibir.</p>
        @endif
    </div>
</div>
 