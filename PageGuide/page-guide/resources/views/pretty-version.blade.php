<div>
    v{{config('tassy.app-versioning.PrettyVersion','0.001a')}}
    @if (App::environment(['local', 'testing']))
        <div class="pl-8  text-gray-300">DevOnly:Customize look and feel of this by making  <a href="phpstorm://open?file={{base_path('resources/views/vendor/tassy/pretty-version.blade.php')}}">/resources/views/vendor/tassy/pretty-version.blade.php</a> </div>
        <div class="pl-8 text-gray-300">DevOnly: change V number via config file at <a href="phpstorm://open?file={{base_path('config/tassy/app-versioning.php')}}">config('tassy.app-versioning.PrettyVersion')</a> </div>
    @endif
</div>
