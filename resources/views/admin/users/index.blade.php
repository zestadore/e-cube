@extends('layouts.app')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="conatiner-fluid content-inner mt-n5 py-0">
        <div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Users</h4>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <form id="filterfordatatable" style="padding: 5px;" class="form-horizontal" onsubmit="event.preventDefault();">
                                    <div class="row ">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control" placeholder="Search with name">
                                        </div>
                                        <div class="col-md-4">
                                            <select name="role" class="form-select">
                                                <option value="">All Users</option>
                                                <option value="employee">Employee</option>
                                                <option value="employer">Employer</option>
                                            </select>
                                        </div>
                                    </div>
                                </form><br>
                                <table id="item-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Slno.</th>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Role</th>
                                            <th style="min-width: 100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function drawTable()
        {
            var table = $('#item-table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                buttons: [],
                "pagingType": "full_numbers",
                "dom": "<'row'<'col-sm-12 col-md-12 right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                ajax: {
                    url: "{{ route('admin.users.index') }}",
                    data: function (d) {
                        d.search = $('input[name=search]').val();
                        d.role = $('select[name=role]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'first_name'
                    },
                    {data: 'user', name: 'user'},
                    {data: 'email_field',name: 'email_field'},
                    {data: 'mobile_field',name: 'mobile_field'},
                    {data: 'role_field',name: 'role_field'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }]
            });
        }
        
        drawTable();
        
        $('input[name=search]').keyup(function(){
            drawTable();
        });
        
        $('select[name=role]').change(function(){
            drawTable();
        });
        
        function verifyUser(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Verify the user!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{route('admin.users.update',':id')}}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "PUT"
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "Updated!",
                                text: "Data has been updated.",
                                icon: "success"
                            });
                            drawTable();
                        }
                    });
                }
            })
        }
        
    </script>
@endsection