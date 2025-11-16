<form action="{{ route('frontend.master-classes.update', $masterClass->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="upper_section mb-4">

        <div class="mb-2">
            <label class="form-label" for="name">Masterclass Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $masterClass->name) }}" required />
        </div>

        <div class="mb-2">
            <label class="form-label d-block">Masterclass Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required>{{ old('description', $masterClass->description) }}</textarea>
        </div>

        <!-- Banner Image Upload Card -->
        <div class="banner-upload-card" onclick="document.getElementById('banner_image').click();">
            <svg width="56" height="53" viewBox="0 0 56 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- SVG Path here -->
            </svg>

            <span class="banner-upload-text">Upload a banner image</span>
        </div>
        <!-- Hidden File Input -->
        <input type="file" name="banner_image" id="banner_image" accept="image/*" style="display:none" />
        <div id="banner_preview" class="mt-3">
            @if ($masterClass->banner_image)
                <img src="{{ asset('storage/'.$masterClass->banner_image) }}" alt="Current Banner" class="img-fluid rounded" style="max-height: 150px;" />
            @endif
        </div>
    </div>

    <div class="master_classes">
        <div id="repetitive_container">
            @foreach(old('classes', $masterClass->classes ?? []) as $index => $class)
                <div class="repetitive_box" data-index="{{ $index }}">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label" for="title_{{ $index }}">Title</label>
                            <input type="text" name="classes[{{ $index }}][title]" id="title_{{ $index }}" class="form-control"
                                   value="{{ old('classes.'.$index.'.title', $class['title'] ?? '') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="skills_{{ $index }}">Add skills/learnings</label>
                            <select class="form-control select2 multi-select" name="classes[{{ $index }}][skills][]" id="skills_{{ $index }}" multiple required>
                                <option value="">Select</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ in_array($skill->id, old('classes.'.$index.'.skills', $class['skills'] ?? [])) ? 'selected' : '' }}>
                                        {{ $skill->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="start_date_time_{{ $index }}">Start Date Time</label>
                            <input type="datetime-local" name="classes[{{ $index }}][start_date_time]" id="start_date_time_{{ $index }}" class="form-control"
                                   value="{{ old('classes.'.$index.'.start_date_time', isset($class['start_date_time']) ? \Carbon\Carbon::parse($class['start_date_time'])->format('Y-m-d\TH:i') : '') }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="end_date_time_{{ $index }}">End Date Time</label>
                            <input type="datetime-local" name="classes[{{ $index }}][end_date_time]" id="end_date_time_{{ $index }}" class="form-control"
                                   value="{{ old('classes.'.$index.'.end_date_time', isset($class['end_date_time']) ? \Carbon\Carbon::parse($class['end_date_time'])->format('Y-m-d\TH:i') : '') }}" />
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="description_{{ $index }}">Masterclass description</label>
                            <textarea name="classes[{{ $index }}][description]" id="description_{{ $index }}" class="form-control" placeholder="Enter Description">{{ old('classes.'.$index.'.description', $class['description'] ?? '') }}</textarea>
                        </div>

                        <div class="col-md-12 mt-2">
                            <button type="button" class="btn btn-danger remove-session">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12 mt-3">
            <button type="button" class="btn btn-outline-secondary rounded-pill" id="add_session_btn">+ Add more sessions</button>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label" for="mentees">Add Mentees</label>
        <select class="form-control select2 multi-select" name="mentees[]" id="mentees" multiple required>
            <option value="">Select</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ in_array($user->id, old('mentees', $masterClass->mentees->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label" for="attachments">Upload attachments</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple />
            {{-- Optionally list previously uploaded attachments --}}
            @if($masterClass->attachments)
                <ul>
                    @foreach($masterClass->attachments as $attachment)
                        <li><a href="{{ asset('storage/' . $attachment->filepath) }}" target="_blank">{{ $attachment->filename }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label d-block">Notifications</label>
            <div class="toggle-btn-group">
                <input type="radio" id="email" name="contact_method" value="email" {{ old('contact_method', $masterClass->contact_method) == 'email' ? 'checked' : '' }} />
                <label for="email">Email</label>
                <input type="radio" id="whatsapp" name="contact_method" value="whatsapp" {{ old('contact_method', $masterClass->contact_method) == 'whatsapp' ? 'checked' : '' }} />
                <label for="whatsapp">WhatsApp</label>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="price">Pricing of masterclass</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $masterClass->price) }}" />
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Masterclass</button>
    </div>
</form>
