@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>

    
@stop

@section('content')
    <div class="pagetitle">
        <h1>Role & Permission</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('role-permission.index') }}">Role-Permission</a></li>
                <li class="breadcrumb-item active"> <a href="{{ route('role-permission.create') }}">Create</a></li>
            </ol>
        </nav>
    </div>

    <section class="permission" id="permission">
        <div class="card">
            <div class="card-header">
                <h5 class="text-color-title" id="permission-Create">New Role & Permission Create</h5>
            </div>
            <div class="card-body">

                <form action="{{route('role-permission.store') }}" method="POST">
                    @csrf
                    <div class="row pt-4 g-3">
                        <div class="col-sm-12">
                            <select class="form-select" name="role">
                                <option value="">Select Role</option>
                                @foreach ($rolesWithoutPermissions as $role)
                                    <option value="{{ $role->role_id }}"> {{ $role->role }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <select name="permissions[]" id="permissions" multiple="multiple" required class="form-multi-select"  multiple data-coreui-search="true">
                                <option value="">Select Permission</option>
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->permission_id }}">
                                        {{ $permission->permission_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permissions')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-sm-3 btn-group">
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
