<?php

namespace TallAndSassy\Ui\Glances\Samples\Modals;


use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base;


class GrokModalLepage extends PageGuideAdminController_Base
{
    public const viewRef = "tassy-ui::samples.Modals.GrokModalLepage";
    public static function getSlug(): string {
        return 'GrokModalLepage';
    }


}
