@extends('layouts.usermaster')
@section('content')
@section('title', 'Financial Report')

<link rel="stylesheet" href="//cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<style>
    .rectangle {
        height: 200px;
        width: 350px;
        margin-left: 10px;
        border-style: solid;
        align-content: center;
    }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">HELLO</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">{{ strtoupper(Auth::user()->name) }}</li>
    </ol>
</div>




@endsection
