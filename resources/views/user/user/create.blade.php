<!-- Extending main layout -->
@extends('userTemplate.Main') 

@section('seo')
    
@stop

@section('content')
    <div class="pagetitle">
        <h1>User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">User</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('user.create') }}">Create</a></li>
            </ol>
        </nav>
    </div>

    <section class="user" id="user">
        <div class="card">
            <div class="card-header">
                <h5 class="text-color-title" id="user-Create">New User Create</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row pt-4 g-3">
                        <div class="form-group col-sm-6">
                            <input type="text" name="name" class="form-control" placeholder="Name" aria-label="name"
                                required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="email"
                                required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="number" name="phone" class="form-control" placeholder="Phone" aria-label="phone"
                                required value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-select" name="role_id" id="role_id" required>
                                <option selected>Select Role</option>
                                @foreach ($rolesInUser as $role)
                                    <option value="{{ $role->role_id }}"
                                        {{ old('role_id') == $role->role_id ? 'selected' : '' }}>{{ $role->role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <select class="form-select" id="gender" name="gender" required>
                                <option selected>Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="text" name="state" class="form-control" placeholder="State" aria-label="state"
                                value="{{ old('state') }}">
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="text" name="country" class="form-control" placeholder="Country"
                                aria-label="country" value="{{ old('country') }}">
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="number" name="pincode" class="form-control" placeholder="Pin-Code"
                                aria-label="pincode" value="{{ old('pincode') }}">
                            @error('pincode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" name="city" class="form-control" placeholder="City" aria-label="city"
                                value="{{ old('city') }}">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" name="address" class="form-control" placeholder="Address"
                                aria-label="address" value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <input type="file" name="image" class="form-control" placeholder="Image"
                                aria-label="image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 btn-group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o tp-2 fs-4"></i>
                                Create</button>
                            <button class="btn btn-primary" type="reset"><i class="bx bx-reset tp-2 fs-4"></i>
                                Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('script')
@stop
