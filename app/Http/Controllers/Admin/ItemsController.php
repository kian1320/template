<?php

namespace App\Http\Controllers\Admin;

use App\Models\items;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\ItemsFormRequest;



class ItemsController extends Controller
{
    public function index()
    {
        $Items = Items::all();
        return view('admin.items.index', compact('Items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(ItemsFormRequest $request)

    {
        $data = $request->validated();

        $items = new Items;
        $items->name = $data['name'];
        $items->department = $data['department'];
        $items->type = $data['type'];
        $items->specification = $data['specification'];
        $items->software = $data['software'];
        $items->status = $data['status'];
        $items->created_by = Auth::user()->id;
        $items->save();

        return redirect('admin/items')->with('message', 'Item Added');
    }

    public function edit($items_id)
    {
        $items = Items::find($items_id);
        return view('admin.items.edit', compact('items'));
    }


    public function update(ItemsFormRequest $request, $items_id)
    {
        $data = $request->validated();

        $items = Items::find($items_id);
        $items->name = $data['name'];
        $items->department = $data['department'];
        $items->type = $data['type'];
        $items->specification = $data['specification'];
        $items->software = $data['software'];
        $items->status = $data['status'];
        $items->created_by = Auth::user()->id;
        $items->update();

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
