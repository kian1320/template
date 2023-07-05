<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Models\Types;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $types = types::where('created_by', $user->id)->get();
        return view('user.types.index', compact('types'));
    }

    public function create()
    {

        $types = types::all();
        return view('user.types.create', compact('types'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $types = new types();
        $types->name = $request->name;
        $types->created_by = $user->id; // Assign the authenticated user's ID to the created_by field
        $types->save();

        // Optionally, you can redirect to another page after successful store
        return redirect('user/types')->with('message', 'Added');
    }


    public function edit($items_id)
    {
        $types = types::find($items_id);
        return view('user.types.edit', compact('types'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $types = types::findOrFail($id);
        $types->name = $request->name;
        $types->save();

        // Optionally, you can redirect to another page after successful update
        return redirect('user/types')->with('message', 'Type updated');
    }


    public function destroy($id)
    {
        $types = types::findOrFail($id);
        $types->delete();

        // Optionally, you can redirect to another page after successful deletion
        return redirect('user/types')->with('message', 'Btype deleted successfully');
    }
}
