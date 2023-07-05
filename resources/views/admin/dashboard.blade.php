@extends('layouts.master')
@section('content')
@section('title', 'Inventory')
<script src="
https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js
"></script>
<div class="container-fluid px-4">


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
