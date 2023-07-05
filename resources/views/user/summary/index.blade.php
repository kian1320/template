@extends('layouts.usermaster')
@section('content')
@section('title', 'Financial Report')


<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="styles.css">
<div class="container-fluid">
    <br>
    <div class="card">
        <div class="card-header">
            <h4>View summary <a href="{{ 'add-summary' }}" class="btn btn-primary btn-sm float-end">Add sum</a></h4>
            <button onclick="window.print()">Print this page</button>
        </div>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif



        <div class="container-fluid">
            <table class="table">
                <tbody>
                    <!-- First Container -->
                    <tr>
                        <th scope="row">Month</th>
                        @foreach ($summary as $item)
                            <td>{{ \Carbon\Carbon::createFromFormat('m', $item->month)->format('F') }}
                                {{ $item->year }}
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <th scope="row">Starting balance:</th>
                        @foreach ($summary as $item)
                            <td>
                                <p>PHP: {{ number_format($item->beginbal ?? 0, 0, '.', ',') }}</p>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Second Container -->
                    <tr>
                        <th scope="row">Receipts</th>



                        <td>
                            <p>
                                @foreach ($previousMonthBudgets as $budget)
                                    <p>{{ $budget['budget_type'] }}
                                        {{ $budget['amount'] }}</p>
                                @endforeach
                            </p>
                        </td>
                        <td>
                            <p>
                                @foreach ($currentMonthBudgets as $budget)
                                    <p>{{ $budget['budget_type'] }} {{ $budget['amount'] }}</p>
                                @endforeach
                            </p>
                        </td>
                    </tr>
                    </td>

                    <tr>
                        <th scope="row">Total Starting</th>
                        @foreach ($summary as $item)
                            <td><strong> PHP: {{ number_format($item->totalstr, 0, '.', ',') }}.00</strong></td>
                        @endforeach
                    </tr>
                    <br>
                    <!-- Third Container -->
                    <tr>
                        <th scope="row">Expenses</th>

                    </tr>


                    @foreach ($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            @foreach ($months as $month)
                                @php
                                    $totalAmount = 0;
                                    if (isset($totalExpensesByType[$month])) {
                                        $expenseByType = $totalExpensesByType[$month]->keyBy('type_id');
                                        if ($expenseByType->has($type->id)) {
                                            $expense = $expenseByType[$type->id];
                                            $totalAmount = $expense->total_amount;
                                        }
                                    }
                                @endphp
                                <td>
                                    @if ($totalAmount > 0)
                                        {{ $totalAmount }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                    <tr>
                        <th scope="row">Total Expenses</th>
                        @foreach ($months as $month)
                            @php
                                $totalAmount = 0;
                                foreach ($totalExpensesByMonth as $expense) {
                                    if ($expense['month'] == $month) {
                                        $totalAmount = $expense['total_amount'];
                                        break;
                                    }
                                }
                            @endphp
                            <td>
                                PHP: {{ $totalAmount > 0 ? number_format($totalAmount, 0, '.', ',') : '-' }}
                            </td>
                        @endforeach
                    </tr>





                    <tr>
                        <th scope="row">Ending Balance</th>
                        @foreach ($summary as $item)
                            <td><strong> PHP: {{ number_format($item->aftexpenses, 0, '.', ',') }}.00</strong></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

    @endsection
