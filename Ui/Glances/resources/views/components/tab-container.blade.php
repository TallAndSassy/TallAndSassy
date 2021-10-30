@props(['defaultSlug'])
<div>

    <div x-ref="tabs"
         {{--         @register-jtab.stop="console.log('hi from jtab');"--}}
         x-data="{
            jRegisterTab : function(theDomTab) {
                 let tabSlug = theDomTab.attributes.slug.value;
                 this.arrSlug2DomTab[tabSlug] = theDomTab;
            },
            jSelectTabByDomElement : function(theDomTab) {
                let tabSlug = theDomTab.attributes.slug.value;
                this.jSelectTabBySlug(tabSlug);

            },
            jSelectTabBySlug: function(slug_as_string) {
                console.log('pinning tab into url: '+slug_as_string);
                let theDomTab = this.arrSlug2DomTab[slug_as_string];
                console.log(theDomTab);
                this.activeSlug = slug_as_string;
                this.updateUrlToReflectNewTabClick(slug_as_string);
            },

            updateUrlToReflectNewTabClick: function(theSlugForThisNewTab) {
                // Put new url in browser, even though we loaded via alpine click: https://jquerytraining.com/update-the-value-of-url-query-string-in-javascript/
                const existingUrl=window.location.href ;
                var updatedurl = this.addOrUpdateUrlParam(existingUrl, '{{\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY}}', theSlugForThisNewTab);
                this._urlChangedViaJsSoUpdateBrowserSoFeelsLikePageChange(updatedurl);
            },
            // ----------------------------- Mostly for Tabs - -BEGIN- -------------------------------------------------------------
            addOrUpdateUrlParam : function (existingUrl, paramName, newValue) {
                let addr = new URL(existingUrl); //https://developer.mozilla.org/en-US/docs/Web/API/URL_API
                addr.searchParams.set(paramName, newValue);
                return addr.toString();
            },
            // This should be higher in the stack
            _urlChangedViaJsSoUpdateBrowserSoFeelsLikePageChange : function (newUrl) {
                console.log('pushing to browser history via T&S : ' + newUrl);
                history.pushState(null, null, newUrl);
                console.log('NewUrl: '+newUrl);
            },
            // This should be higher in the stack
            onpopstate : function (event) {
                // https://www.quanzhanketang.com/jsref/met_loc_reload.html
                // https://developer.mozilla.org/en-US/docs/Web/API/History_API
                // https://stackoverflow.com/questions/29500484/window-onpopstate-is-not-working-nothing-happens-when-i-navigate-back-to-page
                // Fix back button 7/20' https://stackoverflow.com/questions/15394156/back-button-in-browser-not-working-properly-after-using-pushstate-in-chrome
                //
                location.reload();
            },

            // ----------------------------- Mostly for Tabs - -END- ---------------------------------------------------------------


            arrSlug2DomTab: {},
            activeSlug: 'students2',
            _afterFirstRender: function() {
                console.log('rendered page.');
                Livewire.emit('iSeeTab', this.activeSlug);
            }

         }"
         x-init="let queryString = window.location.search;
                 const urlParams = new URLSearchParams(queryString);
                 const pageTab = urlParams.get('{{\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY}}');
                 if (pageTab !== null) {
                     activeSlug = pageTab;
                 }  else {
                     activeSlug = '{{$defaultSlug}}';
                 }
                 console.log('pageTab: '+pageTab);
                 $nextTick(() => {
                    _afterFirstRender();
                 })
                 {{--         //Note: this is called before child divs get a chance to call jRegisterTab($el); which doesn't give a chance to pick default tab, or inspect the url.--}}
         {{--         // get the url parameter $PAGE_TAB_KEY https://www.sitepoint.com/get-url-parameters-with-javascript/--}}
                 "
    >
        <div class="mb-3"
             role="tablist"
        >
            {{--            --}}
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select id="tabs" name="tabs"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        x-model="activeSlug"

                >
                    <option
                    >[Select a tab]</option>
                    <template x-for="(theDomTab, index) in arrSlug2DomTab"
                              :key="index"
                    >
                        <option
                                x-text="theDomTab.attributes.name.value"
                                :key="theDomTab.attributes.slug.value"
                                :value="theDomTab.attributes.slug.value"
                                {{-- Bug: x-model isn't getting followed on initial load.  Let's work around with bladeness? --}}
                                :selected = "'{{ isset($_REQUEST[\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY]) ? $_REQUEST[\TallAndSassy\Ui\Glances\TabsProducer_SimpleImplementation::$PAGE_TAB_KEY] : $defaultSlug}}' == theDomTab.attributes.slug.value "

                        ></option>
                    </template>
                </select>
            </div>


            <div class="hidden sm:block">
                <template x-for="(theDomTab, index) in arrSlug2DomTab"
                          :key="index"
                >
                    <button x-text="theDomTab.attributes.name.value"
                            @click="jSelectTabByDomElement(theDomTab);
                        "
                            class="whitespace-no-wrap
                                        px-3 py-2
                                        font-medium text-sm leading-5 text-gray-600 no-underline

                                    cursor-pointer
                                        hover:text-gray-700 hover:bg-gray-200 hover:border-t hover:border-r hover:rounded-t-xlg
                                        focus:outline-none focus:text-gray-700 focus:border-gray-300"
                            :class="{ 'border-indigo-500 border-l border-t border-r rounded-t-lg py-1': theDomTab.attributes.slug.value === activeSlug, 'border-b rounded-t' : theDomTab.attributes.slug.value !== activeSlug}"

                            :id="`tab-${index + 1}`"
                            role="tab"
                            :aria-selected="(theDomTab.attributes.slug.value === activeSlug).toString()"
                            :aria-controls="`tab-panel-${index + 1}`"
                    ></button>
                </template>
            </div>
        </div>
        {!! $slot !!}


    </div>
</div>
