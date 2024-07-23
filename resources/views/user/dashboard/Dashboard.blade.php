@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>
@stop

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('dashboard') }}">Dashboard /</a></li>
            </ol>
        </nav>
        
    </div>
     




@stop
