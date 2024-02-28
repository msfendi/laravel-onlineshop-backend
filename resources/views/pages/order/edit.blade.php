@extends('layouts.app')

@section('title', 'Edit Order')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Advanced Forms</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Orders</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Orders</h2>
            <form action="{{ route('order.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Transaction Date</label>
                                    <input type="text" class="form-control @error('created_at')
                                is-invalid
                            @enderror" name="created_at" value="{{ $order->created_at }}" disabled>
                                    @error('created_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Transaction Number</label>
                                    <input type="text" class="form-control @error('transaction_number')
                                is-invalid
                            @enderror" name="transaction_number" value="{{ $order->transaction_number }}" disabled>
                                    @error('transaction_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <input type="text" class="form-control @error('customer_name')
                                is-invalid
                            @enderror" name="customer_name" value="{{ $order->user->name }}" disabled>
                                    @error('customer_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Shipping Service</label>
                                    <input type="text" class="form-control @error('shipping_service')
                                is-invalid
                            @enderror" name="shipping_service" value="{{ $order->shipping_service }}" disabled>
                                    @error('shipping_service')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mt-sm-4">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select class="form-control selectric @error('status') is-invalid @enderror" name="status">
                                        <option value="" disabled>-- Select Status --</option>
                                        <option value="pending" {{ ($order->status == 'pending') ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="paid" {{ ($order->status == 'paid') ? 'selected' : '' }}>
                                            Paid
                                        </option>
                                        <option value="on_delivery" {{ ($order->status == 'on_delivery') ? 'selected' : '' }}>
                                            On Delivery
                                        </option>
                                        <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>
                                            Delivered
                                        </option>
                                        <option value="expired" {{ ($order->status == 'expired') ? 'selected' : '' }}>
                                            Expired
                                        </option>
                                        <option value="canceled" {{ ($order->status == 'canceled') ? 'selected' : '' }}>
                                            Canceled
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush