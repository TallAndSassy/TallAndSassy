<div class="px-4 py-5 sm:p-6">
    <dl>
        <dt class="text-base leading-6 font-normal text-gray-900">
            {!! $title !!}
            @if (!empty($qualifier))
                <span class="text-sm leading-5 font-medium text-gray-500">({!! $qualifier !!})</span>
            @endif

        </dt>
        <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
            <div class="flex items-baseline text-2xl leading-8 font-semibold text-indigo-600">
                {!! $value !!}
            </div>

        </dd>
    </dl>
</div>
