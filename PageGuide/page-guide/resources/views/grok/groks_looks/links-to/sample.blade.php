<ul class="list-disc">
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
        </x-tassy::ui.looks.link-to>
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
