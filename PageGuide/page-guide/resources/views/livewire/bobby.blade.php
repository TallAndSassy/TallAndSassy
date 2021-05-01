<div>
<div>
    {{-- [quote] --}}
    Sample: view for TallAndSassy/Bobby with live data $sample_var({{$sample_var}})
    {{-- Access this blade via
        <livewire:tassy::livewire.bobby/>

        Peers:
        ================
        This works closely with TallAndSassy\PageGuide\Components\Bobby
            vendor/tallandsassy/page-guide/src/Components/Bobby.php
        See the above file for registration instructions...

        Troubleshooting:
        ================
        Q: When using <livewire:tassy::livewire.mylwcomponent/>, I see...
            Livewire\Exceptions\ComponentNotFoundException
            Unable to find component: [tassy::livewire.mylwcomponent]

        A: You probably didn't update src/SkeletonServiceProvider.php/boot to have your component.
            See Components/class_name.php for instructions

        A: This often happens when migrating from the main app
            1) Make sure you use the blade prefix 'tassy::'
            2) Make sure you use 'livewire.'
                Use:
                    <livewire:tassy::livewire.mylwcomponent/>
                        -instead of-
                    <livewire:tassy::mylwcomponent/>
                    <livewire:mylwcomponent/>

                -or-
                Use:
                    @livewire('tassy::livewire.mylwcomponent')
                        -instead of-
                    @livewire('mylwcomponent')
                    @livewire('livewire.mylwcomponent')
    --}}
</div>

</div>
