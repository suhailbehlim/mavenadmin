
@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <img src="{{ Auth::user()->avtar }}" alt="{{ Auth::user()->avtar }}" style="border: 1px solid #ccc; border-radius:5px; width:39px; height:auto;float:left;margin-right:7px;" > --}}
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                     Hi there, regular user
                </div>
            </div>
        </div>
    </div>
</div>
@endsection