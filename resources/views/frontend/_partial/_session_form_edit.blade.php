<div class="repetitive_box" data-index="{{ $number }}">
    <h4 class="font-bold session-heading">Session {{ ($number + 1) }}</h4>
    <div class="row g-3">

        {{-- SESSION TYPE --}}
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label d-block">Session Type</label>
                <div class="toggle-btn-group">
                    <input type="radio" id="virtual_{{ $number }}" class="virtual_f2f_button" data-id="{{ $number }}"
                           name="classes[{{ $number }}][session_type]"
                           value="virtual"
                        {{ old("classes.$number.session_type", $class->session_type ?? '') == 'virtual' ? 'checked' : '' }}/>
                    <label for="virtual_{{ $number }}">Virtual</label>

                    <input type="radio" id="face_to_face_{{ $number }}" class="virtual_f2f_button"
                           data-id="{{ $number }}"
                           name="classes[{{ $number }}][session_type]"
                           value="face_to_face"
                        {{ old("classes.$number.session_type", $class->session_type ?? '') == 'face_to_face' ? 'checked' : '' }}/>
                    <label for="face_to_face_{{ $number }}">Face To Face</label>
                </div>
            </div>
        </div>
        {{-- SEATING CAPACITY --}}
        <div class="col-md-6">
            <label class="form-label" for="seat_capacity_min_{{ $number }}">Seating Capacity</label>
            <div class="row">
                <div class="col-md-6">
                    <input type="number" name="classes[{{ $number }}][seat_capacity_min]"
                           id="seat_capacity_min_{{ $number }}"
                           class="form-control"
                           placeholder="Min"
                           value="{{ old("classes.$number.seat_capacity_min", $class->seat_capacity_min ?? '') }}"/>
                </div>
                <div class="col-md-6">
                    <input type="number" name="classes[{{ $number }}][seat_capacity_max]"
                           id="seat_capacity_max_{{ $number }}"
                           class="form-control"
                           placeholder="Max"
                           value="{{ old("classes.$number.seat_capacity_max", $class->seat_capacity_max ?? '') }}"/>
                </div>
            </div>
        </div>

        <input type="hidden" name="classes[{{ $number }}][id]" value="{{ $class->id }}">

        {{-- TITLE --}}
        <div class="col-md-6">
            <label class="form-label" for="title_{{ $number }}">Title</label>
            <input type="text" name="classes[{{ $number }}][title]"
                   id="title_{{ $number }}"
                   class="form-control"
                   value="{{ old("classes.$number.title", $class->title ?? '') }}"/>
        </div>

        {{-- SKILLS --}}
        {{--        @dump($class->skills->pluck('id')->toArray())--}}
        <div class="col-md-6">
            <label class="form-label" for="skills_{{ $number }}">Add skills/learnings</label>
            <select class="form-control select2 multi-select"
                    name="classes[{{ $number }}][skills][]"
                    id="skills_{{ $number }}"
                    multiple required>
                @php
                    // Normalize skills into an array of IDs
                    $selectedSkills = old("classes.$number.skills",
                        isset($class->skills)
                            ? (is_array($class->skills)
                                ? $class->skills
                                : $class->skills->pluck('id')->toArray())
                            : []
                    );
                @endphp

                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}"
                        {{ in_array($skill->id, $selectedSkills) ? 'selected' : '' }}>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- DATE/TIME --}}
        <div class="col-md-6">
            <label class="form-label" for="start_date_time_{{ $number }}">Start Date Time</label>
            <input type="datetime-local" name="classes[{{ $number }}][start_date_time]"
                   id="start_date_time_{{ $number }}"
                   class="form-control"
                   value="{{ old("classes.$number.start_date_time", isset($class->start_date_time) ? \Carbon\Carbon::parse($class->start_date_time)->format('Y-m-d\TH:i') : '') }}"/>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="end_date_time_{{ $number }}">End Date Time</label>
            <input type="datetime-local" name="classes[{{ $number }}][end_date_time]"
                   id="end_date_time_{{ $number }}"
                   class="form-control"
                   value="{{ old("classes.$number.end_date_time", isset($class->end_date_time) ? \Carbon\Carbon::parse($class->end_date_time)->format('Y-m-d\TH:i') : '') }}"/>
        </div>

        {{-- DESCRIPTION --}}
        <div class="col-md-12">
            <label class="form-label" for="description_{{ $number }}">Session description</label>
            <textarea name="classes[{{ $number }}][description]"
                      id="description_{{ $number }}"
                      class="form-control"
                      placeholder="Enter Description">{{ old("classes.$number.description", $class->session_description ?? '') }}</textarea>
        </div>

        {{-- PRICE + DISCOUNT --}}
        <div class="col-md-4">
            <label class="form-label" for="session_price_{{ $number }}">Session Price</label>
            <input type="number" name="classes[{{ $number }}][session_price]"
                   id="session_price_{{ $number }}"
                   class="form-control"
                   value="{{ old("classes.$number.session_price", $class->session_price ?? '') }}"
                   placeholder="(if available)"/>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="discount_type_{{ $number }}">Discount Type</label>
            <select name="classes[{{ $number }}][discount_type]"
                    class="form-control"
                    id="discount_type_{{ $number }}">
                <option
                    value="percent" {{ old("classes.$number.discount_type", $class->discount_type ?? '') == 'percent' ? 'selected' : '' }}>
                    Percent
                </option>
                <option
                    value="amount" {{ old("classes.$number.discount_type", $class->discount_type ?? '') == 'amount' ? 'selected' : '' }}>
                    Amount
                </option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="session_price_discount_{{ $number }}">Session Price Discount</label>
            <input type="number" name="classes[{{ $number }}][session_price_discount]"
                   id="session_price_discount_{{ $number }}"
                   class="form-control"
                   value="{{ old("classes.$number.session_price_discount", $class->session_price_discount ?? '') }}"
                   placeholder="(if available)"/>
        </div>

        {{-- ATTACHMENTS --}}
        <div class="col-md-12">
            <label class="form-label" for="session_attachments_{{ $number }}">Session Attachments</label>
            <input type="file"
                   name="classes[{{ $number }}][session_attachments][]"
                   id="session_attachments_{{ $number }}"
                   class="form-control"
                   multiple
                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt"/>

            @if(!empty($class->attachments))

                @foreach($class->attachments as $file)
                    <div class="mt-2" id="attachment_row_{{ $file->id }}">
                        <a href="{{ Storage::disk('master_class_session_attachments')->url($file->attachment_path) }}"
                           target="_blank">
                            {{ $file->file_original_name }}
                        </a>
                        <button type="button" class="btn btn-outline-danger removeDocument"
                                onclick="removeAttachment({{ $file->id }})" style="width: 20px; height: 20px;">&times;
                        </button>
                        <br>
                    </div>
                @endforeach

            @endif
        </div>

        {{-- FACE TO FACE FIELDS --}}
        <div class="col-md-12 face_to_face_details" id="face_to_face_details_{{ $number }}"
             style="{{ old("classes.$number.session_type", $class->session_type ?? '') == 'face_to_face' ? '' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-control @error('country') is-invalid @enderror countryName"
                            data-id="{{ $number }}"
                            id="classes_{{ $number }}_country" data-value="{{ $class->country }}"
                            name="classes[{{ $number }}][country]">
                        <option value="">-- Select Country --</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}"
                                {{ old("classes.$number.country", $class->country ?? '') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="state" class="form-label">State</label>
                    <select class="form-control @error('state') is-invalid @enderror stateName"
                            data-value="{{ $class->state }}" data-id="{{ $number }}"
                            id="classes_{{ $number }}_state" name="classes[{{ $number }}][state]">
                        <option value="">-- Select State --</option>
                    </select>
                    @error('state')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label for="city" class="form-label">City</label>
                    <select class="form-control @error('city') is-invalid @enderror cityName"
                            data-value="{{ $class->city }}" data-id="{{ $number }}"
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
                           value="{{ old('postal_code', $class->postal_code ?? '') }}">
                    @error('postal_code')
                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="venue_address" class="form-label">Venue Address</label>
                    <textarea name="classes[{{ $number }}][venue_address]"
                              class="form-control">{{ old("classes.$number.venue_address", $class->venue_address ?? '') }}</textarea>
                </div>

            </div>
        </div>


        <div class="mentor_container_{{ $number }} mentor_container" id="mentor_container_{{ $number }}">
            @foreach($class->mentors as $number => $mentor)
                @include('frontend._partial._session_mentor_edit_form', ['mentor_number' => 0, 'mentor' => $mentor])
            @endforeach
        </div>

        <div class="col-md-12 mt-3">
            <div class="col-md-5 mt-3">
                <button type="button"
                        class="btn btn-primary btn-sm rounded-pill add-speaker-btn"
                        data-number="{{ $number }}"> + Add another speaker
                </button>
            </div>

        </div>


        {{-- FEEDBACK --}}
        <div class="feedback_container_{{ $number }} feedback_container" id="feedback_container_{{ $number }}">
            @foreach($class->feedbacks as $number => $feedback)
                @include('frontend._partial._session_feedback_form_edit', ['feedback_number' => $number, 'feedback' => $feedback])
            @endforeach

        </div>

        <div class="col-md-12 mt-3">
            <div class="col-md-5 mt-3">
                <button type="button"
                        class="btn btn-primary btn-sm rounded-pill add-feedback-btn"
                        data-number="{{ $number }}">+ Add Feedback Questions
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
