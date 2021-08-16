<x-tassy-ui::modal_blade name="tenant-create-modal"
                         x-data="{ show: @entangle('showModal') }"
                         x-init="$watch('showModal', value => console.log(value))"
                         @modal-did-change.window="
                         console.log('changed:'+$event.detail.modalName+$event.detail.show);
                         $nextTick(() => { show = false; })

                        "
>
    <x-slot name="title">Create New Tenant</x-slot>
    <x-slot name="body">
        <form wire:submit.prevent="save">
        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="newName_inBrowser" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Name
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg flex rounded-md shadow-sm">

                        <input wire:model.lazy="newName" type="text"
                               class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-md sm:text-sm border-gray-300">
                    </div>

                    @error('newName')

                    <div class="rounded-md bg-red-50 py-2 px-4"
                    >
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: solid/check-circle -->
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    {!! $message !!}
                                </p>
                            </div>

                        </div>
                    </div>

                    @enderror
                </div>
            </div>

            <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                    <label for="newSlug_inBrowser" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Slug
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <div class="max-w-lg flex rounded-md shadow-sm">

                            <input wire:model.lazy="newSlug" type="text"
                                   class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-l-md sm:text-sm border-gray-300">
                            <span
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                .{{env('MEMCACHED_HOST')}}
{{--                                schooltwist.org--}}
                              </span>

                        </div>
                        @error('newSlug')

                        <div class="rounded-md bg-red-50 py-2 px-4"

                        >
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: solid/check-circle -->
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {!! $message !!}
                                    </p>
                                </div>

                            </div>
                        </div>

                        @enderror
                    </div>
                </div>
            </div>
        </div>
            <div class="mt-2">
            <button
                type="cancel"
                class="rounded shadow px-3 py-2   bg-gray-100 hover:bg-gray-400   mr-3"
                @click="show = false"
            >
                Cancel
            </button>

            <button
                type="submit"
{{--                onclick="$modals.showBladeModalNamed('{{$showBladeModalNamed}}')"--}}
                class="rounded shadow px-3 py-2   bg-blue-500 hover:bg-blue-600 ">
                Save
            </button>
                <span class="ml-3">{!! $littleMessage !!}</span>
            </div>
        </form>

    </x-slot>
    <x-slot name="footer">
{{--        <x-tassy-ui::button--}}
{{--            enumStyle='Cancel'--}}
{{--            @click="show = false"--}}
{{--            class="mr-4">Cancel--}}
{{--        </x-tassy-ui::button>--}}
{{--        <x-tassy-ui::button--}}
{{--            enumStyle='Submit'--}}
{{--            wire.click="saveNew"--}}
{{--        >Submit--}}
{{--        </x-tassy-ui::button>--}}
    </x-slot>
</x-tassy-ui::modal_blade>
