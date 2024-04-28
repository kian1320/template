<?php

namespace App\Http\Controllers\Admin;

use App\Models\items;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class ItemsController extends Controller
{
    public function index()
    {
        $Items = Items::all();
        foreach ($Items as $item) {
            $item->photo_url = $item->photo ? Storage::url($item->photo) : null;
        }
        return view('admin.items.index', compact('Items'));
    }
    public function create()
    {
        return view('admin.items.create');
    }



    public function store(Request $request)
    {
        // Validate the form data including the file upload
        $validatedData = $request->validate([
            'name' => 'required|string',
            'department' => 'required|string',
            'type' => 'required|in:select,computer,printer,other',
            'specification' => 'nullable|string',
            'software' => 'nullable|string',
            'status' => 'required|in:select,functional,defective,repairing',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow jpeg, png, jpg, gif files up to 2MB
        ]);
    
        // Handle file upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getClientOriginalName(); // Use original file name
            $photo->move(public_path('img'), $filename); // Move the file to the public/img directory
            $validatedData['photo'] = 'img/' . $filename; // Save the file path in the database
        }
    
        // Create a new item
        $item = new Items();
        $item->name = $validatedData['name'];
        $item->department = $validatedData['department'];
        $item->type = $validatedData['type'];
        $item->specification = $validatedData['specification'];
        $item->software = $validatedData['software'];
        $item->status = $validatedData['status'];
        $item->photo = $validatedData['photo'] ?? null; // Assign the file path to the 'photo' attribute
        $item->created_by = auth()->id(); // Assuming you're using authentication
        $item->save();
    
        return redirect()->back()->with('success', 'Item added successfully!');
    }



    public function edit($items_id)
    {
        $items = Items::find($items_id);
        return view('admin.items.edit', compact('items'));
    }


    public function update(Request $request, $items_id)
    {
        // Validate the form data including the file upload
        $validatedData = $request->validate([
            'name' => 'required|string',
            'department' => 'required|string',
            'type' => 'required|in:select,computer,printer,other',
            'specification' => 'nullable|string',
            'software' => 'nullable|string',
            'status' => 'required|in:select,functional,defective,repairing',
            // Add validation rules for photo if needed
        ]);
    
        // Find the item by its ID
        $item = Items::findOrFail($items_id);
    
        // Update the item with the validated data
        $item->name = $validatedData['name'];
        $item->department = $validatedData['department'];
        $item->type = $validatedData['type'];
        $item->specification = $validatedData['specification'];
        $item->software = $validatedData['software'];
        $item->status = $validatedData['status'];
        // Update the 'created_by' attribute if necessary
        $item->created_by = Auth::user()->id; // Assuming you're using authentication
        $item->save();
    
        return redirect('admin/items')->with('message', 'Item updated');
    }

    public function destroy($items_id)
    {
        $items = Items::find($items_id);
        if ($items) {
            $items->delete();
            return redirect('admin/items')->with('message', 'Item Deleted');
        } else {
            return redirect('admin/items')->with('message', 'no item Id Found');
        }
    }
}
