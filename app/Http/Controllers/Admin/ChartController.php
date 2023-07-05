<?php

namespace App\Http\Controllers\admin;

use App\Models\items;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function pieChart()
    {
        $result = items::select(items::raw("SELECT status FROM items"));
        dd($result);

        return view('admin.items.index');
    }
}
