<?php

namespace TallAndSassy\Tenancy\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//class SupserAdminDashboard extends \TallAndSassy\PageGuideAdmin\Http\Controllers\Admin\PageGuideAdminController_Base
//{
//    //
//}



class SuperAdminIndexController extends Controller
{
    public static function getThisView(): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('tassy::superadmin/index', ['blah'=>'A']);
    }

}
