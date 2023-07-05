<?php

namespace App\Http\Controllers\User;

use App\Models\Expenses;
use App\Models\Types;
use App\Models\Summary;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ExpensesFormRequest;
use Mockery\Matcher\Type;

class ExpensesController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // Summary
        $Expenses = Expenses::where('created_by', $user->id)
            ->orderBy('id', 'desc')
            ->get();


        $total = $Expenses->sum('amount');


        return view('user.expenses.index', compact('total', 'Expenses'));
    }


    public function create()
    {
        $user = auth()->user();

        // Summary
        $Expenses = Expenses::where('created_by', $user->id)
            ->orderBy('id', 'desc')
            ->get();


        $total = $Expenses->sum('amount');

        $types = types::where('created_by', $user->id)->get();
        return view('user.expenses.create', compact('types', 'total', 'Expenses'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date_issued' => 'required',
            'voucher' => 'required',
            'check' => 'required',
            'encashment' => 'required',
            'description' => 'required',
            'type_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        // Find the corresponding summary based on the encashment month
        $encashmentMonth = date('n', strtotime($request->encashment)); // Use 'n' instead of 'm' for month without leading zero
        $encashmentYear = date('Y', strtotime($request->encashment));

        // Find the user's ID
        $userId = Auth::user()->id;

        // Find the summary for the current user and month
        $summaryCurrentMonth = Summary::where('created_by', $userId)
            ->where('month', $encashmentMonth)
            ->where('year', $encashmentYear)
            ->first();

        if ($summaryCurrentMonth) {
            // Create a new Expense record and associate it with the user's summary of the current month
            $expense = new Expenses();
            $expense->fill($validatedData);
            $expense->created_by = $userId;
            $expense->summary_id = $summaryCurrentMonth->id;
            $expense->save();

            // Deduct the expense amount from the user's current month's aftexpenses column
            $summaryCurrentMonth->aftexpenses -= $expense->amount;
            $summaryCurrentMonth->save();

            // Find the summary for the next month
            $nextMonth = $encashmentMonth + 1;
            $nextYear = $encashmentYear;
            if ($nextMonth > 12) {
                $nextMonth = 1;
                $nextYear++;
            }
            $summaryNextMonth = Summary::where('created_by', $userId)
                ->where('month', $nextMonth)
                ->where('year', $nextYear)
                ->first();

            if ($summaryNextMonth) {
                // Update the next month's totalsrt and aftexpenses
                $summaryNextMonth->totalstr -= $expense->amount;
                $summaryNextMonth->aftexpenses -= $expense->amount;
                $summaryNextMonth->save();
            }

            return redirect('user/expenses')->with('message', 'Expenses Added');
        } else {
            // Handle the case when the user's current month's summary does not exist
            // You can either throw an error, redirect, or handle it as needed
            // For example, you can return an error message
            return redirect('user/expenses')->with('error', 'No summary found for the given encashment month');
        }
    }





    public function edit($expenses_id)
    {
        $expense = Expenses::findOrFail($expenses_id);
        $types = Types::all();

        return view('user.expenses.edit', compact('expense', 'types'));
    }



    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'date_issued' => 'required',
            'voucher' => 'required',
            'check' => 'required',
            'encashment' => 'required',
            'description' => 'required',
            'type_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $expense = Expenses::findOrFail($id);

        // Find the corresponding summary based on the encashment month
        $encashmentMonth = date('n', strtotime($request->encashment)); // Use 'n' instead of 'm' for month without leading zero
        $encashmentYear = date('Y', strtotime($request->encashment));

        // Find the summary for the current month
        $summaryCurrentMonth = Summary::where('month', $encashmentMonth)
            ->where('year', $encashmentYear)
            ->first();

        if ($summaryCurrentMonth) {
            // Calculate the difference in expense amount
            $expenseDifference = $validatedData['amount'] - $expense->amount;

            // Update the current month's aftexpenses column
            $summaryCurrentMonth->aftexpenses += $expenseDifference;

            // Update the expense record
            $expense->fill($validatedData);
            $expense->save();

            // Find the summary for the previous month
            $previousMonth = $encashmentMonth - 1;
            $previousYear = $encashmentYear;
            if ($previousMonth < 1) {
                $previousMonth = 12;
                $previousYear--;
            }
            $summaryPreviousMonth = Summary::where('month', $previousMonth)
                ->where('year', $previousYear)
                ->first();

            if ($summaryPreviousMonth) {
                // Update the previous month's aftexpenses
                $summaryPreviousMonth->aftexpenses += $expenseDifference;
                $summaryPreviousMonth->save();
            }

            $summaryCurrentMonth->save();

            return redirect('user/expenses')->with('message', 'Expense Updated');
        } else {
            // Handle the case when the current month's summary does not exist
            // You can either throw an error, redirect, or handle it as needed
            // For example, you can return an error message
            return redirect('user/expenses')->with('error', 'No summary found for the given encashment month');
        }
    }









    public function destroy($expenses_id)
    {
        $expenses = Expenses::find($expenses_id);
        if ($expenses) {
            $expenses->delete();
            return redirect('user/expenses')->with('message', 'Expenses Deleted');
        } else {
            return redirect('user/expenses')->with('message', 'no item Id Found');
        }
    }
}
