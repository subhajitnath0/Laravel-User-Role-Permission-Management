@extends('userTemplate.Main')

@section('seo')
    <title>Profile</title>

    <style>
        .User_Image {
            border: 2px solid rgba(0, 0, 0, 0.13);
            height: 200px;
            width: 200px;
            border-radius: 50%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            margin-bottom: auto;
        }
    </style>
@stop

@section('content')

    <div class="pagetitle">

        <h1>My Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('myProfile') }}">My-Profile /</a></li>
            </ol>
        </nav>
    </div>






    <section class="user" id="user">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 id="role-list-title" class="text-color-title align-items-center">My Profile</h3>

            </div>
            <div class="card-body mt-4">

                <div class="row">

                    <div class="col-sm-6">

                        <img class="User_Image" src="{{ route('user.showImage', ['filename' => authData()['image']]) }}"
                            alt="User Image">

                        <h4 class="card-title text-center fs-3 mt-2 fw-bolder">{{ authData()['name'] }}</h4>
                        <div class="text-center mt-2 mb-4">
                            <i class="fa fa-envelope text-color-title fs-6 p-1"
                                style="border: 3px solid #012970;  border-radius: 50%;" aria-hidden="true"></i>
                            <a class="ml-2 fs-6 fw-bold text-color-title"
                                href="mailto:{{ authData()['email'] }}">{{ authData()['email'] }}</a>

                            <i class="bx bxs-phone-call text-color-title fs-6 p-1 ml-4"
                                style="border: 3px solid #012970;  border-radius: 50%;" aria-hidden="true"></i>
                            <a class="ml-2 fs-6 fw-bold text-color-title"
                                href="tel:{{ authData()['phone'] }}">{{ authData()['phone'] }}</a>
                        </div>

                        <hr>
                        <div class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-success">
                                    <i class="bx bxs-edit fs-5"></i>
                                </a>
                                <a href="#" class="btn btn-primary">
                                    <i class="fa fa-key  fs-5" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                       


                    </div>

                    <div class="container col-sm-6">
                        <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                            <h4 class="card-title fs-4">Profile Details</h4>
                            {{-- <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold ">Full Name</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ $user->name }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Email</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ $user->email }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Phone</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ $user->phone }}</div>
                            </div> --}}
                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Gender</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{authData()['gender'] }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Role</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['role']->role }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Address</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['address'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">City</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['city'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">State</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['state'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">Country</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['country'] }}</div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label fw-bold">PIN-Code</div>
                                <div class="col-lg-9 col-md-8 fw-normal">{{ authData()['pincode'] }}</div>
                            </div>


                        </div>
                    </div>
                    {{-- <div class="container col-sm-12">
                        <hr>
                        <h5 class="text-color-title fw-bold fs-4 pl-4 pr-4 ml-4 mr-4">Permission</h5>
                        <p class="small fst-italic pl-4 pr-4 ml-4 mr-4">
                            @foreach ($permissions as $permission)
                                <span class="mr-3 fw-bold"> {{ $permission->permission_name }}, </span>
                            @endforeach
                        </p>

                    </div> --}}

                   

                </div>
            </div>
    </section>


@stop

@section('script')



@stop
