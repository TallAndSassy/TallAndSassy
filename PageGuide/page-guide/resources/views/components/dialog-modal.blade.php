<x-jet-dialog-modal wire:model="showingModal" class="pt-8">
            <x-slot name="title">
               <x-tassy::ui.looks.title>{!! $title !!}
                   <div class="text-gray-400 text-sm">(Dep - Use dialog-modal-inline)</div>
               </x-tassy::ui.looks.title>
            </x-slot>
            <x-slot name="content">
                <div class="pt-4">{!! $content !!}
                </div>
            </x-slot>
            <x-slot name="footer">
                {!! $footer !!}
            </x-slot>
</x-jet-dialog-modal>
