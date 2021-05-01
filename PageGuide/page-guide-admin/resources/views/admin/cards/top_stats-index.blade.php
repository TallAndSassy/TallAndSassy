<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        @include('tassy::admin.dashboard.top-stats-label')
    </h3>
    @php
        #$viewRef = 'tassy::cards.num-users';
        $arrCards = \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\DashboardController::singleton('TopStats')->getAll();

    @endphp
    @if(count($arrCards) == 0)
        <div class="text-gray-400">N/A</div>
        @if (App::environment(['local']))
        <!-- Try adding \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\DashboardController::singleton('TopStats')->push(\TallModSassy\AdminUsers\Http\Livewire\Cards\NumUsers::class); to /app/Providers/AppServiceProvider/book -->
        @endif

    @else
        <div class="mt-1 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow md:grid-cols-{{count($arrCards)}}">
            @foreach ($arrCards as $slot=>$classNameForCard)
                @if ($slot == 0) {{--  First--}}
                <div class="px-4  ">
                @elseif ($slot == (count($arrCards) - 1)) {{--  Last--}}
                <div class="border-t border-gray-200 md:border-0 md:border-l">
                @else {{--  Middles --}}
                <div class="border-t border-gray-200 md:border-0 md:border-l">
                @endif
                    <div>
@php
$viewRef = $classNameForCard::$viewRef;
#dd($viewRef);
@endphp
                        @livewire($classNameForCard::$viewRef, [], key(uniqid()))
{{--                        @livewire($card->viewRef, ['title'=>'blah'], key(uniqid())--}}
{{--                        <livewire:tassy::cards.simple-stat title="Something" value="{{$slot}}"--}}
{{--                                                           key="{{uniqid()}}"/>--}}
                    </div>
                </div>

                {{--    <div class="border-t border-gray-200 md:border-0 md:border-l">--}}
                {{--        <livewire:tassy::cards.num-users/>--}}
                {{--    </div>--}}

                {{--    <div class="border-t border-gray-200 md:border-0 md:border-l">--}}
                {{--        <livewire:tassy::cards.simple-stat title="Offered Classes" qualifier="all" value="4"/>--}}
                {{--    </div>--}}

            @endforeach
        </div>
    @endif
</div>

{{--                <div class="mt-1 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow md:grid-cols-3">--}}
{{--    <div>--}}
{{--      <div class="px-4 py-5 sm:p-6">--}}
{{--        <dl>--}}
{{--          <dt class="text-base leading-6 font-normal text-gray-900">--}}
{{--            Available Courses--}}
{{--              <span class="text-sm leading-5 font-medium text-gray-500">(in course library)</span>--}}

{{--          </dt>--}}
{{--          <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">--}}
{{--            <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-600">--}}
{{--                tyry--}}

{{--            </div>--}}

{{--          </dd>--}}
{{--        </dl>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <div class="border-t border-gray-200 md:border-0 md:border-l">--}}
{{--      <div class="px-4 py-5 sm:p-6">--}}
{{--        <dl>--}}
{{--          <dt class="text-base leading-6 font-normal text-gray-900">--}}
{{--            Number of Users--}}
{{--          </dt>--}}
{{--          <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">--}}
{{--            <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-600">--}}
{{--             2345--}}

{{--            </div>--}}

{{--          </dd>--}}
{{--        </dl>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--    <div class="border-t border-gray-200 md:border-0 md:border-l">--}}
{{--      <div class="px-4 py-5 sm:p-6">--}}
{{--        <dl>--}}
{{--          <dt class="text-base leading-6 font-normal text-gray-900">--}}
{{--              Offered Classes <span class="text-sm leading-5 font-medium text-gray-500">(all)--}}
{{--              </span>--}}
{{--          </dt>--}}
{{--          <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">--}}
{{--            <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-600">--}}
{{--              5678--}}

{{--            </div>--}}

{{--          </dd>--}}
{{--        </dl>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>
--}}
