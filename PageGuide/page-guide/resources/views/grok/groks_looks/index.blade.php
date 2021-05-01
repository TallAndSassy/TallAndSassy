<x-app-layout>
    @php
    $pathOffRouteToGroks = 'vendor/TallAndSassy/app-theme-base/resources/views/grok/groks_looks';

    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tall and Sassy: Looks
        </h2>
    </x-slot>
    <div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <x-grok::action-section title="Titles">
                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/title/description',['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>

                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/title/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                            </x-grok::action-section>


                            <x-jet-section-border/>

                            <x-grok::action-section title="Parenthetical">
                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/parenthetical/description', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>

                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/parenthetical/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                            </x-grok::action-section>


                            <x-jet-section-border/>
                            <x-grok::action-section>
                                <x-slot name="title">
                                    Ordered Lists
                                </x-slot>

                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/lists/description', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>

                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/lists/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                            </x-grok::action-section>


                            <x-jet-section-border/>
                            <x-grok::action-section>
                                <x-slot name="title">
                                    Links & Navigation

                                </x-slot>

                                <x-slot name="description">
                                    Standard ways to show links
                                </x-slot>

                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/links-to/description', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/links-to/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>


                            </x-grok::action-section>

                            <x-jet-section-border/>


                            <x-jet-section-border/>
                            <x-grok::action-section>
                                <x-slot name="title">
                                    Icons
                                </x-slot>

                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/icons/description', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/icons/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>

                            </x-grok::action-section>

                            <x-jet-section-border/>
                            <x-grok::action-section>
                                <x-slot name="title">
                                    Labeled Values, Hints, etc.
                                </x-slot>

                                <x-slot name="description">
                                    @include('tassy::/grok/groks_looks/labeled-value/description', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>

                                <x-slot name="content">
                                    @include('tassy::/grok/groks_looks/labeled-value/content', ['pathOffRouteToGroks'=>$pathOffRouteToGroks])
                                </x-slot>
                            </x-grok::action-section>


                            <x-jet-section-border/>






    <x-jet-section-border/>

{{--            <x-tassy::title>TODO</x-tassy::title>--}}


{{--                <pre>--}}
{{--                    ------- Laravel JetStream Demo ------------}}
{{--                    [x] Titled Page--}}
{{--                    [x] Page sections/Form Sections--}}
{{--                    [x] Form Section Action--}}
{{--                    [x] Form Section Form--}}
{{--                    [x] Confirmation Modal--}}
{{--                    [x] Dialog Modal--}}
{{--                    (?Maybe) Form that works on page, or in modal--}}
{{--                    [x] Polling chunk--}}
{{--                    [x] Form message flash--}}
{{--                    [X] Lists--}}
{{--                        [X] Ordered--}}
{{--                        [X] Unordered--}}
{{--                    [X] Flash Messages--}}
{{--                    (-> Later) Quotes--}}
{{--                    (--> Later ) Code--}}

{{--                    ------- Tall & Sassy UI Blocks skills ------------}}
{{--                    -- UI ----}}
{{--                    [X] Links to sites--}}
{{--                    [X ] Links to new tabs--}}
{{--                    [X ] Links to modals--}}
{{--                    [X ] Links to programs--}}
{{--                    [X ] Links to other pages on the site--}}
{{--                    [X] Hint--}}
{{--                    [X] Labeled Value with hint--}}
{{--                    [ ] Labeled Value (editable) with hint--}}
{{--                        [ ] int input--}}
{{--                        [ ] string input--}}
{{--                        [ ] money input with contraints--}}
{{--                        [ ] Date--}}
{{--                        [ ] Time--}}
{{--                        [ ] Scheduled Date/Time --> End--}}
{{--                        [ ] Pick From--}}
{{--                        [ ] Flash on Change--}}

{{--                    -- Structure ----}}
{{--                    [ ] Full admin Page w/ title tagline, body, footer--}}
{{--                    [ ] Tabs--}}

{{--                    -- Fancy Flow ----}}
{{--                    [ ] Back Nav--}}

{{--                    [ ] Flash message to relevant area, like in School Twist.--}}


{{--                    -- Data ----}}
{{--                    [ ] Tables--}}
{{--                    [ ] Reveals--}}
{{--                    [ ] Stacked Progress Bars (usage: Class enrollment)--}}

{{--                    ------- Tall & Sassy Page Navigation ------------}}
{{--                    [ ] generic admin panel (Use Tall2, its pretty good)--}}
{{--                        [ ]     Top, Bottom, Dev--}}
{{--                                This should use Livewire's new querystring system so refresh and back work properly.--}}
{{--                                as general concept of front end and admin ('dashboard') side, similiar to wordpress--}}

{{--                    -------- Core Capabilities -----------------}}
{{--                    (Much Later) Role impersination--}}
{{--                    (Much Later) New tenant creation.... and tenant management--}}
{{--                    (Later) Tool on/off for the app--}}
{{--                    Short-term broadcast messages--}}
{{--                    Persistent broadcast messages--}}
{{--                    Simple Branding--}}


{{--                    -------- Core includes Infrastructure Tools ------}}
{{--                    [X] Periscope & Debug Stuff--}}
{{--                    [ ] Roles (users can have more than one role)--}}
{{--                            [-> ] App Owner (Landlord)--}}
{{--                            [-> ] App Developer (Maintenance staff)--}}
{{--                            [ ] Tenant Owner (Think, Restaurant owner in a complex)--}}
{{--                            [ ] Tenant Staff (Think restaurant staff)--}}
{{--                            [ ] Tenant Subscriber (Think restaurant guests)--}}
{{--                            [X] Guest--}}
{{--                            [X] User--}}


{{--                    -------- Core Tools -----------------}}
{{--                    [ ] Messaging (Look for existing tools)--}}
{{--                        [ ] App Owner to: Role(s)--}}
{{--                            [ ] Currently Logged In--}}
{{--                            [ ] Until X--}}
{{--                            [ ] Until Read--}}
{{--                        [ ] Tenant Owner: Role(s)... (above)--}}
{{--                    [ ] User Invitations w/ role and management--}}
{{--                        [ ] Invite individuals--}}
{{--                        [ ] Invite Roster--}}
{{--                    [ ] Basic Help Tickets (look for existing tools for built-in and integrations w/ zendesk)--}}


{{--                    [--> ] Teams & Multi-tenant (think, a parent can belong to three families across several schools. Two families might go to same school)--}}
{{--                    [--> ] one-on-one communication--}}
{{--                    (??  ) e-commerce, maybe this is per-app?--}}

{{--                    Tall & Sassy Branding--}}
{{--                        [ ] Branding Config from tall2--}}
{{--                        [ ] Footer on front and admin/dashboard--}}
{{--                        (??  ) App-Level Terminology--}}
{{--                        (??  ) Tenant-Level Terminology--}}

{{--                    Tall & Sassy Page Flow--}}
{{--                        [ ] admin/Dashboard--}}
{{--                        [ ] admin/People--}}
{{--                        [ ] admin/People/Users--}}
{{--                        [ ] About Page--}}
{{--                        [ ] Config--}}

{{--                    Tall & Sassy Security--}}
{{--                        [ ] Email Confirmation--}}
{{--                        [ ] Two-Factor force-confirm before setting--}}
{{--                        [ ] Optionally Disable self-registration--}}

{{--                    -------- Plugins -----------------}}
{{--                    Events--}}
{{--                        Tickets--}}


{{--                    -------- App ----------------------}}
{{--                    School Twist--}}
{{--                    ============--}}
{{--                        Config:--}}
{{--                            Multi-Tenant--}}
{{--                            Teams--}}
{{--                            Terminology--}}
{{--                        Plugins--}}
{{--                            Events--}}
{{--                            Tickets--}}
{{--                            Ecommerce--}}
{{--                            Video--}}
{{--                        Roles--}}
{{--                            Attendee--}}
{{--                            Booker--}}
{{--                            Instructor--}}
{{--                            Parent--}}
{{--                            Attendee--}}



{{--</pre>--}}
        </div>
    </div>
    </div>
</x-app-layout>
