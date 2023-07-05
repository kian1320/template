<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use App\Models\Btypes;
use App\Models\Budget;
use App\Models\Summary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\BudgetFormRequest;


class BudgetController extends Controller
{

    public function create()
    {
        $user = auth()->user();
        // Fetch budget types
        $btypes = Btypes::all();

        return view('user.budget.create', compact('btypes'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'type' => 'required',
            'budgets' => 'required|array',
            'budgets.*' => 'nullable|numeric',
        ]);

        // Get the last month's summary for the current user
        $lastMonthSummary = Summary::where('created_by', auth()->id())
            ->orderBy('id', 'desc')
            ->first();

        // Calculate the previous month's total aftexpenses
        $previousAftExpenses = 0;
        $beginBal = 0;
        if ($lastMonthSummary) {
            $previousAftExpenses = $lastMonthSummary->aftexpenses;
            $beginBal = $lastMonthSummary->aftexpenses;
        }



        // Create a new Summary record
        $summary = Summary::create([
            'month' => $request->month,
            'year' => $request->year,
            'type' => $request->type,
            'created_by' => auth()->id(),
            'aftexpenses' => $previousAftExpenses, // Set previous total aftexpenses
            'beginbal' => $beginBal, // Set previous month's aft expenses as beginbal or 0 if new user
        ]);

        // Retrieve the budget types
        $budgetTypes = Btypes::all();

        // Calculate the total budget
        $totalBudget = 0;

        foreach ($budgetTypes as $budgetType) {
            $budgetAmount = isset($request->budgets[$budgetType->id]) ? $request->budgets[$budgetType->id] : null;

            if ($budgetAmount && is_numeric($budgetAmount)) {
                $totalBudget += $budgetAmount;

                Budget::create([
                    'summary_id' => $summary->id,
                    'btypes_id' => $budgetType->id,
                    'amount' => $budgetAmount,
                    'created_by' => auth()->id(),
                ]);
            }
        }

        // Update the summary with the total budget
        $summary->totalstr = $totalBudget + $previousAftExpenses;
        $summary->aftexpenses = $totalBudget + $previousAftExpenses;
        $summary->save();

        return redirect('user/summary')->with('message', 'Expenses Added');
    }
}
