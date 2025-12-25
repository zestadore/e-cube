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
                                <h4 class="card-title">Payment Methods</h4>
                            </div>
                            <div class="">
                                <a href="JavaScript:void(0);" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" id="addQualificationButton">
                                    <i class="btn-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </i>
                                    <span>Add Payment Method</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <div class="table-responsive">
                                <form id="filterfordatatable" style="padding: 5px;" class="form-horizontal" onsubmit="event.preventDefault();">
                                    <div class="row ">
                                        <div class="col">
                                            <input type="text" name="search" class="form-control" placeholder="Search with name">
                                        </div>
                                    </div>
                                </form><br>
                                <table id="item-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                                    <thead>
                                        <tr class="ligth">
                                            <th>Slno.</th>
                                            <th>Name</th>
                                            <th>Upi id</th>
                                            <th>Bank name</th>
                                            <th>Details</th>
                                            <th>Status</th>
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
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="" name="id" id="id">
                        <x-InputBox class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" title="Name" name="name" id="name" type="text" required="True"/>
                        <x-InputBox class="form-control {{ $errors->has('upi_id') ? ' is-invalid' : '' }}" title="Upi id" name="upi_id" id="upi_id" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" title="Qr Code" name="image" id="image" type="file" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('bank_name') ? ' is-invalid' : '' }}" title="Bank name" name="bank_name" id="bank_name" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('account_name') ? ' is-invalid' : '' }}" title="Account name" name="account_name" id="account_name" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}" title="Account number" name="account_number" id="account_number" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('ifsc_code') ? ' is-invalid' : '' }}" title="IFSC" name="ifsc_code" id="ifsc_code" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('branch_name') ? ' is-invalid' : '' }}" title="Branch name" name="branch_name" id="branch_name" type="text" required="False"/>
                        <x-InputBox class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" title="Description" name="description" id="description" type="textarea" required="False"/>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                            <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="addSaveButton" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#addQualificationButton').click(function(){
            $('#addForm')[0].reset();
            $('#id').val('');
            $('#addSaveButton').text('Save');
            $('#addModalLabel').text('Add Payment Method');
            $('#name').val('');
            $('#upi_id').val('');
            $('#image').val('');
            $('#bank_name').val('');
            $('#account_name').val('');
            $('#account_number').val('');
            $('#ifsc_code').val('');
            $('#branch_name').val('');
            $('#description').val('');
            $('#status').prop('checked', true);
            $('#addModal').modal('show');
        });
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
                    url: "{{ route('admin.payment-methods.index') }}",
                    data: function (d) {
                        d.search = $('input[name=search]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'name'
                    },
                    {data: 'name', name: 'name'},
                    {data: 'upi_id',name: 'upi_id'},
                    {data: 'bank_name',name: 'bank_name'},
                    {data: 'details',name: 'details'},
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge rounded-pill bg-primary">Active</span>';
                            } else {
                                return '<span class="badge rounded-pill bg-danger">Inactive</span>';
                            }
                        }
                    },
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
        
        $('#addSaveButton').click(function(){
            let formData = new FormData($('#addForm')[0]);
            $.ajax({
                url: "{{ route('admin.payment-methods.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response){
                    $('#addModal').modal('hide');
                    drawTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });
                    $('#addForm')[0].reset();
                    $('#image').val('');
                },
                error: function(response){
                    if(response.status == 422){
                        var errors = response.responseJSON.errors;
                        $.each(errors, function(key, value){
                            $('#'+key).addClass('is-invalid');
                            $('#'+key).after('<div class="invalid-feedback">'+value+'</div>');
                        });
                    }
                }
            });
        });
        
        function editPaymentMethod(id){
            var url = "{{route('admin.payment-methods.edit',':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response){
                    $('#addForm')[0].reset();
                    $('#id').val(response.id);
                    $('#name').val(response.name);
                    $('#upi_id').val(response.upi_id);
                    $('#bank_name').val(response.bank_name);
                    $('#account_name').val(response.account_name);
                    $('#account_number').val(response.account_number);
                    $('#ifsc_code').val(response.ifsc_code);
                    $('#branch_name').val(response.branch_name);
                    $('#status').prop('checked', response.status == 1 ? true : false);
                    $('#description').val(response.description);
                    $('#addSaveButton').text('Update');
                    $('#addModalLabel').text('Edit Payment Method');
                    $('#image').val('');
                    $('#addModal').modal('show');
                }
            });
        }
        
        function deletePaymentMethod(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{route('admin.payment-methods.destroy',':id')}}";
                    url = url.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Data has been deleted.",
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