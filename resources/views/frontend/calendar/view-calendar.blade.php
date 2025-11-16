@extends('frontend.layouts.app')
@section('stylesheets')
@endsection
@section('pageContent')
    <div class="wrapper">
        @include('frontend.includes.sidebar')

        <div class="page-content">
            <div class="page-title-head d-flex align-items-center gap-2">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-bold mb-0">Calendar</h4>
                </div>

                {{--<div class="text-end">
                    <ol class="breadcrumb m-0 py-0 fs-13">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Abstack</a></li>

                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>

                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </div>--}}
            </div>

            <div class="page-container">

                <div class="row">

                    {{--<div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">


                            </div>
                        </div>
                    </div>--}}
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div>
                <!--end row-->
            </div> <!-- container -->
        </div>
    </div>
@endsection
@section('javascripts')
    <script>
        var calendarEvents = @json($events);
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: calendarEvents,
                eventClick: function (info) {
                    // Optional: handle event click, eg. open modal or redirect
                    if (info.event.url) {
                        window.open(info.event.hangoutLink, '_blank');
                        info.jsEvent.preventDefault();
                    }
                }
                // Add other FullCalendar options here
            });
            calendar.render();
        });
    </script>
@endsection

