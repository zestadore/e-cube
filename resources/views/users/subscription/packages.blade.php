@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Package</th>
                                <th scope="col">Price</th>
                                <th scope="col">Validity</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package->name }}</td>
                                    <td>Rs.{{ $package->price }}/-</td>
                                    <td>{{ $package->duration }} Month/s</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#subscribeModal">Subscribe</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-lg" id="subscribeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Methods</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Payment Method</th>
                            <th scope="col">UPI ID</th>
                            <th scope="col">Qr</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentMethods as $paymentMethod)
                            <tr>
                                <td>{{ $paymentMethod->name }}</td>
                                <td>{{$paymentMethod->upi_id}}</td>
                                <td><a href="{{$paymentMethod->qr_code}}" target="_blank"><img src="{{$paymentMethod->qr_code}}" alt="{{$paymentMethod->name}}" class="img-fluid"></a></td>
                                <td>{{$paymentMethod->bank_name}}<br>{{$paymentMethod->account_name}}<br>
                                    {{$paymentMethod->account_number}}<br>
                                    {{$paymentMethod->branch_name}}<br>
                                    {{$paymentMethod->ifsc_code}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <hr>
                <div class="modal-body">
                    Upload Payment Proof
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="payment_proof" class="form-control">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
@endsection