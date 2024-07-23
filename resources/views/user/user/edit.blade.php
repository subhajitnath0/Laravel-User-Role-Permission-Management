<!-- Extending main layout -->
@extends('userTemplate.Main')

@section('seo')
    <style>
        .User_Image {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
            border: 1px solid rgba(0, 0, 0, 0.159)
        }

        .User_Image_del {
            position: absolute;
            left: 160px;
            top: 5px
        }
    </style>

@stop

@section('content')
    <div class="pagetitle">
        <h1>User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route('user.index') }}">User</a></li>
                <li class="breadcrumb-item active"><a
                        href="{{ route('user.edit', ['id' => $user->user_id, 'current_page' => request()->query('current_page')]) }}">Edit</a>
                </li>
            </ol>
        </nav>
    </div>

    <section class="user" id="user">
        <div class="card">
            <div class="card-header">
                <h5 class="text-color-title" id="user-Create">Edit User</h5>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('user.update', ['id' => $user->user_id, 'current_page' => request()->query('current_page')]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row pt-4 g-3">
                        <div class="form-group col-sm-6">
                            <input type="text" name="name" class="form-control" placeholder="Name" aria-label="name"
                                required value="{{ $user->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="email"
                                required value="{{ $user->email }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="number" name="phone" class="form-control" placeholder="Phone" aria-label="phone"
                                required value="{{ $user->phone }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <select class="form-select" name="role_id" id="role_id" required>
                                <option selected>Select Role</option>
                                @foreach ($rolesInUser as $role)
                                    <option value="{{ $role->role_id }}"
                                        {{ $user->role == $role->role_id ? 'selected' : '' }}>{{ $role->role }}
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
                                <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="text" name="state" class="form-control" placeholder="State" aria-label="state"
                                value="{{ $user->state }}">
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="text" name="country" class="form-control" placeholder="Country"
                                aria-label="country" value="{{ $user->country }}">
                            @error('country')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3">
                            <input type="number" name="pincode" class="form-control" placeholder="Pin-Code"
                                aria-label="pincode" value="{{ $user->pincode }}">
                            @error('pincode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" name="city" class="form-control" placeholder="City" aria-label="city"
                                value="{{ $user->city }}">
                            @error('city')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <input type="text" name="address" class="form-control" placeholder="Address"
                                aria-label="address" value="{{ $user->address }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            @if ($user->image)
                                <a href="{{ route('user.deleteImage', ['id' => $user->user_id, 'current_page' => request()->query('current_page')]) }}"
                                    class="btn btn-sm User_Image_del"><i class="bx bxs-trash-alt text-danger fs-3"></i></a>
                                <img class="User_Image" src="{{ route('user.showImage', ['filename' => $user->image]) }}"
                                    alt="User Image">
                            @endif
                            <input type="file" name="image" class="form-control" placeholder="Image"
                                aria-label="image">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-3 btn-group">
                            <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o tp-2 fs-4"></i>
                                Create</button>
                            <a href="{{ route('user.index', ['current_page' => request()->query('current_page')]) }}"
                                class="btn btn-primary" type="reset"><i class="bx bx-reset tp-2 fs-4"></i>
                                Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@stop

@section('script')
@stop
