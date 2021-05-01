<div>
    @php $thisYear=date('Y'); @endphp
    <p class="py-2 text-center text-xs text-80 ">
        <img class='w-8 mx-auto block' id='theBottomSchoolChaseLogo' src='/img/logos/applogo.png'>

        <a href="http://www.tallandsassy.com" class="text-primary dim no-underline">{!! config('tassy.app-branding.AppName') !!}</a>
        <br>
        @include('tassy::license')
    </p>
</div>
