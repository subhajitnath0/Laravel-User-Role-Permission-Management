@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>


@stop

@section('content')
    <div class="pagetitle">
        <h1>Role & Permission</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('role-permission.index') }}">Role-Permission /</a></li>
            </ol>
        </nav>
    </div>

    <section class="role-permission" id="role-permission">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 id="role-permission-list-title" class="text-color-title align-items-center">Role & Permission List</h4>
                @if (hasPermissions('Create Role permission'))
                    <a href="{{ route('role-permission.create') }}" class="btn btn-success btn-sm">
                        <i class="ri-add-circle-fill fs-4"></i> Add
                    </a>
                @endif
            </div>
            <div class="card-body  mt-4">
                {{-- <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 role-permission-list" id="role-permission-list"></h5>
                    <div class="btn-group float-end mt-2 mb-2" role="group" aria-label="Basic mixed styles example">

                        <button type="button" class="btn btn-sm btn-success">
                            <i class="ri-file-excel-2-fill fs-4"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger">
                            <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                        </button>

                    </div>
                </div> --}}
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="col-1">Role</th>
                            <th>Permission</th>
                            @if (hasPermissions('Edit Role permission') || hasPermissions('Delete Role permission'))
                                <th class="col-1">Action</th>
                            @endif

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

            const perPage = 10;
            let currentPage = {{ empty(request()->query('current_page')) ? 1 : request()->query('current_page') }};

            const editRole = {{ hasPermissions('Edit Role permission') ? 'true' : 'false' }};
            const deleteRole = {{ hasPermissions('Delete Role permission') ? 'true' : 'false' }};

            function fetchData(page) {
                $.ajax({
                    url: '{{ route('role-permission.data') }}',
                    data: {
                        page: page,
                        per_page: perPage
                    },
                    success: function(response) {
                        const tableBody = $('#datatable tbody');
                        let rowCount = (page - 1) * perPage + 1;
                        tableBody.empty();
                        response.data.forEach(item => {
                            const editUrl =
                                "{{ route('role-permission.edit', [':id', ':current_page']) }}"
                                .replace(':id', item.role_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            const deleteUrl =
                                '{{ route('role-permission.delete', [':id', ':current_page']) }}'
                                .replace(':id', item.role_id).replace(':current_page',
                                    `current_page=${response.current_page}`);
                            tableBody.append(`
                            <tr>
                                <td>${rowCount++}</td>
                                <td class="breadcrumb-item">${item.role}</td>
                                <td class="text-justify">${print_Permission(item.Permission)}</td>
                                ${(editRole||deleteRole)?
                                `<td class="breadcrumb-item btn-group">
                                        ${item.Edit?`
                                            ${editRole? `
                                                <a href="${editUrl}" class="btn btn-sm btn-success">
                                                    <i class="bx bxs-edit fs-5"></i>
                                                </a>`:` `
                                            }
                                            ${deleteRole? ` 
                                                <a href="${deleteUrl}" class="btn btn-sm btn-danger" >
                                                    <i class="bx bxs-trash-alt fs-5"></i>
                                                </a>`:` `
                                            }
                                            `: `<div class="text-center"><i class="ri-alert-fill text-warning fs-3"></i> <br>Permission Denied</div>`
                                            }
                                               
                                            </td>`:``
                                }
                            </tr>
                        `);
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
                                `<span>  Showing:  ${(page - 1) * perPage + 1} to ${ ((page - 1) * perPage + 1) + response.data.length - 1}</span>`
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

        function print_Permission(Permission) {
            let html = '';
            Permission.forEach((item) => {
                html += `
                            <span class = "pr-4">${item.permission_name}, </span>
                        `
            });

            return html;
        }
    </script>






@stop
