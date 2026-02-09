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
                                <h4 class="card-title">Events</h4>
                            </div>
                            <div class="">
                                <a href="JavaScript:void(0);" class=" text-center btn btn-primary btn-icon mt-lg-0 mt-md-0 mt-3" id="addQualificationButton">
                                    <i class="btn-inner">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </i>
                                    <span>Add Event</span>
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
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Location</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="" name="id" id="id">
                        <x-InputBox class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" title="Title" name="title" id="title" type="text" required="True"/>
                        <x-InputBox class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" title="Image" name="image" id="image" type="file" required="True"/>
                        <x-InputBox class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" title="Description" name="description" id="description" type="text" required="True"/>
                        <x-InputBox class="form-control {{ $errors->has('date') ? ' is-invalid' : '' }}" title="Date" name="date" id="date" type="date" required="True"/>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 col-xxl-6 col-xs-12">
                                <x-InputBox class="form-control {{ $errors->has('start_time') ? ' is-invalid' : '' }}" title="Start Time" name="start_time" id="start_time" type="time" required="True"/>
                            </div>
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6 col-xxl-6 col-xs-12">
                                <x-InputBox class="form-control {{ $errors->has('end_time') ? ' is-invalid' : '' }}" title="End Time" name="end_time" id="end_time" type="time" required="True"/>
                            </div>
                        </div>
                        <x-InputBox class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" title="Location" name="location" id="location" type="text" required="True"/>
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
            $('#addModalLabel').text('Add Slider');
            $('#title').val('');
            $('#image').val('');
            $('#description').val('');
            $('#date').val('');
            $('#start_time').val('');
            $('#end_time').val('');
            $('#location').val('');
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
                    url: "{{ route('admin.events.index') }}",
                    data: function (d) {
                        d.search = $('input[name=search]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'title'
                    },
                    {data: 'title', name: 'title'},
                    {data: 'description',name: 'description'},
                    {data: 'image',name: 'image'},
                    {data: 'date',name: 'date'},
                    {data: 'time',name: 'time'},
                    {data: 'location',name: 'location'},
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
                url: "{{ route('admin.events.store') }}",
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
        
        function editEvent(id){
            var url = "{{route('admin.events.edit',':id')}}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: "GET",
                success: function(response){
                    $('#addForm')[0].reset();
                    $('#id').val(response.id);
                    $('#title').val(response.title);
                    $('#description').val(response.description);
                    $('#date').val(response.date);
                    $('#start_time').val(response.start_time);
                    $('#end_time').val(response.end_time);
                    $('#location').val(response.location);
                    $('#addSaveButton').text('Update');
                    $('#addModalLabel').text('Edit Slider');
                    $('#image').val('');
                    $('#addModal').modal('show');
                }
            });
        }
        
        function deleteEvent(id){
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
                    var url = "{{route('admin.events.destroy',':id')}}";
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