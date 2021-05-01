<div>

    <?php
    $dlWrapperShort = "sm:col-span-1";
    $dlWrapperLong = "sm:col-span-2";

    $dtWrapper = "text-sm leading-5 font-medium text-gray-500";

    $ddWrapper = "mt-1 text-sm leading-5 text-gray-900";

    $cardWrapper = "bg-white shadow overflow-hidden  sm:rounded-lg";

    $cardSectionBottom = "px-4 py-5 sm:px-6";

    $cardSection = "$cardSectionBottom border-b border-gray-200";
    ?>
    <div>


        <div class="{{ $cardWrapper }}">
            <div class="{{ $cardSection }}">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    App Information
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    {{config('tassy.app-branding.AppName', 'config/app-branding.AppName')}}
                </p>
            </div>
            <div class="{{ $cardSectionBottom }}">
                <dl class="grid grid-cols-1 col-gap-4 row-gap-8 sm:grid-cols-2">
                    {{--                    <div class="{{ $dlWrapperShort }}">--}}
                    {{--                        <dt class="{{ $dtWrapper }}">--}}
                    {{--                            SubSite Name:--}}
                    {{--                        </dt>--}}
                    {{--                        <dd class="{{ $ddWrapper }}">--}}
                    {{--                            Something--}}
                    {{--                        </dd>--}}
                    {{--                    </div>--}}
                    {{--      <div class="{{ $dlWrapperShort }}">--}}
                    {{--        <dt class="{{ $dtWrapper }}">--}}
                    {{--          School Type--}}
                    {{--        </dt>--}}
                    {{--        <dd class="{{ $ddWrapper }}">--}}
                    {{--          District--}}
                    {{--        </dd>--}}
                    {{--      </div>--}}
                    {{--                    <div class="{{ $dlWrapperShort }}">--}}
                    {{--                        <dt class="{{ $dtWrapper }}">--}}
                    {{--                            Webmaster Email address--}}
                    {{--                        </dt>--}}
                    {{--                        <dd class="{{ $ddWrapper }}">--}}
                    {{--                            gavin@example.com--}}
                    {{--                        </dd>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="{{ $dlWrapperShort }}">--}}
                    {{--                        <dt class="{{ $dtWrapper }}">--}}
                    {{--                            Webmaster Phone--}}
                    {{--                        </dt>--}}
                    {{--                        <dd class="{{ $ddWrapper }}">--}}
                    {{--                            617-555-0123--}}
                    {{--                        </dd>--}}
                    {{--                    </div>--}}
                    {{--      <div class="{{ $dlWrapperLong }}">--}}
                    {{--        <dt class="{{ $dtWrapper }}">--}}
                    {{--          School Twist's mission--}}
                    {{--        </dt>--}}
                    {{--        <dd class="{{ $ddWrapper }}">--}}
                    {{--          Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.--}}
                    {{--        </dd>--}}
                    {{--      </div>--}}
                    <div class="{{ $dlWrapperLong }}">
                        <dt class="{{ $dtWrapper }}">
                            Licenses
                        </dt>
                        <dd class="{{ $ddWrapper }}">
                            @include('tassy::licenses')
                        </dd>
                    </div>

                    <div class="{{ $dlWrapperLong }}">
                        <dt class="{{ $dtWrapper }}">
                            Version
                        </dt>
                        <dd class="{{ $ddWrapper }}">
                            @include('tassy::pretty-version')

                        </dd>
                    </div>


                </dl>
            </div>
        </div>
    </div>

</div>

