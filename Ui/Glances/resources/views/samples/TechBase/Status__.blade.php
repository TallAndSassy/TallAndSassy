
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
                Dropdown Body (if you had to click- to reveal this message, then alpine is working)
            </ul>
        </div>
    </div>
    <div x-data :class="$store.darkModeStoreTest_forStatus__.on && 'bg-gray-400'">Light Mode / Dark Mode</div>
    <button x-data @click="$store.darkModeStoreTest_forStatus__.toggle()">[Toggle Dark Mode Button]</button>
    <div class="italic text-gray-400">This references the $store.darkModeStoreTest_forStatus__ alpine variable that is initialized in PageGuide/page-guide/resources/views/components/page-_base.blade.php</div>


{{--    <div class="border rounded bg-gray-200 shadow">--}}
{{--        10/19/21' I'm not sure this is relevant.--}}
{{--        <div class="text-2xl">Does Apline $store work? (used to be Spruce)</div>--}}
{{--        <div x-data>--}}
{{--            <select x-model="$store.showingModal.open">--}}
{{--                <option value="login" selected>Set $store.sprucetest_modal.open to 'login'</option>--}}
{{--                <option value="register">Set $store.sprucetest_modal.open to 'register'</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--        <div class="border-solid border-4 border-light-blue-500 bg-gray-300 rounded p-2">--}}
{{--            <div class="text-gray-400">--}}
{{--                If you see TWO reveals (login and register) $store is NOT working. If you see just ONE-AT-A-TIME that gets--}}
{{--            toggled depending upon the picked dropdown, then $store is working.--}}
{{--                <p>--}}
{{--                    History: Before alpine 3. We used spruce to store global alpine vars.  Now we use apline's built-in $store.--}}
{{--                </p>--}}
{{--                <p>--}}
{{--                    Troubleshooting: npm might need rebuilding. Try npm run dev or npm run prod--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        <div x-data>--}}
{{--            <div x-show="$store.showingModal.open === 'login'">--}}
{{--                <p>--}}
{{--                   [This is revealed if $store.sprucetest_modal.open === 'login']--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--        <div x-data>--}}
{{--            <div x-show="$store.showingModal.open === 'register'">--}}
{{--                <p>--}}
{{--                    [This is revealed if $store.sprucetest_modal.open === 'register']--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    <script>--}}
{{--        //https://alpinejs.dev/magics/store (was https://alpinejs.dev/magics/store)--}}
{{--        // document.addEventListener('alpine:init', () => {--}}
{{--        //     Alpine.store('sprucetest_modal', {--}}
{{--        //         open: 'login'--}}
{{--        //     })--}}
{{--        // })--}}

{{--    </script>--}}
</div>

