<?php

namespace App\Http\Controllers\Admin;

use App\Models\items;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EchartController extends Controller
{
    public function echart(Request $request)
    {
        $computer = Items::where('type', 'computer')->get();
        $printer = Items::where('type', 'printer')->get();
        $other = Items::where('type', 'other')->get();
        $computer_count = count($computer);
        $printer_count = count($printer);
        $other_count = count($other);
        return view('admin.items.index', compact('computer_count', 'printer_count', 'other_count'));
    }
}
