<div>
    Config body goes here.
    @if (App::environment(['local', 'testing']))
        <div class="pl-8 text-gray-300 rounded border">DevOnly: Customize this by copying 'modules/TallAndSassy/page-guide/resources/views/admin/config/index.blade.php' to '/resources/views/vendor/tassy/admin/config/index.blade.php' and modifying as desired </div>
    @endif
</div>
