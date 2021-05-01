<x-jet-dialog-modal wire:model="showingModal" class="pt-8">
            <x-slot name="title">
               <x-tassy::ui.looks.title>{!! $title !!}</x-tassy::ui.looks.title>
            </x-slot>
            <x-slot name="content">
                <div class="pt-4">{!! $content !!}
                </div>
            </x-slot>
            <x-slot name="footer">
                {!! $footer !!}
            </x-slot>
</x-jet-dialog-modal>
