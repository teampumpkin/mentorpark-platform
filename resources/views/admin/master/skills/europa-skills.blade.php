<x-app-layout>
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">{{ $breadcrumb }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    {{--            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>--}}
                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <!-- Page Content Start -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (session('success'))
                        <div
                            class="alert alert-secondary alert-dismissible d-flex align-items-center border-2 border border-secondary"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            <iconify-icon icon="solar:bicycling-round-bold-duotone"
                                          class="fs-20 me-1"></iconify-icon>
                            <div class="lh-1"><strong> {{ session('success') }} </strong></div>
                        </div>
                    @endif

                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="allEuropaSkills" class="form-checkbox"></th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        @foreach ($list as $data)
                            {{--@if (in_array($data, $existingSkills))
                            @else--}}
                                <tr>
                                    <td><input type="checkbox" name="europaSkills[]" class="form-checkbox"
                                               id="europaSkills"
                                               value="{{ $data }}"></td>
                                    <td> {{ $data }}</td>
                                    <td>
                                        @if (in_array($data, $existingSkills))
                                            <span class="badge bg-success">Exists</span>
                                        @else
                                            <span class="badge bg-warning">New</span>
                                        @endif
                                    </td>
                                </tr>
{{--                            @endif--}}
                        @endforeach

                        <tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">
                                <button class="btn btn-primary" id="add_to_skills">Add to our skills</button>
                            </td>
                        </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Select all or unselect all
                $('#allEuropaSkills').on('change', function () {
                    const isChecked = $(this).is(':checked');
                    $('input[name="europaSkills[]"]').prop('checked', isChecked);
                });

                // Uncheck master if any single is unchecked
                $(document).on('change', 'input[name="europaSkills[]"]', function () {
                    const all = $('input[name="europaSkills[]"]').length;
                    const checked = $('input[name="europaSkills[]"]:checked').length;

                    // If all selected, keep master checked — else uncheck it
                    $('#allEuropaSkills').prop('checked', all === checked);
                });

                $('#add_to_skills').on('click', function () {
                    let selectedSkills = [];
                    $('input[name="europaSkills[]"]:checked').each(function () {
                        selectedSkills.push($(this).val());
                    });

                    if (selectedSkills.length === 0) {
                        alert("Please select at least one skill.");
                        return;
                    }

                    $.ajax({
                        url: '{{ route("master.skills.europa-skills.store") }}',
                        method: 'POST',
                        data: {
                            skills: selectedSkills,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            // Remove any previous alert
                            $('.floating-alert-badge').remove();

                            // Badge markup
                            var seconds = 3;
                            var badge = $(`
                <div class="floating-alert-badge position-fixed"
                     style="right:30px; bottom:30px; z-index:9999; min-width:300px; max-width:90vw; box-shadow:0 0 25px rgba(80,80,200,0.16);">
                    <div class="alert alert-success d-flex align-items-center mb-0 shadow-lg border border-info border-2 rounded-pill px-4 py-2" role="alert"
                        style="font-size:1.1rem; font-weight:600; background:linear-gradient(90deg,#67e8f9,#53d6ff 70%); color:#0a2540;">
                        <i class="fa fa-check-circle me-2" style="font-size:1.5rem;"></i>
                        <span>Inserted <b>${response.inserted || 0}</b> skill(s). Reloading in <span id="badgeTimer">${seconds}</span>s.</span>
                    </div>
                </div>
            `);

                            $('body').append(badge);

                            // Countdown timer
                            var timer = setInterval(function(){
                                seconds--;
                                $("#badgeTimer").text(seconds);
                                if(seconds <= 0){
                                    clearInterval(timer);
                                    $('.floating-alert-badge').fadeOut(400, function(){ $(this).remove(); });
                                    location.reload();
                                }
                            },1000);
                        },
                        error: function (xhr) {
                            alert('Error adding skills: ' + xhr.responseText);
                        }
                    });
                });


                // Optional: checkbox to select/deselect all skills
                $('#allEuropaSkills').on('change', function () {
                    $('input[name="europaSkills[]"]').prop('checked', this.checked);
                });
            });
        </script>
    @endpush

</x-app-layout>
