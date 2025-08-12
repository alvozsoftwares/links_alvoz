<div>
    <div>
        <form wire:submit.prevent="save" class="w-full flex flex-col lg:flex-row gap-4">
            @csrf

            <div class="w-full lg:flex-1 flex flex-wrap gap-4 content-start items-start">
                <flux:input wire:model="url" type="url" placeholder="Descrição do link" />
                <div class="w-[150px]">
                    <flux:field>
                        <flux:label>Tamanho</flux:label>
                        <flux:input.group>
                            <flux:input wire:model="tamanho" type="number" />
                            <flux:input.group.suffix>px</flux:input.group.suffix>
                        </flux:input.group>
                        <flux:error name="tamanho" />
                    </flux:field>
                </div>
                <div class="w-[150px]">
                    <flux:field>
                        <flux:label>Margem</flux:label>
                        <flux:input.group>
                            <flux:input wire:model="margem" type="number" />
                            <flux:input.group.suffix>px</flux:input.group.suffix>
                        </flux:input.group>
                        <flux:error name="margem" />
                    </flux:field>
                </div>
                <flux:input wire:model="cor_fundo" type="color" label="Cor do fundo" class="w-full lg:w-[150px]" />
                <flux:input wire:model="cor_principal" type="color" label="Cor principal" class="w-full lg:w-[150px]" />
                <flux:radio.group wire:model="estilo_principal" label="Estilo do corpo" class="w-full lg:w-[150px]">
                    <flux:radio value="square" label="Quadrado" checked class="cursor-pointer" />
                    <flux:radio value="dot" label="Círculo" class="cursor-pointer" />
                    <flux:radio value="round" label="Arredondado" class="cursor-pointer" />
                </flux:radio.group>
                <flux:radio.group wire:model="estilo_olhos" label="Estilo centro dos olhos" class="w-full lg:w-[150px]">
                    <flux:radio value="square" label="Quadrado" checked class="cursor-pointer" />
                    <flux:radio value="circle" label="Círculo" class="cursor-pointer" />
                </flux:radio.group>
                <div class="w-full flex flex-wrap gap-4">
                    <div>
                        <flux:radio.group wire:model="gradient_select" label="Gradiente?">
                            <flux:radio value="false" label="Não" checked class="cursor-pointer" />
                            <flux:radio value="true" label="Sim" class="cursor-pointer" />
                        </flux:radio.group>
                    </div>
                    <flux:input wire:model="gradient_from" type="color" label="Cor inicial do gradiente" class="w-full lg:w-[150px]" />
                    <flux:input wire:model="gradient_to" type="color" label="Cor final do gradiente" class="w-full lg:w-[150px]" />
                </div>
            </div>

            <div class="w-full lg:w-72 flex flex-wrap gap-4 content-start">
                <div class="w-full border rounded-lg border-gray-300 overflow-hidden">
                    @if ($qrcode != null)
                        <img src="{!! $qrcode !!}" class="w-full">
                    @else
                        <div class="w-full aspect-square flex justify-center items-center bg-gray-100">
                            <p>Seu QR code será gerado aqui.</p>
                        </div>
                    @endif
                </div>

                <div class="w-full order-last lg:order-first">
                    <flux:button variant="primary" color="green" class="w-full cursor-pointer" type="button" wire:click="gerarQrCode">
                        Gerar QR code
                    </flux:button>
                </div>
            </div>
        </form>
    </div>
</div>
