@extends('layouts.app')

@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ol>
                            <li><a href="{{route('createProduct')}}">Product</a></li>
                            <li><a href="{{route('createEmployee')}}">Employee</a></li>
                            <li><a href="{{route('createFilter')}}">Filter</a></li>
                            <li><a href="{{route('createEmployeeFilter')}}">Employee Filter</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
