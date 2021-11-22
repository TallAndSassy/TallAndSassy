<?php

namespace TallAndSassy\Ui\Glances\Samples\Code;

use Illuminate\Http\Request;
use TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\DashboardController;

class CodeHomeTabbedPageController  extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
{

    public const viewRef = "tassy-ui::samples/Code/CodeHome";//tassy-ui::samples/Code/CodeHome";tassy-ui::samples/TabSamples/TabSample0__Page
    public static string $title = 'Prettifying Code';
    public function getBodyView(string $subLevels) : \Illuminate\View\View
    {
        if (1) { // Let's tell Laravel to look for files right next to us, not in the /app/resources/views dir.  FYI: Once out of stub phpase, this 'if' statement is clearly stooopid and can be deleted.
            \Illuminate\Support\Facades\View::getFinder()->addLocation( __DIR__ . '/resources/views'); // Shop Local for your blade files  https://stackoverflow.com/a/27461966/93933
        }

        return view(static::viewRef);
    }

    private static array $mes;
    public static function singleton(string $handle) : self
    {
        if (! isset(static::$mes[$handle])) {
            static::$mes[$handle] = new self();
        }

        return static::$mes[$handle];
    }

}
