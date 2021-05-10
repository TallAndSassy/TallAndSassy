@props(['active'])
@once
    <script type="text/javascript">
        // See modules/TallAndSassy/Ui/resources/js/app.js
        // // Url tools
        // // This should be higher in the stack
        // function addOrUpdateUrlParam(existingUrl, paramName, newValue) {
        //     let addr = new URL(existingUrl); //https://developer.mozilla.org/en-US/docs/Web/API/URL_API
        //     addr.searchParams.set(paramName, newValue);
        //     return addr.toString();
        // }
        // // This should be higher in the stack
        // function _urlChangedViaAjaxSoUpdateBrowserSoFeelsLikePageChange(newUrl) {
        //     console.log('pushing to browser history: ' + newUrl);
        //     history.pushState(null, null, newUrl);
        //     console.log('NewUrl: '+newUrl);
        // }
        // // This should be higher in the stack
        // window.onpopstate = function (event) {
        //     // https://www.quanzhanketang.com/jsref/met_loc_reload.html
        //     // https://developer.mozilla.org/en-US/docs/Web/API/History_API
        //     // https://stackoverflow.com/questions/29500484/window-onpopstate-is-not-working-nothing-happens-when-i-navigate-back-to-page
        //     // Fix back button 7/20' https://stackoverflow.com/questions/15394156/back-button-in-browser-not-working-properly-after-using-pushstate-in-chrome
        //     //
        //     location.reload();
        // }
    </script>
    <script>
        // Tab specific
        function updateUrlToReflectNewTabClick(theSlugForThisNewTab) {
            // Put new url in browser, even though we loaded via ajax: https://jquerytraining.com/update-the-value-of-url-query-string-in-javascript/
            const existingUrl=window.location.href ;
            var updatedurl = addOrUpdateUrlParam(existingUrl, '{{\StZoo\StFrame\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY}}', theSlugForThisNewTab);
            _urlChangedViaAjaxSoUpdateBrowserSoFeelsLikePageChange(updatedurl);
        }
    </script>
@endonce

{{--@php JJ - you left off having _just_ copied those above scripts from StTabs.blade.php....--}}
{{--you want to urls to reflect tab navigation.--}}
{{--NOW: Make the 'active' tab reflect the URL.--}}
{{--Note: These scripts are in the Tabs component. We probably want to move them into app.js--}}
{{--    so that they could still work from a modal.--}}
<div x-data="{
       activeTab: '{{$active}}',
       tabs: [],
       tabHeadings:[],
       toggleTabs() {
            this.tabs.forEach(
                tab => tab.__x.$data.showIfActive(this.activeTab)
            );
       },
       updateUrlToReflectNewTabClick(theSlugForThisNewTab) {
            // Put new url in browser, even though we loaded via ajax: https://jquerytraining.com/update-the-value-of-url-query-string-in-javascript/
            const existingUrl=window.location.href ;
            var updatedurl = addOrUpdateUrlParam(existingUrl, '{{\StZoo\StFrame\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY}}', theSlugForThisNewTab);
            _urlChangedViaAjaxSoUpdateBrowserSoFeelsLikePageChange(updatedurl);
        }
       }"
     x-init="() => {
        tabs = [...$refs.tabs.children];

        tabHeadings = [...$refs.tabs.children].map(tab => tab.__x.$data.name);

        toggleTabs();
     }"
     class="FYIresources/views/components/tabs.blade.php">
    {{--from Laracast
    https://laracasts.com/series/blade-component-cookbook/episodes/9
    <div>
        <template x-for="(tab, index) in tabHeadings" :key="index">
            <button  x-text="tab"
                    @click="activeTab = tab; toggleTabs();"
            class="px-3 py-1 text-sm rounded shadow hover:bg-blue-700 hover:text-white bg-blue-400"
            :class="tab === activeTab ? 'bg-blue-600 text-white' : 'text-gray-800'"
             role="tab"
            :aria-selected="tab === activeTab"></button>
        </template>
    </div>--}}
    <div>
        <template x-for="(tab, index) in tabHeadings" :key="index">
            <button  x-text="tab"
                     @click="activeTab = tab; toggleTabs(); updateUrlToReflectNewTabClick(tab)"
                     class="whitespace-no-wrap
                                        px-3 py-2
                                        font-medium text-sm leading-5 text-gray-600 no-underline

                                    cursor-pointer
                                        hover:text-gray-700 hover:bg-gray-200 hover:border-t hover:border-r hover:rounded-t-xlg
                                        focus:outline-none focus:text-gray-700 focus:border-gray-300"
                     :class="{ 'border-indigo-500 border-l border-t border-r rounded-t-lg py-1': tab === activeTab, 'border-b rounded-t' : tab !== activeTab}"

                     role="tab"
                     :aria-selected="tab === activeTab"></button>
        </template>
    </div>


{{--Content    --}}
    <div x-ref="tabs">{!! $slot !!}</div>

</div>
