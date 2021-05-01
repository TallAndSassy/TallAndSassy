<div wire:poll.5s>
<div class="border shadow p-3 rounded">
    <h2>Polling Card</h2>
    Sample: view for TallAndSassy/PollingCard with live data $sample_var({{$sample_var}})
    <hr>
        <x-jet-button wire:click="doIncrement()" wire:loading.attr="disabled">
                Increment
            </x-jet-button>
        <button wire:click="doSuperIncrement()" class="rounded shadow p-2 bg-red-400">Super Increment</button>

</div>

</div>
