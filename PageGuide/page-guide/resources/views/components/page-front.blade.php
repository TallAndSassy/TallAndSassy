<x-tassy::page-_base>
    <div class="tassy::page-guide.components.page-front bg-blue-400">
    {{-- Front facing pages. Like 'site' in Wordpress. u
        The user might, or might not, be logged in, but this
        isn't about the person - it is standard site nav stuff. --}}

    <x-tassy::font-front/>


    <x-tassy::header.front.index/>
    <x-tassy::content-front>
        {{$slot}}
    </x-tassy::content-front>
    <x-tassy::footer.front.index/>
</div>

</x-tassy::page-_base>

