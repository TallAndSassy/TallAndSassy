<div>
    v{{config('tassy.app-versioning.PrettyVersion','0.001a')}}
     @if (App::environment(['local', 'testing']))
        <div class="pl-8  text-gray-300">DevOnly:Customize look and feel of this by making  /resources/views/vendor/tassy/pretty-version.blade.php </div>
         <div class="pl-8 text-gray-300">DevOnly: change V number via config file at config('app-versioning.PrettyVersion') </div>
    @endif
</div>
