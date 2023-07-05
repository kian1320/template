<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BudgetController;
use App\Http\Controllers\User\ExpensesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\NewColController;
use App\Http\Controllers\User\BtypesController;
use App\Http\Controllers\User\TypesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\EncashmentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'App\Http\Controllers\HomeController@index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['isAdmin'])->group(function () {


    //pie
    Route::get('/dashboard', [App\Http\Controllers\Admin\ChartController::class, 'index']);

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //items
    Route::get('items', [App\Http\Controllers\Admin\ItemsController::class, 'index']);

    Route::get('add-items', [App\Http\Controllers\Admin\ItemsController::class, 'create']);

    Route::post('add-items', [App\Http\Controllers\Admin\ItemsController::class, 'store']);

    Route::get('edit-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'edit']);

    Route::put('update-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'update']);

    Route::get('delete-items/{items_id}', [App\Http\Controllers\Admin\ItemsController::class, 'destroy']);


    //repair
    Route::get('repairs/{repairs_id}', [App\Http\Controllers\Admin\RepairsController::class, 'index']);

    Route::get('repairs', [App\Http\Controllers\Admin\RepairsController::class, 'view']);

    Route::get('add-repairs', [App\Http\Controllers\Admin\RepairsController::class, 'create']);

    Route::post('add-repairs', [App\Http\Controllers\Admin\RepairsController::class, 'store']);

    Route::get('edit-repairs/{repairs_id}', [App\Http\Controllers\Admin\RepairsController::class, 'edit']);

    Route::put('update-repairs/{repairs_id}', [App\Http\Controllers\Admin\RepairsController::class, 'update']);

    Route::get('delete-repairs/{repairs_id}', [App\Http\Controllers\Admin\RepairsController::class, 'destroy']);

    //Route::get('repairs/{repairs_id}', [App\Http\Controllers\Admin\RepairsController::class, 'edit']);



    //users
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('edit-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'edit']);
    Route::put('update-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'update']);
    Route::get('delete-user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'destroy']);

    Route::get('/users/{user}/summary', [App\Http\Controllers\Admin\UserController::class, 'showUserSummary'])->name('user.summary');
    Route::get('showUserSummary-users/{user}', [App\Http\Controllers\Admin\UserController::class, 'showUserSummary'])->name('admin.user.summary');
    Route::get('/admin/users/{id}/summary', [App\Http\Controllers\Admin\UserController::class, 'userSummary'])->name('admin.users.summary');
});

//user side
Route::prefix('user')->middleware(['auth', 'isUser'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index']);
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


    //items
    Route::get('items', [App\Http\Controllers\User\ItemsController::class, 'index']);

    Route::get('add-items', [App\Http\Controllers\User\ItemsController::class, 'create']);

    Route::post('add-items', [App\Http\Controllers\User\ItemsController::class, 'store']);

    Route::get('edit-items/{items_id}', [App\Http\Controllers\User\ItemsController::class, 'edit']);

    Route::put('update-items/{items_id}', [App\Http\Controllers\User\ItemsController::class, 'update']);

    Route::get('delete-items/{items_id}', [App\Http\Controllers\User\ItemsController::class, 'destroy']);


    //repair
    Route::get('repairs/{repairs_id}', [App\Http\Controllers\User\RepairsController::class, 'index']);

    Route::get('repairs', [App\Http\Controllers\User\RepairsController::class, 'view']);

    Route::get('add-repairs', [App\Http\Controllers\User\RepairsController::class, 'create']);

    Route::post('add-repairs', [App\Http\Controllers\User\RepairsController::class, 'store']);

    Route::get('edit-repairs/{repairs_id}', [App\Http\Controllers\User\RepairsController::class, 'edit']);

    Route::put('update-repairs/{repairs_id}', [App\Http\Controllers\User\RepairsController::class, 'update']);

    Route::get('delete-repairs/{repairs_id}', [App\Http\Controllers\User\RepairsController::class, 'destroy']);

    //expenses
    Route::get('expenses', [App\Http\Controllers\User\ExpensesController::class, 'index']);

    Route::get('add-expenses', [App\Http\Controllers\User\ExpensesController::class, 'create'])->name('add-expenses');

    Route::post('add-expenses', [App\Http\Controllers\User\ExpensesController::class, 'store']);

    Route::get('edit-expenses/{expenses_id}', [App\Http\Controllers\User\ExpensesController::class, 'edit']);

    Route::put('update-expenses/{expenses_id}', [App\Http\Controllers\User\ExpensesController::class, 'update']);

    Route::get('delete-expenses/{expenses_id}', [App\Http\Controllers\User\ExpensesController::class, 'destroy']);

    Route::get('/expenses/create', [ExpensesController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{id}', [ExpensesController::class, 'update'])->name('expenses.update');






    //summary
    Route::get('summary', [App\Http\Controllers\User\SummaryController::class, 'index']);

    Route::get('add-summary', [App\Http\Controllers\User\SummaryController::class, 'create']);

    Route::post('add-summary', [App\Http\Controllers\User\BudgetController::class, 'store']);

    Route::get('edit-summary/{summary}', [App\Http\Controllers\User\SummaryController::class, 'edit']);

    Route::put('update-summary/{summary}', [App\Http\Controllers\User\SummaryController::class, 'update']);

    Route::get('delete-summary/{summary}', [App\Http\Controllers\User\SummaryController::class, 'destroy']);


    //budget
    // routes/web.php

    Route::get('/budget/create', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('/budget/store', [BudgetController::class, 'store'])->name('budget.store');




    //late encashment

    Route::get('lexpenses', [App\Http\Controllers\User\LexpensesController::class, 'index']);

    Route::get('add-lexpenses', [App\Http\Controllers\User\LexpensesController::class, 'create'])->name('add-lexpenses');

    Route::post('add-lexpenses', [App\Http\Controllers\User\LexpensesController::class, 'store'])->name('add-lexpenses');

    Route::get('edit-lexpenses/{lexpenses_id}', [App\Http\Controllers\User\LexpensesController::class, 'edit']);

    Route::put('update-lexpenses/{lexpenses_id}', [App\Http\Controllers\User\LexpensesController::class, 'update']);

    Route::get('delete-lexpenses/{lexpenses_id}', [App\Http\Controllers\User\LexpensesController::class, 'destroy']);


    //add column

    Route::get('/add-column', [NewColController::class, 'showForm'])->name('addColumnForm');
    Route::post('/add-column', [NewColController::class, 'addColumn'])->name('addColumn');


    //add budget  types
    Route::get('btypes', [App\Http\Controllers\User\BtypesController::class, 'index']);

    Route::get('add-btypes', [App\Http\Controllers\User\BtypesController::class, 'create']);

    Route::post('add-btypes', [App\Http\Controllers\User\BtypesController::class, 'store']);

    Route::get('edit-btypes/{btypes}', [App\Http\Controllers\User\BtypesController::class, 'edit']);

    Route::put('update-btypes/{btypes}', [App\Http\Controllers\User\BtypesController::class, 'update']);

    Route::get('delete-btypes/{btypes}', [App\Http\Controllers\User\BtypesController::class, 'destroy']);

    Route::get('/btypes', [BtypesController::class, 'index'])->name('btypes.index');


    //add expenses types
    Route::get('types', [App\Http\Controllers\User\TypesController::class, 'index']);

    Route::get('add-types', [App\Http\Controllers\User\TypesController::class, 'create']);

    Route::post('add-types', [App\Http\Controllers\User\TypesController::class, 'store']);

    Route::get('edit-types/{types}', [App\Http\Controllers\User\TypesController::class, 'edit']);

    Route::put('update-types/{types}', [App\Http\Controllers\User\TypesController::class, 'update']);

    Route::get('delete-types/{types}', [App\Http\Controllers\User\TypesController::class, 'destroy']);

    Route::get('/types', [TypesController::class, 'index'])->name('types.index');
});
