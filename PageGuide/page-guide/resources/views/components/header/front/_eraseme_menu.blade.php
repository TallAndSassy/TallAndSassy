<div class="
    tassy::page-guide-components-header-back-menu app-theme-base
    absolute top-0 right-0  mr-4
    flex">

    @foreach (\TallAndSassy\PageGuide\PageGuideMenuWranglerUser::wranglees() as $asrMenuPackage)
        @php
        $isRouteZO = request()->routeIs($asrMenuPackage['routeIs'])  ? 1 : 0;
        @endphp

        <x-tassy::nav-link href="{{$asrMenuPackage['url']}}" pretty="{{$asrMenuPackage['name']}}" isActive="{{$isRouteZO}}"/>


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
