{{--This is copied directly from jetstream 'resources/views/navigation-dropdown.blade.php'--}}

@php
    $isLoggedIn = (\Illuminate\Support\Facades\Auth::user()) ? true : false;

   assert($isLoggedIn,"In user-setting-dropdown blade. This is only for logged in screens.  Please check for log in before renderring.");
@endphp

{{--<div class="p-3 flex items-center ">--}}
{{--    <!-- Menu top right -->--}}


{{--    <div @click.away="open = false" class="ml-3 relative" x-data="{ open: false }">--}}
{{--        <div>--}}
{{--            <button @click="open = !open"--}}
{{--                    class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"--}}
{{--                    id="user-menu" aria-label="User menu" aria-haspopup="true"--}}
{{--                    x-bind:aria-expanded="open">--}}
{{--                <img class="h-8 w-8 rounded-full"--}}
{{--                     src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower(Auth::user()->email)) }}?size=512&default=mp&rating=g"--}}
{{--                     alt=""/>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--        <div x-show="open" x-transition:enter="transition ease-out duration-100"--}}
{{--             x-transition:enter-start="transform opacity-0 scale-95"--}}
{{--             x-transition:enter-end="transform opacity-100 scale-100"--}}
{{--             x-transition:leave="transition ease-in duration-75"--}}
{{--             x-transition:leave-start="transform opacity-100 scale-100"--}}
{{--             x-transition:leave-end="transform opacity-0 scale-95"--}}
{{--             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">--}}

{{--            <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical"--}}
{{--                 aria-labelledby="user-menu">--}}
{{--                <a href="/myhome/profile"--}}
{{--                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"--}}
{{--                   role="menuitem">Your Profile</a>--}}
{{--                <a href="/myhome/settings"--}}
{{--                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"--}}
{{--                   role="menuitem">Settings</a>--}}
{{--                <a href="{{ route('logout') }}"--}}
{{--                   onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();"--}}
{{--                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"--}}
{{--                   role="menuitem"> {{ __('Logout') }}</a>--}}


{{--                <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
{{--                      style="display: none;">--}}
{{--                    @csrf--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<span class="{{ $attributes->get('class') }}">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class=" border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
{{--                        <img class="h-10     w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"--}}
{{--                                 alt="{{ Auth::user()->name }}"/>--}}
                             <img class="h-8 w-8 rounded-full"
                     src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower(Auth::user()->email)) }}?size=512&default=mp&rating=g"
                     alt=""/>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>

                        <x-jet-dropdown-link href="/user/profile">
                            {{ __('Profile') }}
                        </x-jet-dropdown-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-dropdown-link href="/user/api-tokens">
                                {{ __('API Tokens') }}
                            </x-jet-dropdown-link>
                        @endif

                        <div class="border-t border-gray-100"></div>

                        <!-- Team Management -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>

                            <!-- Team Settings -->
                            <x-jet-dropdown-link href="/teams/{{ Auth::user()->currentTeam->id }}">
                                {{ __('Team Settings') }}
                            </x-jet-dropdown-link>

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-dropdown-link href="/teams/create">
                                    {{ __('Create New Team') }}
                                </x-jet-dropdown-link>
                            @endcan

                            <div class="border-t border-gray-100"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team"/>
                            @endforeach

                            <div class="border-t border-gray-100"></div>
                    @endif

                    <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-jet-dropdown-link href="{{ route('logout') }}"
                                                 onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
</span>

