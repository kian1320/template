@extends('layouts.master')
@section('content')
@section('title', 'Edit Users')



<div class="container-fluid px-4">
    <div class="card mt-3">
        <div class="card-header">
            <h4 class="">Edit Users</h4>
        </div>
        <div class="cardbody">

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form action="{{ url('admin/update-user/' . $users->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" value="{{ $users->name }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Email</label>
                    <input type="text" name="email" value="{{ $users->email }}" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Created at</label>
                    <input type="text" name="created_at" value="{{ $users->created_at->format('d/m/Y') }}"
                        readonly="true" class="form-control">
                </div>


                <div class="mb-3">
                    <label for="">role as</label>
                    <select name="role_as" class="form-control">
                        <option value="1" {{ $users->role_as == '1' ? 'selected' : '' }}>Admin</option>
                        <option value="0" {{ $users->role_as == '0' ? 'selected' : '' }}>User</option>

                    </select>

                </div>

                <div class="mb-3">

                    <button type="submit" class="btn btn-success">Save Update</button>
                </div>





            </form>

        </div>

    </div>

</div>
@endsection
