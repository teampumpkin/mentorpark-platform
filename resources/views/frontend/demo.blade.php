@extends('frontend.layouts.app')

@section('stylesheets')


@endsection

@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="row">
                <div class="page-header-bar">
                    <div>
                        <h2 class="page-title">{{ $breadcrumb }}</h2>
                        {{--<span class="page-desc">Lorem ipsum dolor</span>--}}
                    </div>
                    <button class="page-edit-btn btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal">
                        Edit&nbsp;
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" style="vertical-align:middle;" viewBox="0 0 20 20">
                            <path fill="currentColor"
                                  d="M14.846 2.648a2.313 2.313 0 1 1 3.272 3.272l-1.004 1.004-3.273-3.272 1.005-1.004zm-2.01 2.009l3.272 3.272-8.828 8.828H4.01v-3.273l8.827-8.827z"/>
                        </svg>
                    </button>

                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">





                        </div> <!-- end card-body -->
                    </div> <!-- end card-->
                </div> <!-- end col -->

            </div>
        </div>



@endsection

@section('javascripts')

@endsection
