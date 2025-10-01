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
                                <h4 class="card-title">Qualifications</h4>
                            </div>
                            <div class="">
                                <a href="JavaScript:void(0);" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" id="addQualificationButton">
                                    <i class="btn-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </i>
                                    <span>Add Qualification</span>
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
                                            <th>Qualification</th>
                                            <th>Parents</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Qualification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="" name="id" id="id">
                        <x-InputBox class="form-control {{ $errors->has('degree') ? ' is-invalid' : '' }}" title="Degree" name="degree" id="degree" type="text" required="True"/>
                        <div class="form-group">
                            <label for="parent">Parents</label>
                            <select class="js-example-responsive js-states form-control" name="parent[]" id="parent" multiple="multiple" style="width: 100%">
                                @foreach ($qualifications as $qualification)
                                    <option value="{{$qualification->id}}">{{$qualification->degree}}</option>
                                @endforeach
                            </select>
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
            $('#parent').val(null).trigger('change');
            $('#id').val('');
            $('#addModal').modal('show');
        });
        $(".js-example-responsive").select2({
            width: 'resolve', // need to override the changed default
            theme: "classic",
            dropdownParent: $('#addModal')
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
                    url: "{{ route('admin.qualification.index') }}",
                    data: function (d) {
                        d.search = $('input[name=search]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'degree'
                    },
                    {data: 'degree', name: 'degree'},
                    {data: 'parent',name: 'parent'},
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
            var formData = $('#addForm').serialize();
            $.ajax({
                url: "{{ route('admin.qualification.store') }}",
                type: "POST",
                data: formData,
                success: function(response){
                    $('#addModal').modal('hide');
                    drawTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });
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
        
        function editQualification(id){
            var url = "{{route('admin.qualification.edit',':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response){
                    $('#id').val(response.id);
                    $('#degree').val(response.degree);
                     let parentIds = response.parents.map(parent => parent.id);
                    $('#parent').val(parentIds).trigger('change');
                    $('#addModal').modal('show');
                }
            });
        }
        
        function deleteQualification(id){
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
                    var url = "{{route('admin.qualification.destroy',':id')}}";
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