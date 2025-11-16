<div class="repetitive_box" data-index="{{ $number }}">
    <h4 class="font-bold session-heading">Session {{ ($number + 1) }}</h4>
    <div class="row g-3">

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label d-block">Session Type</label>
                <div class="toggle-btn-group">
                    <input type="radio" id="virtual_{{ $number }}"  class="virtual_f2f_button" data-id="{{ $number }}"
                           name="classes[{{ $number }}][session_type]"
                           value="virtual" checked/>
                    <label for="virtual_{{ $number }}">Virtual</label>

                    <input type="radio" id="face_to_face_{{ $number }}"  class="virtual_f2f_button" data-id="{{ $number }}"
                           name="classes[{{ $number }}][session_type]"
                           value="face_to_face"/>
                    <label for="face_to_face_{{ $number }}">Face To Face</label>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="seat_capacity_min_{{ $number }}">Seating Capacity</label>
            <div class="row">
                <div class="col-md-6">

                    <input type="number" name="classes[{{ $number }}][seat_capacity_min]"
                           id="seat_capacity_min_{{ $number }}" class="form-control" placeholder="Min"/>
                </div>
                <div class="col-md-6">

                    <input type="number" name="classes[{{ $number }}][seat_capacity_max]"
                           id="seat_capacity_max_{{ $number }}" class="form-control" placeholder="Max"/>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <label class="form-label" for="title_{{ $number }}">Title</label>
            <input type="text" name="classes[{{ $number }}][title]" id="title_{{ $number }}" class="form-control"/>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="skills_{{ $number }}">Add skills/learnings</label>
            <select class="form-control select2 multi-select" name="classes[{{ $number }}][skills][]"
                    id="skills_{{ $number }}" multiple required>
                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                @endforeach
            </select>
        </div>
        @php
            $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
        @endphp
        <div class="col-md-6">
            <label class="form-label" for="start_date_time_{{ $number }}">Start Date Time</label>
            <input type="datetime-local" name="classes[{{ $number }}][start_date_time]"
                   id="start_date_time_{{ $number }}" class="form-control" min="{{ $now }}"/>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="end_date_time_{{ $number }}">End Date Time</label>
            <input type="datetime-local" name="classes[{{ $number }}][end_date_time]" id="end_date_time_{{ $number }}"
                   class="form-control" min="{{ $now }}"/>
        </div>

        <div class="col-md-12">
            <label class="form-label" for="description_{{ $number }}">Session description</label>
            <textarea name="classes[{{ $number }}][description]" id="description_{{ $number }}" class="form-control"
                      placeholder="Enter Description"></textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="session_price_{{ $number }}">Session Price</label>
            <input type="number" name="classes[{{ $number }}][session_price]" id="session_price_{{ $number }}"
                   class="form-control" placeholder="(if available)"/>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="discount_type_{{ $number }}">Discount Type</label>
            <select name="classes[{{ $number }}][discount_type]" class="form-control" id="discount_type">
                <option value="percent">Percent</option>
                <option value="amount">Amount</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="session_price_discount_{{ $number }}">Session Price Discount</label>
            <input type="number" name="classes[{{ $number }}][session_price_discount]"
                   id="session_price_discount_{{ $number }}" class="form-control" placeholder="(if available)"/>
        </div>

        <div class="col-md-12">
            <label class="form-label" for="discount_type_{{ $number }}">Session Attachments</label>
            <input type="file"
                   name="classes[{{ $number }}][session_attachments][]"
                   id="session_attachments_{{ $number }}"
                   accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .txt, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, text/plain"
                   class="form-control"
                   multiple>

        </div>

        <div class="col-md-12 face_to_face_details" id="face_to_face_details_{{ $number }}" style="display: none;">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-control countryName @error('country') is-invalid @enderror" data-id="{{ $number }}"
                            id="classes_{{ $number }}_country" name="classes[{{ $number }}][country]">
                        <option value="">-- Select Country --</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}"> {{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="state" class="form-label">State</label>
                    <select class="form-control stateName @error('state') is-invalid @enderror" data-id="{{ $number }}"
                            id="classes_{{ $number }}_state" name="classes[{{ $number }}][state]">
                        <option value="">-- Select State --</option>
                    </select>
                    @error('state')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">City</label>
                    <select class="form-control cityName @error('city') is-invalid @enderror cityList" data-id="{{ $number }}"
                            id="classes_{{ $number }}_city" name="classes[{{ $number }}][city]">
                        <option value="">-- Select City --</option>
                    </select>
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                           id="classes_{{ $number }}_postal_code" name="classes[{{ $number }}][postal_code]"
                           value="{{ old('postal_code') }}">
                    @error('postal_code')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="venue_address" class="form-label">Venue Address</label>
                    <textarea name="classes[{{ $number }}][venue_address]" class="form-control"></textarea>
                </div>
            </div>
        </div>

{{--        <label for="" class="form-label">Invite another speaker</label>--}}
        <div class="mentor_container_{{ $number }} mentor_container" id="mentor_container_{{ $number }}">
{{--            @include('frontend._partial._session_mentor_form', ['mentor_number' => 0])--}}
        </div>

        <div class="col-md-12 mt-3">
            <div class="col-md-5 mt-3">
                <button type="button"
                        class="btn btn-primary btn-sm rounded-pill add-speaker-btn"
                        data-number="{{ $number }}"> + Add another speaker
                </button>
            </div>

        </div>



        <div class="feedback_container_{{ $number }} feedback_container" id="feedback_container_{{ $number }}">
            {{--            @include('frontend._partial._session_feedback_form', ['feedback_number' => 0])--}}
        </div>

        <div class="col-md-12 mt-3">
            <div class="col-md-5 mt-3">
                <button type="button"
                        class="btn btn-primary btn-sm rounded-pill add-feedback-btn"
                        data-number="{{ $number }}"> + Add Feedback Questions
                </button>
            </div>

        </div>
        @if($number > 0)
            <div class="col-md-12 mt-2">
                <button type="button" class="btn btn-outline-danger btn-sm remove-session">Remove Session</button>
            </div>
        @endif
    </div>
</div>

@section('javascripts')
@endsection

