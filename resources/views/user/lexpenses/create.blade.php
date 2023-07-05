@extends('layouts.usermaster')
@section('content')
@section('title', 'Financial Report')

<div class="container-fluid px-4">
    <h1 class="mt-4">Add Late encashment</h1>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<form action="{{ route('add-lexpenses') }}" method="POST">
    @csrf

    <div class="container-fluid">
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
</form>




@endsection
