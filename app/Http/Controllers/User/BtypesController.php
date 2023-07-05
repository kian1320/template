<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Btypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BtypesController extends Controller
{



    public function index()
    {
        $user = Auth::user();
        $btypes = btypes::where('created_by', $user->id)->get();
        return view('user.btypes.index', compact('btypes'));
    }

    public function create()
    {

        $btypes = btypes::all();
        return view('user.btypes.create', compact('btypes'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $btypes = new Btypes();
        $btypes->name = $request->name;
        $btypes->created_by = $user->id; // Assign the authenticated user's ID to the created_by field
        $btypes->save();

        // Optionally, you can redirect to another page after successful store
        return redirect('user/btypes')->with('message', 'Added');
    }


    public function edit($items_id)
    {
        $btypes = btypes::find($items_id);
        return view('user.btypes.edit', compact('btypes'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $btype = Btypes::findOrFail($id);
        $btype->name = $request->name;
        $btype->save();

        // Optionally, you can redirect to another page after successful update
        return redirect('user/btypes')->with('message', 'Type updated');
    }


    public function destroy($id)
    {
        $btype = Btypes::findOrFail($id);
        $btype->delete();

        // Optionally, you can redirect to another page after successful deletion
        return redirect('user/btypes')->with('message', 'Btype deleted successfully');
    }
}
