@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@stop

@section('content')
    <div class="pagetitle">
        <h1>Permission</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('permission.index') }}">Permission</a></li>
                <li class="breadcrumb-item active"> <a href="{{ route('permission.create') }}">Create</a></li>
            </ol>
        </nav>
    </div>

    <section class="permission" id="permission">
        <div class="card">
            <div class="card-header">
                <h5 class="text-color-title" id="permission-Create">New Permission Create</h5>
            </div>
            <div class="card-body">

                <form action="{{ route('permission.store') }}" method="POST">
                    @csrf
                    <div class="row pt-4 g-3">
                        <div class="col-sm-12">
                            <input type="text" name="permission_name" class="form-control" placeholder="Permission"
                                aria-label="Permission">
                        </div>
                        <div class="col-sm-12">
                            <input type="text" name="permission_description" class="form-control" placeholder="Permission Description" aria-label="Permission Description">
                        </div>
                        <div class="col-sm-2 btn-group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o tp-2 fs-4"></i>
                                Create
                            </button>

                            <button class="btn btn-primary" type="reset"><i class="bx bx-reset tp-2 fs-4"></i>
                                Reset
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

@stop

@section('script')


@stop
