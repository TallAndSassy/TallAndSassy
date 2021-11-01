<div>
    <x-tassy::ui.looks.title>My Big Title</x-tassy::ui.looks.title>
    <x-tassy::ui.looks.parenthetical>(parenthetical text)</x-tassy::ui.looks.parenthetical>
    <hr>
    <ul class="list-disc pl-6">
        <li>Item Red</li>
        <li>Item Sea Froth</li>
        <li>Item Amber</li>
    </ul>
    <hr>
    <ol class="list-decimal pl-6">
        <li>Item Red</li>
        <li>
            Good luck with sub-items
        </li>
        <li>Item Amber</li>
    </ol>
    <hr>
    <ul class="list-disc pl-6">
        <li>
            <x-tassy::ui.looks.link-to  href='/' >
                Link to another page in this app
            </x-tassy::ui.looks.link-to>
        </li>
        <li><x-tassy::ui.looks.link-to  href='/' enum-sandbox="tab">
                Link to another page in this app in a new tab
            </x-tassy::ui.looks.link-to></li>
        <li>
            <x-tassy::ui.looks.link-to href="https://www.google.com" enum-location="outside">
                Link to Google as outside the app
            </x-tassy::ui.looks.link-to>
        </li>
        <li>
            <x-tassy::ui.looks.link-to href="https://www.google.com"  enum-sandbox="tab" enum-location="outside">
                Link to Google as outside the app in new tab
            </x-tassy::ui.looks.link-to>
        </li>
        <li>
            <x-tassy::ui.looks.link-to href="https://www.google.com"  enum-sandbox="download">
                Link to file download
            </x-tassy::ui.looks.link-to>
        </li>

        <li>
            <x-tassy::ui.looks.link-to href="mailto:jj.github@rohrer.org"  enum-sandbox="program">
                jj.opensEmailProgram@rohrer.org
            </x-tassy::ui.looks.link-to>
        </li>
        <li>
            <x-tassy::ui.looks.link-to href="#livewirestuff" enum-location="anchor" >
                Go elsewhere on same page
            </x-tassy::ui.looks.link-to>
        </li>
        <li>
            <x-tassy::ui.looks.link-to href="#livewirestuff" enum-sandbox="touch" >
                Do a no-impact action
            </x-tassy::ui.looks.link-to>
        </li>
        <li>
            <x-tassy::ui.looks.link-to href="#livewirestuff" enum-sandbox="change" >
                Do an impactful action
            </x-tassy::ui.looks.link-to> Also, consider using a button, instead.
        </li>

        <li>
            <x-tassy::ui.looks.link-to-modal
                href="something w/o modal">
                Modal Up
            </x-tassy::ui.looks.link-to-modal>
            {{--         App\Http\Livewire\TheModalBox::generateLinkToRaiseModal('Open Modal', 'admin/people/FlightInstructorsCreate', 'Flight Instructor',  'Cancel', 'Create')--}}
        </li>

        <li>
            <x-tassy::ui.looks.link-to href="/"  enum-sandbox="back">
                Back
            </x-tassy::ui.looks.link-to>
        </li>
    </ul>
    <hr>
    <x-heroicon-o-home class="w-6 h-6 text-gray-500"/>
    <hr>
    <div>Something Interesting with a hint <x-tassy::ui.looks.hint>This explains that.</x-tassy::ui.looks.hint></div>
    <x-tassy::ui.looks.label-value label="Name" value="JJ"/>
    <x-tassy::ui.looks.label-value label="Name" value="JJ Rohrer"/>
    <x-tassy::ui.looks.label-value label="Price" value="$25.00"/>
    <x-tassy::ui.looks.label-value label="Amount Owed" value="(25.00)" hint="This is the amount you must still pay."/>
    <hr>
    Spinner for 'working'
    <br>
    <x-tassy-ui::spinners.working/>
    <p>Spinner for 'loading'
    <br>
    <x-tassy-ui::spinners.loading/>


</div>
