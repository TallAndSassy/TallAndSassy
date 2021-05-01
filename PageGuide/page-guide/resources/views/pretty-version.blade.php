<div>
    v{{config('tassy.app-branding.PrettyVersion',0.2)}}
     @if (App::environment(['local', 'testing']))
        <div class="pl-8  text-gray-300">DevOnly:Customize look and feel of this by making  /resources/views/vendor/tassy/pretty-version.blade.php </div>
         <div class="pl-8 text-gray-300">DevOnly: change V number via config file at config('app-branding.PrettyVersion') </div>
    @endif
</div>
