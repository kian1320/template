@extends('layouts.app')

@section('content')
    <style>
        .dark:bg-gray-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity));
        }

        .dark:bg-gray-900 {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity));
        }

        .dark:text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity));
        }
    </style>


    <div class="container dark:bg-gray-800">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card dark:bg-gray-900">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body dark:text-white">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
