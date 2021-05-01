<div class="
    tassy::page-guide-components-header-back-menu app-theme-base
    absolute top-0 right-0  mr-4
    flex">

    @foreach (\TallAndSassy\PageGuide\PageGuideMenuWranglerFront::wranglees() as $asrMenuPackage)
        @php
        $isRouteZO = request()->routeIs($asrMenuPackage['routeIs'])  ? 1 : 0;
        @endphp

        <x-tassy::nav-link href="{{$asrMenuPackage['url']}}" pretty="{{$asrMenuPackage['name']}}" isActive="{{$isRouteZO}}"/>
{{--        <x-jet-nav-link href="{{$asrMenuPackage['url']}}" :active="$isRouteZO">--}}
{{--            {{$asrMenuPackage['name']}}--}}
{{--        </x-jet-nav-link>--}}
{{--        <a id="navbarDropdown"--}}
{{--           class="ml-8 nav-link  inline-block font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"--}}
{{--           href="{{$asrMenuPackage['url']}}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--            <span>{{$asrMenuPackage['name']}}</span>--}}
{{--        </a>--}}



    @endforeach

{{--    This is dumb, but if we are logged in, show the fance drop down, otherwise just--}}
{{--        menus (which should include a login ?and register--}}

    @php
    $isLoggedIn = (\Illuminate\Support\Facades\Auth::user()) ? true : false;
    @endphp

    @if ($isLoggedIn)

    <x-tassy::user-settings-dropdown class="pt-2"/>


    @endif

</div>
