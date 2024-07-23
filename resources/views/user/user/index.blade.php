@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>


@stop

@section('content')


    <div class="pagetitle">
        <h1>User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('user.index') }}">User /</a></li>
            </ol>
        </nav>
    </div>

    <section class="user" id="user">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 id="role-list-title" class="text-color-title align-items-center">User List</h3>
                    @if (hasPermissions('Create User'))
                        <a href="{{ route('user.create') }}" class="btn btn-success btn-sm">
                            <i class="ri-add-circle-fill fs-4"></i> Add
                        </a>
                    @endif
            </div>
            <div class="card-body mt-4">
                {{-- <h5 class="card-title user-list" id="user-list"></h5> --}}
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination" id="pagination">
                    </ul>
                </nav>

                <div class="countData" id="countData"></div>

            </div>
        </div>
    </section>

@stop

@section('script')

    <script>
        $(document).ready(function() {
            const perPage = 15;
            let currentPage = {{ empty(request()->query('current_page')) ? 1 : request()->query('current_page') }};

            const editUser = {{ hasPermissions('Edit User') ? 'true' : 'false' }};
            const deleteUser = {{ hasPermissions('Delete User') ? 'true' : 'false' }};
            const user_id = {{ authData()['id'] }}
            const lowerPermissionsID = @json(lowerPermissionsID());
            const roleValues = lowerPermissionsID.map(role => role.role);


            function fetchData(page) {
                $.ajax({
                    url: '{{ route('user.data') }}',
                    data: {
                        page: page,
                        per_page: perPage
                    },
                    success: function(response) {
                        const tableBody = $('#datatable tbody');
                        let rowCount = (page - 1) * perPage + 1;
                        tableBody.empty();
                        response.data.forEach(item => {

                            // console.log(item);
                            const viewUrl = '{{ route('user.view', [':id', ':current_page']) }}'
                                .replace(':id', item.user_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            const editUrl =
                                '{{ route('user.edit', [':id', ':current_page']) }}'
                                .replace(':id', item.user_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            const deleteUrl =
                                '{{ route('user.delete', [':id', ':current_page']) }}'
                                .replace(':id', item.user_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            tableBody.append(`
                            <tr>
                                <td>${rowCount++}</td>
                                <td>${item.name}</td>
                                <td>
                                    <a href="mailto:${item.email }">${item.email }</a>
                                </td>
                                 <td>
                                    <a href="tel:${item.phone }">${item.phone }</a>
                                </td>
                                <td>${item.role}</td>
                                <td class="breadcrumb-item">
                                    <div class="btn-group">
                                    <a href="${viewUrl}" class="btn btn-sm btn-primary">
                                        <i class="bx bxs-show fs-5 pt-1"></i>
                                    </a>
                                    ${roleValues.includes(item.role_id)?`
                                            
                                                ${editUser? `
                                                <a href="${editUrl}" class="btn btn-sm btn-success">
                                                    <i class="bx bxs-edit fs-5"></i>
                                                </a>`:``
                                                }
                                                                        
                                                ${deleteUser? `
                                                <a href="${deleteUrl}" class="btn btn-sm btn-danger" >
                                                    <i class="bx bxs-trash-alt fs-5"></i>
                                                </a>
                                                </div>
                                                `:``
                                                }
                                            
                                        `:`</div><div class="text-center ml-3"><i class="ri-alert-fill text-warning fs-3"></i></div>
                                           `}
                                </td>
                            </tr>
                        `);
                            console.log(response);

                            // Handle pagination
                            const pagination = $('#pagination');
                            pagination.empty();

                            if (response.last_page > 1) {
                                for (let i = 1; i <= response.last_page; i++) {
                                    pagination.append(`
                                <li class="page-item ${i === response.current_page ? 'active' : ''}">
                                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                                </li>
                            `);
                                }
                            }
                            const countData = $('#countData');
                            countData.empty();
                            countData.append(
                                `<span>  Showing:  ${(page - 1) * perPage + 1} to ${ ((page - 1) * perPage + 1) + response.data.length - 1}</span>
                                 <span> Total Records: ${response.total} </span>`
                            );
                        });
                    }
                });
            }

            fetchData(currentPage);
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                currentPage = $(this).data('page');
                fetchData(currentPage);
            });
        });
    </script>

@stop
