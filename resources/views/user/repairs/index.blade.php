@extends('layouts.usermaster')
@section('content')
@section('title', 'Repairs')



<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<div class="container-fluid px-4">
    <br>
    <div class="card">
        <div class="card-header">
            <h4> Add Repair History to {{ strtoupper($Item->name) }}<a href="{{ URL::to('/') }}/user/items"
                    class="btn btn-primary btn-sm float-end">View items</a>
            </h4>
        </div>
        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>

                        <th scope="col">Add repair History</th>
                        <th style="width:50%">repair history records</th>
                    </tr>
                </thead>
                <tbody>


                    <td>
                        <form method="post" action="{{ URL::to('/') }}/user/add-repairs">
                            <input type="hidden" name="item_id" value="{{ $repairs_id }}">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Enter text
                                    Here</label>
                                <textarea class="form-control" name="repair" rows="7"></textarea>
                                <br>
                                <button type="submit" class="btn btn-outline-primary">submit</button>


                            </div>
                        </form>
                    </td>



                    <td>
                        <table id="Itemstable" class="table table-bordered">
                            <thead>
                                <tr>

                                    <th>Repairs</th>
                                    <th>Date Added</th>

                                    <th>edit</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Item->repairs as $item)
                                    <tr>

                                        <td>{{ $item->repair }}</td>
                                        <td>{{ $item->created_at->format('m-d-Y') }}</td>

                                        <td>
                                            <a href="{{ url('user/edit-repairs/' . $item->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>

                                            <a href="{{ url('user/delete-repairs/' . $item->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>



                        </table>

                    </td>






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
