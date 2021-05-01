<div
    {{ $attributes->merge([
    'class' => 'tassy::page-guide-components-header-back-menu app-theme-base
    absolute top-0 right-0  mr-4
    flex
    ']
    )}}
>
@php
   /* if (\TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isABackPage()) {
        $bgColor =  "bg-gray-100";
    } elseif (\TallAndSassy\PageGuide\Http\Controllers\PageGuideController::isAFrontPage()) {
        $bgColor =  "bg-gray-50";
    } else {
        $bgColor =  "bg-red-500";
    }*/


@endphp

    @foreach (\TallAndSassy\PageGuide\PageGuideMenuWranglerBack::wranglees() as $asrMenuPackage)
        @php
        if (gettype($asrMenuPackage['routeIs']) == 'object') {
            $f = $asrMenuPackage['routeIs'];
            $isRouteZO = $f();
        } elseif (gettype($asrMenuPackage['routeIs']) == 'string') {
            $isRouteZO = request()->routeIs($asrMenuPackage['routeIs'])  ? 1 : 0;
        } else {
            assert(0,__FILE__,__LINE__);
        }

        @endphp

        <x-tassy::nav-link
            href="{{$asrMenuPackage['url']}}"
            pretty="{{$asrMenuPackage['name']}}"
            isActive="{{$isRouteZO}}"
          />
    @endforeach

    <x-tassy::user-settings-dropdown class="pt-2  "/>

</div>
