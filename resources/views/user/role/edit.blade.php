@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@stop

@section('content')
    <div class="pagetitle">
        <h1>Role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('role.index') }}">Role</a></li>
                <li class="breadcrumb-item active"> <a href="{{ route('role.create',['id' => $data->role_id]) }}">Edit</a></li>
            </ol>
        </nav>
    </div>

    <section class="role" id="role">
        <div class="card">
            <div class="card-header">
                <h5 class="text-color-title" id="role-Create">New Role Create</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('role.update',['id' => $data->role_id,'current_page' =>  request()->query('current_page')]) }}" method="POST">
                    @csrf
                    <div class="row pt-4 g-3">
                        <div class="col-sm-12">
                            <input type="text" name="role_name" class="form-control" value="{{$data->role}}" placeholder="Role"
                                aria-label="Role" disabled>
                            @error('role_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <input type="text" name="role_description" class="form-control"
                                placeholder="Role Description" aria-label="Role Description" value="{{$data->description}}">
                            @error('role_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-3 btn-group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o tp-2 fs-4"></i>
                                Update
                            </button>

                            <a class="btn btn-primary" href="{{ route('role.index', ['current_page' =>  request()->query('current_page')]) }}">
                                <i class="bx bx-reset tp-2 fs-4"></i> Back
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

@stop

@section('script')


@stop
