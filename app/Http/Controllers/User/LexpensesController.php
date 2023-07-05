<?php

namespace App\Http\Controllers\User;

use App\Models\Lexpenses;
use App\Models\Types;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\LexpensesFormRequest;
use Mockery\Matcher\Type;

class LexpensesController extends Controller
{

    public function index()
    {


        $user = auth()->user();

        // Summary
        $Lexpenses = Lexpenses::where('created_by', $user->id)
            ->orderBy('id', 'desc')
            ->get();



        return view('user.lexpenses.index', compact('Lexpenses'));
    }


    public function create()
    {

        $types = Types::all();
        return view('user.lexpenses.create', compact('types'));
    }


    public function store(LexpensesFormRequest $request)

    {

        $data = $request->validated();

        $lexpenses = new Lexpenses;
        $lexpenses->date_issued = $data['date_issued'];
        $lexpenses->voucher = $data['voucher'];
        $lexpenses->check = $data['check'];
        $lexpenses->encashment = $data['encashment'];
        $lexpenses->description = $data['description'];
        $lexpenses->type_id = $data['type_id'];
        $lexpenses->amount = $data['amount'];
        $lexpenses->created_by = Auth::user()->id;
        $lexpenses->save();

        return redirect('user/lexpenses')->with('message', 'Expenses Added');
    }


    public function edit($lexpenses_id)
    {
        $lexpenses = Lexpenses::find($lexpenses_id);

        $types = Types::all();


        return view('user.lexpenses.edit', compact('lexpenses', 'types'));
    }


    public function update(LexpensesFormRequest $request, $expenses_id)
    {
        $data = $request->validated();

        $lexpenses = Lexpenses::find($expenses_id);
        $lexpenses->date_issued = $data['date_issued'];
        $lexpenses->voucher = $data['voucher'];
        $lexpenses->check = $data['check'];
        $lexpenses->encashment = $data['encashment'];
        $lexpenses->description = $data['description'];
        $lexpenses->type_id = $data['type_id'];
        $lexpenses->amount = $data['amount'];
        $lexpenses->created_by = Auth::user()->id;
        $lexpenses->update();

        return redirect('user/lexpenses')->with('message', 'Expenses updated');
    }


    public function destroy($Lexpenses_id)
    {
        $Lexpenses = Lexpenses::find($Lexpenses_id);
        if ($Lexpenses) {
            $Lexpenses->delete();
            return redirect('user/expenses')->with('message', 'Expenses Deleted');
        } else {
            return redirect('user/expenses')->with('message', 'no item Id Found');
        }
    }
}
