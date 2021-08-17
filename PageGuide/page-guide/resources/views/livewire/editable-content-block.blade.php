<div>
{{--
Known Issue: When saving textarea, we remove tags. This is only  reflected in the textarea after a refresh, does render as expected. I'm not sure what the expected behavior actually should be. seems not import enough yet.
--}}
    <div class="fyi-editable-content-block">
        @guest
            @if($enumType == 'textarea')
                {!! nl2br($content,true) !!}
            @elseif($enumType == 'html')
                {!! $content !!}
            @endif

        @endguest
        @auth

            <div x-data="{
                isEditing_atBrowser: @entangle('isEditing_atServer').defer,

                cancelButtonText: 'Close',
                saveButtonText: 'Saved',

                hasChanges: @entangle('hasChanges').defer,
                count_front: @entangle('count_back').defer,

                lastSaveCopyOfContent: '{!! \TallAndSassy\Strings\TsStringConvert::pure2htmlAttribute_playsWithJavascript($content) !!}', // WIP
                localContent: 'To be unpacked',
    {{--   Later         arrAllowedTags_atBrowser:  @entangle('allowedTags').defer,--}}

                }"
                x-init="
                localContent = decodeURIComponent(lastSaveCopyOfContent);
                $watch('hasChanges', v => {
                if (hasChanges) {
                    cancelButtonText = 'Cancel';
                    saveButtonText = 'Save';
                } else {
                    cancelButtonText = 'Close';
                    saveButtonText = 'Saved';
                }
                });
                $watch('localContent', v=> {hasChanges=true;});
                @if($enumType == 'html')
                // Track the editor-created event.... then get notified of changes once it is created.
                 window.jEditorAttached('#fronteditor', (theEditor) => { // future improver: see here for alternative implementations: https://laracasts.com/discuss/channels/laravel/how-to-bind-ckeditor-value-to-laravel-livewire-component
                    // The wysiwig editor has been created.
                    $dispatch('catch-myeditor-created',{ourEditor: theEditor});
                    theEditor.model.document.on('change:data', () => { // https://github.com/ckeditor/ckeditor5/issues/996#issuecomment-571944011
                        //console.log('The data has changed! (written resources/views/livewire/editable-content-block.blade.php)');
                        // Since this is a closure, vs a promise, a simple property change won't bubble up as you might expected.
                        $dispatch('catch-changes', {hasChanges: true});
                    });
                 });

                 @endif
                "
                 @if($enumType == 'html')
                 @catch-myeditor-created="ourEditor = $event.detail.ourEditor"
                 @catch-changes="hasChanges = true"
                 @endif



                >
                @php

                @endphp
                @can($this->getEditPermission())
                <button
                    x-cloak
                    x-show="! isEditing_atBrowser"
                    x-on:click=" isEditing_atBrowser = true "
                    type="button"
                    class="py-0 px-0  hover:text-blue-700 text-blue-600 underline "
                    >
                    Edit
                </button>
                @endcan

                <div x-cloak
                     x-show="isEditing_atBrowser"
                     class="mb-1"
                >
                    <button
                        type="button"
    {{--                    class="py-0 px-0  hover:text-blue-700 text-blue-600 underline "--}}
                        class="inline-flex w-20 items-center px-2 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        x-on:click="isEditing_atBrowser = false;
                        if (hasChanges === true) {
                            localContent = decodeURIComponent(lastSaveCopyOfContent);
                        } else if (hasChanges === false) {
                            // Do nothing, we're good.
                        }
                        hasChanges=false;
                        "
                    >
                        <div class="w-full text-center"
                             x-text="cancelButtonText">
                            doomed_cancelButtonText
                        </div>
                    </button>
                    <button
                        type="button"
    {{--                    class="py-0 px-0  hover:text-blue-700 text-blue-600 underline "--}}


                        @if($enumType == 'textarea')
                            x-on:click="$wire.save(localContent)"
                        @else($enumType == 'html')
                            x-on:click="{
                            console.log('Saving: ' + ourEditor.getData());
                            $wire.save(ourEditor.getData())
                            }"
                        @endif
                        //console.log( $wire.save( ourEditor.getData() ) );
                        }
                        "
    {{--                    x-on:click="$wire.save(localContent)";--}}
    {{--                                        console.log( $wire.save( localContent ) );--}}

                        x-bind:disabled="! hasChanges"

                        class="ml-1 w-20 inline-flex items-center px-2 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium
                                focus:ring-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 "

                        :class="{
                                'text-white bg-indigo-600 hover:bg-indigo-700': hasChanges,
                                'bg-gray-100 text-gray-400': ! hasChanges
                                }"
                    >
                        <div class="w-full text-center"
                             x-text="saveButtonText"
                             wire:loading.class="hidden">
                            doomed_saveButtonText
                        </div>
                        <div wire:loading>Saving...</div>
                    </button>



                    @if($enumType == 'textarea' || $enumType == 'cms')
                    <textarea
                        class="form-textarea {{$class ?? 'w-full h-64 mt-4'}}"
                        id="fronteditor" placeholder="{{ $placeholder ?? 'Enter Text' }}"
                           x-show.transition=" isEditing_atBrowser"
                           x-model="localContent"
                           value="{!! $content !!}"
                         name="editor">
                    </textarea>

                    @elseif($enumType == 'html')

                    <div class="mt-4"
                         x-cloak
                         wire:ignore
                         {{--  Import link when working on this again: See this for hints on getting to work with livewire.... which this does not do so elegantly                   https://laracasts.com/discuss/channels/laravel/how-to-bind-ckeditor-value-to-laravel-livewire-component--}}
                         x-show="isEditing_atBrowser">

                        <div class="form-textarea w-full"
                             class="form-control2" id="fronteditor" placeholder="Enter the Description"
                             name="editor">
                            {!! $content !!}
                        </div>
                    </div>
                    @else
                        @php dd([__FILE__,__LINE__,$enumType,'resources/views/livewire/editable-content-block.blade.php']) @endphp
                    @endif



                </div>
                <div
                    x-show.transition="! isEditing_atBrowser"
                    class="w-full">
                    @if($enumType == 'textarea')
                        {!! nl2br($content,true) !!}
                    @elseif($enumType == 'html')
                        {!! $content !!}
                    @endif
                </div>


    {{--            <hr>--}}

    {{--            <br>Info: [isEditing_atBrowser:<span x-text="isEditing_atBrowser"></span>, isEditing_atServer: {{$isEditing_atServer ?  'True' : 'False'}}]--}}
    {{--            <br>--}}
    {{--            hasChanges: <span x-text="hasChanges"></span>--}}
    {{--            <br>--}}
    {{--            count_front: <span x-text="count_front"></span>--}}
    {{--            <br>--}}
    {{--            $content: {!! $content !!}--}}
    {{--            <br>--}}
    {{--            localContent: <span x-text="localContent"></span>--}}
            </div>

        @endauth
    </div>
</div>

