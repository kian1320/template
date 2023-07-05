<?php

namespace App\Http\Controllers\Admin;


use App\Models\Expenses;
use App\Models\Types;
use App\Models\Budget;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     public function index()
     {
          $users = User::where('role_as', '!=', 1)->get();
          return view('admin.user.index', compact('users'));
     }

     public function showUserSummary(User $user)
     {

          $types = Types::where('created_by', $user->id)->get();
          $users = User::all();
          // Get the expense types created by the user
          $userExpenseTypes = Types::where('created_by', $user->id)->pluck('id');

          // Summary
          $summary = Summary::where('created_by', $user->id)
               ->orderBy('month', 'desc')
               ->get()
               ->reverse();

          // Budget for the month
          // Retrieve all unique months from the budgets
          $months = Budget::where('created_by', $user->id)
               ->select(DB::raw('MONTH(created_at) as month'))
               ->groupBy('month')
               ->pluck('month')
               ->sort()
               ->values()
               ->all();

          // Retrieve the budgets for each month
          $budgetsByMonth = [];

          foreach ($months as $month) {
               $budgets = Budget::where('created_by', $user->id)
                    ->whereMonth('created_at', $month)
                    ->get()
                    ->map(function ($budget) {
                         return [
                              'budget_type' => $budget->budgetType->name,
                              'amount' => $budget->amount,
                         ];
                    });

               $budgetsByMonth[$month] = $budgets;
          }

          // Total amount of expenses for the month per type
          // Retrieve all unique months from the expenses
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
               ->selectRaw('YEAR(encashment) as year, MONTH(encashment) as month, SUM(amount) as total_amount')
               ->whereIn('type_id', $userExpenseTypes)
               ->groupBy('year', 'month')
               ->orderBy('year', 'desc')
               ->orderBy('month', 'desc')
               ->get();

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

          // Expenses
          $twoMonthsAgo = Carbon::now()->subMonths(2)->startOfMonth();
          $expenses = Expenses::where('created_at', '>=', $twoMonthsAgo)
               ->whereIn('type_id', $userExpenseTypes)
               ->orderBy('created_at', 'desc')
               ->get()
               ->reverse();

          return view('admin.user.summary', compact(
               'summary',
               'months',
               'types',
               'budgetsByMonth',
               'expenses',
               'totalExpensesByMonth',
               'totalExpensesByType',
               'user'
          ));
     }




     public function edit($user_id)
     {
          $users = user::find($user_id);
          return view('admin.user.edit', compact('users'));
     }

     public function update(Request $request, $user_id)
     {

          $user = User::find($user_id);
          if ($user) {

               $user->name = $request->name;
               $user->email = $request->email;
               $user->role_as = $request->role_as;
               $user->update();
               return redirect('admin/users')->with('message', 'update successs');
          }
          return redirect('admin/users')->with('message', 'no user found');
     }



     public function destroy($user_id)
     {
          $user = User::find($user_id);
          if ($user) {
               $user->delete();
               return redirect('admin/users' . $user->user_id)->with('message', 'User Deleted');
          } else {
               return redirect('admin/users' . $user->user_id)->with('message', 'User not Deleted');
          }
     }
}
