<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\user;

class DashboardController extends Controller
{
    public function index()
    {

        $items = Items::count();
        $users = User::where('role_as', '0')->count();
        $admins = User::where('role_as', '1')->count();


        return view('user.dashboard', compact('items', 'users', 'admins'));
    }
}
