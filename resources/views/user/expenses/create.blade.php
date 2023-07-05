@extends('layouts.usermaster')
@section('content')
@section('title', 'Financial Report')



@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ route('add-expenses') }}" method="POST">
    @csrf
    <br>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4>Add Expenses</h4>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    <label for="date_issued">Date issued</label>
                    <input type="date" name="date_issued" id="date_issued" class="form-control">
                </div>
                <div class="col-sm-1">
                    <label for="voucher">Voucher</label>
                    <input type="text" name="voucher" id="voucher" class="form-control">
                </div>
                <div class="col-sm-1">
                    <label for="check">Check</label>
                    <input type="text" name="check" id="check" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="encashment">Encashment</label>
                    <input type="date" name="encashment" id="encashment" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" class="form-control">
                </div>
                <div class="col-sm-2">
                    <label for="type_id">Type</label>
                    <select name="type_id" id="type_id" class="form-control">
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-1">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" id="amount" class="form-control">
                </div>


                <div class="col-sm-1">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>


<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<div class="container-fluid">
    <br>
    <div class="card">
        <div class="card-header">
            <h4>View Items <a href="{{ 'add-expenses' }}" class="btn btn-primary btn-sm float-end">Add Expenses</a></h4>

        </div>

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <table id="Itemstable" class="table table-bordered table-striped">

            <thead>
                <tr>

                    <th>Date_issued</th>
                    <th>Voucher</th>
                    <th>Check</th>
                    <th>Encashment</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Edit</th>



                </tr>
            </thead>
            <tbody>
                @foreach ($Expenses as $item)
                    <tr>

                        <td>{{ \Carbon\Carbon::parse($item->date_issued)->format('M j Y') }}</td>
                        <td>{{ $item->voucher }}</td>
                        <td>{{ $item->check }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->encashment)->format('M j Y') }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->type->name }}</td>
                        <td> PHP: {{ number_format($item->amount, 0, '.', ',') }}.00</td>


                        <td align="center">
                            <a href="{{ url('user/edit-expenses/' . $item->id) }}"
                                class="btn btn-success btn-sm">Edit</a>
                        </td>





                    </tr>
                @endforeach
            </tbody>



        </table>
        <div>

            <p id="totalDisplay"> <strong> Total: PHP {{ number_format($total, 0, '.', ',') }}.00</strong></p>
            <button onclick="window.print()">Print this page</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#Itemstable').DataTable({
            // DataTable options...
            // ...
            "initComplete": function() {
                calculateSum();
            },
            "drawCallback": function() {
                calculateSum();
            }
        });

        function calculateSum() {
            if (table && table.rows) {
                var sum = 0; // Initialize the sum variable
                var filteredData = table.rows({
                    search: 'applied'
                }).data();

                table.rows({
                    search: 'applied'
                }).data().each(function(row) {
                    var amount = parseFloat(row['amount']);
                    console.log('Amount:', amount); // Add this line for debugging

                    if (!isNaN(amount)) {
                        sum += amount;
                    }
                });

                console.log('Sum:', sum); // Add this line for debugging

                $('#totalDisplay').text(sum.toFixed(
                    2)); // Replace #totalDisplay with the element where you want to display the sum
            }
        }
    });
</script>

@endsection
