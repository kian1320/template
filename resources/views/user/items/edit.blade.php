@extends('layouts.usermaster')
@section('content')
@section('title', 'items')



<div class="container-fluid px-4">
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="">Edit Item</h4>
        </div>
        <div class="cardbody">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('user/update-items/' . $items->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="">Item Name</label>
                    <input type="text" name="name" value="{{ $items->name }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Department</label>
                    <input type="text" name="department" value="{{ $items->department }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Type</label>
                    <select type="text" name="type" value="{{ $items->type }}" class="form-control">
                        <option value="{{ $items->type }}" selected>{{ $items->type }}</option>
                        <option value="computer">Computer</option>
                        <option value="printer">Printer</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">specification</label>
                    <input type="text" name="specification" value="{{ $items->specification }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">software</label>
                    <input type="text" name="software" value="{{ $items->software }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">status</label>
                    <select type="text" name="status" value="{{ $items->status }}" class="form-control">
                        <option value="{{ $items->status }}" selected>{{ $items->status }}</option>
                        <option value="functional">functional</option>
                        <option value="defective">Defective</option>
                        <option value="repairing">Repairing</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Created by</label>
                    <input type="text" name="created_by" value="{{ $items->created_by }}"
                        readonly="true"class="form-control">
                </div>





                <div class="mb-3">

                    <button type="submit" class="btn btn-success">Submit</button>
                </div>





            </form>

        </div>

    </div>

</div>




@endsection
