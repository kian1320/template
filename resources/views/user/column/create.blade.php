@extends('layouts.usermaster')
@section('content')
@section('title', 'items')



<div class="container-fluid px-4">
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="">Add source of income</h4>
        </div>
        <div class="cardbody">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <form action="{{ route('addColumn') }}" method="POST">
                @csrf
                <label for="">source</label>
                <input type="text" name="column_name" placeholder="Column Name">
                <!-- Rest of your form fields -->
                <button type="submit">Submit</button>
            </form>

        </div>

    </div>

</div>




@endsection
