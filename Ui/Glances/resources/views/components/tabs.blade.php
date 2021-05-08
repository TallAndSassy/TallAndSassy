{{--https://laracasts.com/series/blade-component-cookbook/episodes/9--}}
@props(['active'])
<div x-data="{
       activeTab: '{{$active}}',
       tabs: [],
       tabHeadings:[],
       toggleTabs() {
            this.tabs.forEach(
                tab => tab.__x.$data.showIfActive(this.activeTab)
            );
       }
       }"
     x-init="() => {
        tabs = [...$refs.tabs.children];

        tabHeadings = [...$refs.tabs.children].map(tab => tab.__x.$data.name);

        toggleTabs();
     }"
     class="FYIresources/views/components/tabs.blade.php">
    <div>
        <template x-for="(tab, index) in tabHeadings" :key="index">
            <button  x-text="tab"
                    @click="activeTab = tab; toggleTabs();"
            class="px-3 py-1 text-sm rounded shadow hover:bg-blue-700 hover:text-white bg-blue-400"
            :class="tab === activeTab ? 'bg-blue-600 text-white' : 'text-gray-800'"
             role="tab"
            :aria-selected="tab === activeTab"></button>
        </template>
    </div>
    <div x-ref="tabs">{!! $slot !!}</div>

</div>
