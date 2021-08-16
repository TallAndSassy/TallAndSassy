<?php

namespace TallAndSassy\Tenancy\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TenantsDirectory extends Controller
{
    public static function render()//: \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('tassy::tenants_directory', ['blah'=>'A']);
    }
}
