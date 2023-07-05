<?php

namespace App\Http\Controllers\User;

use App\Models\Repairs;
use App\Models\Items;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\RepairsFormRequest;

class RepairsController extends Controller
{
    public function index($repairs_id)
    {
        $item = Items::where('id', $repairs_id)->first();
        //->where('is_active', 1)

        //$Repairs = Repairs::where('item_id', $repairs_id)->get(['repair']);
        return view('user.repairs.index', ['repairs_id' => $repairs_id, 'Item' => $item]);
    }


    public function store(RepairsFormRequest $request)

    {
        $data = $request->validated();

        $repairs = new repairs;
        $repairs->item_id = $request->input('item_id');
        $repairs->repair = $data['repair'];
        $repairs->added_by = Auth::user()->id;
        $repairs->save();

        return redirect('user/repairs/' . $repairs->item_id)->with('message', 'Repair Added');
    }

    public function edit($repairs_id)
    {
        $Repairs = Repairs::find($repairs_id);
        return view('user.repairs.edit', compact('Repairs'));
    }


    public function update(RepairsFormRequest $request, $repairs_id)
    {
        $data = $request->validated();

        $repairs = Repairs::find($repairs_id);

        $repairs->repair = $data['repair'];
        $repairs->added_by = Auth::user()->id;
        $repairs->save();

        return redirect('user/repairs/' . $repairs->item_id)->with('message', 'Repair Updated');
    }

    public function destroy($repairs_id)
    {
        $repairs = Repairs::find($repairs_id);
        if ($repairs) {
            $repairs->delete();
            return redirect('user/repairs/' . $repairs->item_id)->with('message', 'Repair Deleted');
        } else {
            return redirect('user/repairs/' . $repairs->item_id)->with('message', 'Repair not Deleted');
        }
    }
}
