<div>


    <div>
        <x-tassy-ui::tab-container defaultSlug="one">
            <x-tassy-ui::tab name="Intro" slug="one">
                You can show code examples anywhere.

                <p>
                    @include('tassy-ui::samples/Code/CodeSamples')
                </p>
                <p class="text-gray-500">
                    Code samples are derived from the eleganttechnologies/grok package.
                </p>
            </x-tassy-ui::tab>
            <x-tassy-ui::tab name="Simple" slug="two">
                Tab 2
            </x-tassy-ui::tab>
        </x-tassy-ui::tab-container>
    </div>

    <div>
        <details class=" ml-3 mt-3">
            <summary class="text-gray-600 cursor-pointer">About this page</summary>
            <div class="rounded bg-gray-300 p-3">

                Fill with whatever you want. (Admin/Tassy/Code CodeHome)
                <br>
                You can erase all of this...
                <p></p>

                @if ('group' == 'global')
                    Blade Path (normal spot): <a href="phpstorm://open?file=/Users/jjrohrer/Sites/eh/eh2021/eh2021BaseAAA/app/Http/Livewire/Admin/Tassy/Code//resources/views/Admin/Tassy/Code/CodeHome.blade.php">views/Admin/Tassy/Code/CodeHome.blade.php</a>
                @else
                    Blade Path (in group): <a href="phpstorm://open?file=/Users/jjrohrer/Sites/eh/eh2021/eh2021BaseAAA/app/Http/Livewire/Admin/Tassy/Code//resources/views/Admin/Tassy/Code/CodeHome.blade.php">views/Admin/Tassy/Code/CodeHome.blade.php</a>
                @endif
                <br>
                Edit the controller and adjust title stuff at: <a href="phpstorm://open?file=/Users/jjrohrer/Sites/eh/eh2021/eh2021BaseAAA/app/Http/Livewire/Admin/Tassy/Code/CodeHomeTabbedPageController.php">/Users/jjrohrer/Sites/eh/eh2021/eh2021BaseAAA/app/Http/Livewire/Admin/Tassy/Code/CodeHomeTabbedPageController.php</a>
                <br>
                Put public assets in: public/tassypagesync/Admin/Tassy/Code//CodeHome
                <img src="{{asset('Admin/Tassy/Code//CodeHome/Mockup.png')}}" >
                        </div>
        </details>
    </div>


</div>
