@extends('layouts.usermaster')
@section('content')
@section('title', 'Items')



<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<div class="container-fluid px-4">
    <br>
    <div class="card">
        <div class="card-header">
            <h4>View Items <a href="{{ 'add-items' }}" class="btn btn-primary btn-sm float-end">Add items</a></h4>
            <button onclick="window.print()">Print this page</button>
        </div>
        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <table id="Itemstable" class="table table-bordered">
                <thead>
                    <tr>

                        <th>Item Name</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Specification</th>
                        <th>Created by</th>
                        <th>Software</th>
                        <th>Stuatus</th>
                        <th>Repair History</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Items as $item)
                        <tr>

                            <td>{{ $item->name }}</td>
                            <td>{{ $item->department }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->specification }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->software }}</td>
                            <td>{{ $item->status }}</td>




                            <td align="center">
                                <a href="{{ url('user/repairs/' . $item->id) }}"
                                    class="btn btn-outline-primary">Add/View</a>

                            <td align="center">
                                <a href="{{ url('user/edit-items/' . $item->id) }}"
                                    class="btn btn-outline-success">Edit</a>

                            <td align="center">
                                <a href="{{ url('user/delete-items/' . $item->id) }}"
                                    class="btn btn-outline-danger">Delete</a>
                            </td>


                        </tr>
                    @endforeach
                </tbody>



            </table>

        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#Itemstable').DataTable();
    });
</script>
@endsection
