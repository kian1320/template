@extends('layouts.usermaster')
@section('content')
@section('title', 'Financial Report')


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







            </tbody>



        </table>
        <div>


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
