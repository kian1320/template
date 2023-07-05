<?php

namespace App\Http\Controllers\User;

use App\Models\Btypes;
use App\Models\Summary;
use App\Models\Expenses;
use App\Models\Types;
use App\Models\Budget;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SummaryController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get the expenses types created by the user
        $userExpenseTypes = Types::where('created_by', $user->id)->pluck('id');

        // Fetch the expense types
        $types = Types::whereIn('id', $userExpenseTypes)->get();

        // Summary
        $summary = Summary::where('created_by', $user->id)
            ->orderBy('month', 'desc')
            ->get()
            ->take(2)
            ->reverse();

        $currentMonthSummary = Summary::where('created_by', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        $currentMonthBudgets = [];
        if ($currentMonthSummary) {
            $currentMonthBudgets = Budget::where('summary_id', $currentMonthSummary->id)
                ->where('created_by', $user->id)
                ->get()
                ->map(function ($budget) {
                    return [
                        'budget_type' => $budget->budgetType->name,
                        'amount' => $budget->amount,
                    ];
                });
        }

        $previousMonthBudgets = [];
        if ($currentMonthSummary) {
            $previousMonthSummary = Summary::where('created_by', $user->id)
                ->where('id', '<', $currentMonthSummary->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($previousMonthSummary) {
                $previousMonthBudgets = Budget::where('summary_id', $previousMonthSummary->id)
                    ->where('created_by', $user->id)
                    ->get()
                    ->map(function ($budget) {
                        return [
                            'budget_type' => $budget->budgetType->name,
                            'amount' => $budget->amount,
                        ];
                    });
            }
        }


        // Retrieve all unique months from the expenses
        $months = Expenses::where('created_by', $user->id)
            ->select(DB::raw('MONTH(encashment) as month'))
            ->groupBy('month')
            ->pluck('month')
            ->sort()
            ->values()
            ->all();

        // Calculate the current month and the previous month
        $currentMonth = date('n');
        $previousMonth = ($currentMonth - 1) > 0 ? ($currentMonth - 1) : 12;

        // Retrieve the expenses for each month
        $totalExpensesByType = [];

        foreach ($months as $month) {
            $expenses = Expenses::where('created_by', $user->id)
                ->whereMonth('encashment', $month)
                ->whereIn('type_id', $userExpenseTypes)
                ->select('type_id', DB::raw('SUM(amount) as total_amount'))
                ->groupBy('type_id')
                ->get();

            $totalExpensesByType[$month] = $expenses;
        }

        // Fill in any missing months with empty expenses
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($totalExpensesByType[$i])) {
                $totalExpensesByType[$i] = collect();
            }
        }
        ksort($totalExpensesByType);

        // Total expenses per month
        $expensesByMonth = Expenses::where('created_by', $user->id)
            ->whereIn('type_id', $userExpenseTypes) // Filter expenses by user's types
            ->selectRaw('YEAR(encashment) as year, MONTH(encashment) as month, SUM(amount) as total_amount')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->take(2)
            ->reverse(); // Get the last two months and reverse the order

        $totalExpensesByMonth = [];

        // Loop through the expenses by month and populate the total expenses array
        foreach ($expensesByMonth as $expense) {
            $year = $expense->year;
            $month = $expense->month;
            $totalAmount = $expense->total_amount;

            $totalExpensesByMonth[] = [
                'year' => $year,
                'month' => $month,
                'total_amount' => $totalAmount,
            ];
        }

        return view('user.summary.index', compact(
            'summary',
            'months',
            'types',
            'currentMonthBudgets',
            'previousMonthBudgets',
            'totalExpensesByMonth',
            'totalExpensesByType',
            'user'
        ));
    }







    public function create()
    {
        $user = Auth::user();
        $btypes = btypes::where('created_by', $user->id)->get();
        return view('user.summary.create', compact('btypes'));
    }
}
