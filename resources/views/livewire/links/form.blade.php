<div>
    <div class="w-full flex flex-wrap lg:flex-nowrap gap-4 mb-6 items-end">
        <div>
            <flux:button href="{{ route('links.index') }}" variant="filled">
                Voltar
            </flux:button>
        </div>
    </div>
    <div>
        <form wire:submit.prevent="save" class="w-full flex flex-col lg:flex-row gap-4">
            @csrf
            <div class="w-full lg:flex-1 flex flex-wrap gap-4">
                <flux:input wire:model="descricao" placeholder="Descrição do link" required />
                <flux:input wire:model="url" type="url" placeholder="Descrição do link" required />

                <flux:input.group>
                    <flux:input.group.prefix>{{ env('APP_URL') }}/ir/</flux:input.group.prefix>
                    <flux:input wire:model="uri" placeholder="Descrição do link" required />
                </flux:input.group>

                @if ($qrcode_link != null)
                    <div class="w-full flex flex-col lg:flex-row gap-4 items-center lg:items-start">
                        <div class="w-full max-w-[200px]">
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(800)->generate($qrcode_link)) !!}" class="w-full">
                        </div>
                        <div class="text-center lg:text-left">
                            <small>O QR code será atualizado após o salvamento. <br>Clique com o botão direito, e em 'Abrir imagem em uma nova guia' para visualizar o arquivo maior e salve-o.</small>
                            @php
                                $link_acesso = ENV('APP_URL').'/ir/'. $uri;
                            @endphp
                            <flux:button class="mt-4" href="{{ route('gerador', ['url' => $link_acesso]) }}">
                                Personalizar o QR CODE
                            </flux:button>
                        </div>
                    </div>
                @endif
            </div>
            <div class="w-full lg:w-72 flex flex-wrap gap-4 content-start">
                <div class="w-full order-last lg:order-first">
                    <flux:button variant="primary" color="green" class="w-full cursor-pointer" type="submit">
                        Salvar
                        <x-icons.spin class="ml-3" wire:loading />
                    </flux:button>
                    @if($dados)        
                        <div class="w-full text-center text-sm mt-3">
                            <span>Última alteração: {{ $dados->updated_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
                <div class="w-full">
                    <flux:select label="Status" wire:model="status" class="cursor-pointer">
                        <flux:select.option value="active">Ativo</flux:select.option>
                        <flux:select.option value="inactive">Inativo</flux:select.option>
                    </flux:select>
                </div>
            </div>
        </form>
    </div>
</div>
