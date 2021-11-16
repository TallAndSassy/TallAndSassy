<div>
    @if (App::environment(['local', 'testing']))
        <div class="pl-8 text-gray-300">DevOnly: If you use other licenses, like Creative Commons, put that info here. Customize this by making  <a href="phpstorm://open?file={{base_path('resources/views/vendor/tassy/licenses.blade.php'}}"></a>/resources/views/vendor/tassy/licenses.blade.php </div>
    @endif
</div>
