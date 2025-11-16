<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Master\IndustryType;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = 'Dashboard';
        return view('dashboard', compact('breadcrumb'));
    }
}
