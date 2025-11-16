@extends('frontend.layouts.app')

@section('stylesheets')


@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body" style="text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                                <span style="color:#6C36D9;font-size:28px;margin-right:10px;">&#10003;</span>
                                <h1 style="margin:0;font-weight:600;color:#333;">Payment Successful !</h1>
                            </div>
                            <p style="font-size:17px;color:#666;margin-bottom:5px;">
                                Thanks for booking your masterclass! Your seat is reserved.
                            </p>
                            <p style="font-size:15px;color:#888;margin-bottom:30px;">
                                We can’t wait to see you there—get ready for an inspiring experience.
                            </p>
                            <div style="font-size:14px;color:#888;">
                                Order ID: <span style="font-weight:bold;color:#555;">{{ $purchase_order_id }}</span>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
        </div>




@endsection

@section('javascripts')

@endsection
