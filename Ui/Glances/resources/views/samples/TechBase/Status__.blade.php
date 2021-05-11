
<div class="Page_Config">
    Is stuff working here in UI Glances?

    <div class="border rounded bg-gray-200 shadow">
        <div class="text-2xl">Does alpine work</div>
        <div x-data="{ open: false }">
            <button @click="open = true">Open Dropdown (click to see alpine stuff)</button>

            <ul
                x-show="open"
                @click.away="open = false"
            >
                Dropdown Body
            </ul>
        </div>
    </div>

    <div class="border rounded bg-gray-200 shadow">
        <div class="text-2xl">Does spruce work</div>
        <div x-data>
            <div x-show="$store.sprucetest_modal.open === 'login'">
                <p>
                    This "login" modal isn't built with a11y in mind, don't actually use it
                </p>
            </div>
        </div>

        <div x-data>
            <div x-show="$store.sprucetest_modal.open === 'register'">
                <p>
                    This "register" modal isn't built with a11y in mind, don't actually use it
                </p>
            </div>
        </div>

        <div x-data>
            <select x-model="$store.sprucetest_modal.open">
                <option value="login" selected>login</option>
                <option value="register">register</option>
            </select>
        </div>
    </div>

    {{--	@include('stzoo::chunks.common__above')--}}

    {{--	@php--}}
    {{--		// INPUT: asrTabPartsProducers, activeTabSlug--}}

    {{--	@endphp--}}
    {{--	<h2 class="PrimaryTitle py-4">SubTitle for Bob Tabs (this was title on wordpress)</h2>--}}

    {{--	<div class="pt-4">--}}
    {{--		@component('stzoo::components.StTabs',['currentTab'=>$currentTab, 'asrTabPartsProducers'=>$asrTabPartsProducers, 'parentSlug'=>$parentSlug])--}}
    {{--		@endcomponent--}}
    {{--	</div>--}}
    {{--	@include('stzoo::chunks.common__below')--}}

    {{--	--}}{{--Fun Fact: I had a hard time getting script functions to be accessible when loaded via ajax. Sooo, just load from container, which should be good enough.--}}
    {{--	In other words. Javascript can't be loaded dynamically (except, like alpine stuff)--}}
    {{--	When loading via alpine, it doesn't know how to size itself, we need to coax it along.--}}

    {{--	<script>--}}
    {{--		function someFunctionThatIsHereCuzItIsHardToPutJavascriptIntoAjaxLoadedPaged(yyyy, mm) {--}}
    {{--		}--}}
    {{--	</script>--}}
    {{--	--}}
</div>

