<div>

    @if($shown)
    <div class="rounded-r-md {{ $styles['bg-color'] }} p-4 border-l-4 {{ $styles['border-color'] }} mb-3">
        <div class="flex">
            @if ($styles['icon'] ?? false)
                <div class="flex-shrink-0">
                    <p class="{{ $styles['icon-color'] }}">
                        <i class="{{ $styles['icon'] }}"></i>
                    </p>
                </div>
            @endif
            <div class="ml-3 text-sm leading-5 font-medium {{ $styles['text-color'] }}">
                {!! $message['message'] !!}
            </div>
            @if ($message['dismissable'] ?? false)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button class="inline-flex rounded-md p-1.5 {{ $styles['text-color'] }} focus:outline-none transition ease-in-out duration-150" wire:click="dismiss">
                        <x-heroicon-o-x class="w-6 h-6 text-gray-500"/>
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
