@extends('userTemplate.Main')

@section('seo')
    <title>Subhajit</title>


@stop

@section('content')
    <div class="pagetitle">

        <h1>Permission</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"> <a href="{{ route('permission.index') }}">Permission /</a></li>
            </ol>
        </nav>
    </div>

    <section class="permission" id="permission">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 id="permission-list" class="text-color-title align-items-center">Permission List</h4>
                @if (hasPermissions('Create Permission'))
                    <a href="{{ route('permission.create') }}" class="btn btn-success btn-sm">
                        <i class="ri-add-circle-fill fs-4"></i> Add
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Permission</th>
                            <th>Description</th>
                            @if(hasPermissions('Edit Permission') || hasPermissions('Delete Permission'))
                            <th>Action</th>
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
            const perPage = 15;
            let currentPage = {{ empty(request()->query('current_page')) ? 1 : request()->query('current_page') }};

            const editPermission = {{ hasPermissions('Edit Permission') ? 'true' : 'false' }};
            const deletePermission = {{ hasPermissions('Delete Permission') ? 'true' : 'false' }};





            function fetchData(page) {
                $.ajax({
                    url: '{{ route('permission.data') }}',
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
                                '{{ route('permission.edit', [':id', ':current_page']) }}'
                                .replace(':id', item.permission_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            const deleteUrl =
                                '{{ route('permission.delete', [':id', ':current_page']) }}'
                                .replace(':id', item.permission_id).replace(':current_page',
                                    `current_page=${response.current_page}`);

                            tableBody.append(`
                            <tr>
                                <td>${rowCount++}</td>
                                <td class="breadcrumb-item">${item.permission_name}</td>
                                <td>${item.permission_description}</td>
                                ${editPermission || deletePermission?`
                                        <td class="breadcrumb-item btn-group">
                                            ${editPermission? `
                                            <a href="${editUrl}" class="btn btn-sm btn-success">
                                                <i class="bx bxs-edit fs-5"></i>
                                            </a>`:``
                                            }
                                            
                                            ${deletePermission? `
                                        <a href="${deleteUrl}" class="btn btn-sm btn-danger" >
                                            <i class="bx bxs-trash-alt fs-5"></i>
                                        </a>`:``
                                            }
                                        </td>
                                        `:``
                                }
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
    </script>

@stop