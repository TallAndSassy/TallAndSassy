@props(['defaultTab'])
{{--
See also: modules/TallAndSassy/Ui/resources/js/app.js
Motivation: https://laracasts.com/series/blade-component-cookbook/episodes/9
History: Long and sordid. Recently from StTabs
https://stackoverflow.com/a/31482685

Remember: StTabs had some javascript for switching tabs. Not sure if needed.

Example: See modules/TallAndSassy/Ui/Glances/resources/views/samples/TabSamples/TabSample1__Page.blade.php
--}}

<div x-data="{
       activeTab: '{{app('request')->input(\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY) ?? $defaultTab}}',
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
            var updatedurl = addOrUpdateUrlParam(existingUrl, '{{\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY}}', theSlugForThisNewTab);
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
