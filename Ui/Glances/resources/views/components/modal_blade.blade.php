@props(['name'])
<div id="{{ $name }}"
     x-data="{show: false}"
     x-show="show"
     @keydown.escape.window="show=false"
     style="" {{--I think this is like cloak. It starts hidden w/o learning cloak syntax--}}
     class="fixed inset-0 grid place-items-center"
{{--     Yuck-ish, this is how tell alpine to listen the modal event attached at the window level. This connects to the app.js/ modal event dispatched whenever the javaScript showNamedModal gets called --}}
     x-on:modal.window="
        show = true;
     "
     {{$attributes}}
>
    <div class="fixed inset-0 bg-gray-900 opacity-90" @click="show=false"></div> {{-- shade the whole background --}}
    <div class="FYIModalBody bg-white shadow-md max-w-sm m-auto rounded-md overflow-y-auto relative z-10"
         style="display:none;"
         x-show.transition="show">
        <div class="flex flex-col h-full justify-between">
            <header class="p-6">
                <h3 class="font-bold text-lg">
                    {{$title}}
                </h3>
            </header>
            <main class="px-6 mb-4">
                {{$body}}
            </main>
            <footer class="flex justify-end px-6 mt-6 bg-gray0200 rounded-b-md">
                {{$footer}}
            </footer>
        </div>

    </div>

</div>
