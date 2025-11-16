@extends('frontend.layouts.app')

@section('stylesheets')

    <style>
        input.form-control, select.form-control, textarea.form-control {
            background-color: #F8FAFB;
            border: none;
        }
    </style>

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
                </div>
            </div>

            <div class="row">
                {{--<div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @include('frontend._partial._master_classes')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}

                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body pt-0">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <form action="{{ route('frontend.master-classes.update', $masterClass->id) }}"
                                      method="post"
                                      id="master_Class_form"
                                      enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT') {{-- Required for PUT request --}}

                                    <div class="mt-5">
                                        <!-- Tab Navigation -->
                                        <ul class="nav nav-tabs" id="masterclassTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                                        data-bs-target="#details" type="button" role="tab"
                                                        aria-controls="details" aria-selected="true">
                                                    Masterclass Details
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="sessions-tab" data-bs-toggle="tab"
                                                        data-bs-target="#sessions" type="button" role="tab"
                                                        aria-controls="sessions" aria-selected="false">
                                                    Sessions
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Tab Panes -->
                                        <div class="tab-content pt-3" id="masterclassTabContent">
                                            <!-- Masterclass Details Tab -->
                                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                                 aria-labelledby="details-tab">
                                                <div class="col-md-8">
                                                    <div class="row">

                                                        {{-- Title --}}
                                                        <div class="col-md-6">
                                                            <div class="mb-2">
                                                                <label class="form-label" for="title">Title of Masterclass</label>
                                                                <input type="text" name="title" id="title"
                                                                       class="form-control"
                                                                       value="{{ old('title', $masterClass->title) }}"
                                                                       placeholder="Title of Masterclass" required/>
                                                            </div>
                                                        </div>

                                                        {{-- Timezone --}}
                                                        <div class="col-md-6">
                                                            <div class="mb-2">
                                                                <label class="form-label" for="timezone">Timezone</label>
                                                                <select class="form-control" name="timezone" id="timezone">
                                                                    <option value="Africa/Abidjan" {{ old('timezone', $masterClass->timezone) == 'Africa/Abidjan' ? 'selected' : '' }}>Africa/Abidjan</option>
                                                                    <option value="Africa/Accra" {{ old('timezone', $masterClass->timezone) == 'Africa/Accra' ? 'selected' : '' }}>Africa/Accra</option>
                                                                    <option value="Africa/Addis_Ababa" {{ old('timezone', $masterClass->timezone) == 'Africa/Addis_Ababa' ? 'selected' : '' }}>Africa/Addis_Ababa</option>
                                                                    <option value="Africa/Algiers" {{ old('timezone', $masterClass->timezone) == 'Africa/Algiers' ? 'selected' : '' }}>Africa/Algiers</option>
                                                                    <option value="Africa/Cairo" {{ old('timezone', $masterClass->timezone) == 'Africa/Cairo' ? 'selected' : '' }}>Africa/Cairo</option>
                                                                    <option value="Africa/Casablanca" {{ old('timezone', $masterClass->timezone) == 'Africa/Casablanca' ? 'selected' : '' }}>Africa/Casablanca</option>
                                                                    <option value="Africa/Johannesburg" {{ old('timezone', $masterClass->timezone) == 'Africa/Johannesburg' ? 'selected' : '' }}>Africa/Johannesburg</option>
                                                                    <option value="America/Adak" {{ old('timezone', $masterClass->timezone) == 'America/Adak' ? 'selected' : '' }}>America/Adak</option>
                                                                    <option value="America/Anchorage" {{ old('timezone', $masterClass->timezone) == 'America/Anchorage' ? 'selected' : '' }}>America/Anchorage</option>
                                                                    <option value="America/Argentina/Buenos_Aires" {{ old('timezone', $masterClass->timezone) == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>America/Argentina/Buenos_Aires</option>
                                                                    <option value="America/Chicago" {{ old('timezone', $masterClass->timezone) == 'America/Chicago' ? 'selected' : '' }}>America/Chicago</option>
                                                                    <option value="America/New_York" {{ old('timezone', $masterClass->timezone) == 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                                                    <option value="America/Sao_Paulo" {{ old('timezone', $masterClass->timezone) == 'America/Sao_Paulo' ? 'selected' : '' }}>America/Sao_Paulo</option>
                                                                    <option value="Asia/Calcutta" {{ old('timezone', $masterClass->timezone) == 'Asia/Calcutta' ? 'selected' : '' }}>Asia/Calcutta</option>
                                                                    <option value="Asia/Dubai" {{ old('timezone', $masterClass->timezone) == 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                                                                    <option value="Asia/Hong_Kong" {{ old('timezone', $masterClass->timezone) == 'Asia/Hong_Kong' ? 'selected' : '' }}>Asia/Hong_Kong</option>
                                                                    <option value="Asia/Jakarta" {{ old('timezone', $masterClass->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta</option>
                                                                    <option value="Asia/Kolkata" {{ old('timezone', $masterClass->timezone) == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
                                                                    <option value="Asia/Manila" {{ old('timezone', $masterClass->timezone) == 'Asia/Manila' ? 'selected' : '' }}>Asia/Manila</option>
                                                                    <option value="Asia/Shanghai" {{ old('timezone', $masterClass->timezone) == 'Asia/Shanghai' ? 'selected' : '' }}>Asia/Shanghai</option>
                                                                    <option value="Asia/Singapore" {{ old('timezone', $masterClass->timezone) == 'Asia/Singapore' ? 'selected' : '' }}>Asia/Singapore</option>
                                                                    <option value="Asia/Tokyo" {{ old('timezone', $masterClass->timezone) == 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                                                                    <option value="Australia/Sydney" {{ old('timezone', $masterClass->timezone) == 'Australia/Sydney' ? 'selected' : '' }}>Australia/Sydney</option>
                                                                    <option value="Europe/Berlin" {{ old('timezone', $masterClass->timezone) == 'Europe/Berlin' ? 'selected' : '' }}>Europe/Berlin</option>
                                                                    <option value="Europe/London" {{ old('timezone', $masterClass->timezone) == 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                                                    <option value="Europe/Moscow" {{ old('timezone', $masterClass->timezone) == 'Europe/Moscow' ? 'selected' : '' }}>Europe/Moscow</option>
                                                                    <option value="Europe/Paris" {{ old('timezone', $masterClass->timezone) == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                                                                    <option value="Europe/Rome" {{ old('timezone', $masterClass->timezone) == 'Europe/Rome' ? 'selected' : '' }}>Europe/Rome</option>
                                                                    <option value="Pacific/Auckland" {{ old('timezone', $masterClass->timezone) == 'Pacific/Auckland' ? 'selected' : '' }}>Pacific/Auckland</option>
                                                                    <option value="Pacific/Honolulu" {{ old('timezone', $masterClass->timezone) == 'Pacific/Honolulu' ? 'selected' : '' }}>Pacific/Honolulu</option>
                                                                    <option value="UTC" {{ old('timezone', $masterClass->timezone) == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        {{-- Description --}}
                                                        <div class="col-md-12">
                                                            <div class="mb-2">
                                                                <label class="form-label d-block">Masterclass Description</label>
                                                                <textarea name="description" id="description"
                                                                          class="form-control"
                                                                          placeholder="Enter Description"
                                                                          required>{{ old('description', $masterClass->description) }}</textarea>
                                                            </div>
                                                        </div>

                                                        {{-- Banner Upload --}}
                                                        <div class="col-md-12">
                                                            <div class="banner-upload-card"
                                                                 onclick="document.getElementById('banner_image').click();">

                                                                <span class="banner-upload-text">Upload a banner image</span>
                                                                <input type="file" name="banner_image" id="banner_image"
                                                                       accept="image/*" style="display:none"/>

                                                                {{-- Show preview if exists --}}
                                                                <div id="banner_preview" class="mt-3">
                                                                    @if($masterClass->banner_image)
                                                                        <img src="{{ Storage::disk('master_class_banner_image')->url($masterClass->banner_image) }}"
                                                                             alt="Banner" class="img-fluid rounded">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Invite Mentees --}}
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="menteeInput" class="form-label">Invite Mentees</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                           id="menteeInput"
                                                                           placeholder="Search groups or mentees"
                                                                           autocomplete="off"
                                                                           onkeyup="showSuggestions(this.value)">
                                                                    <button class="btn btn-outline-secondary" type="button"
                                                                            id="addBtn" onclick="addMenteeFromInput()">Add
                                                                    </button>
                                                                </div>
                                                                <div id="suggestions" class="list-group position-absolute"
                                                                     style="z-index: 10; max-height: 200px; overflow-y: auto; width: 100%;"></div>
                                                            </div>

                                                            {{-- Existing mentees --}}

                                                            @foreach($masterClass->mentees as $mentee)
                                                                    <div class="input-group mb-2" style="max-width: 350px;" id="mentee_row_{{ $mentee->id }}">
                                                                        <input type="text" class="form-control" name="old_mentee_emails[]" value="{{ $mentee->email }}" readonly>
                                                                        <button type="button" class="btn btn-outline-danger removeMentee" onclick="removeMentee({{ $mentee->id }})">&times;</button>
                                                                    </div>
                                                                @endforeach


                                                            <ul id="selectedList" class="list-group mt-2">
                                                                {{-- @foreach($masterClass->mentees as $mentee)
                                                                    <div class="input-group mb-2" style="max-width: 350px;">
                                                                        <input type="text" class="form-control" value="{{ $mentee->email }}" readonly>
                                                                        <input type="hidden" name="mentee_ids[]" value="{{ $mentee->id }}">
                                                                        <button type="button" class="btn btn-outline-danger" onclick="$(this).parent().remove();">&times;</button>
                                                                    </div>
                                                                @endforeach --}}
                                                            </ul>

                                                            <ul id="newMenteeList" class="list-group mt-2">

                                                            </ul>
                                                        </div>

                                                        {{-- Attachments --}}
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="attachments">Upload attachments</label>
                                                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple/>

                                                                @if($masterClass->attachments && $masterClass->attachments->count())
                                                                    @foreach($masterClass->attachments as $file)
                                                                    <div class="mt-2" id="attachment_row_{{ $file->id }}">

                                                                            <a href="{{ Storage::disk('master_class_attachments')->url($file->attachment_path) }}" target="_blank">
                                                                                {{ $file->file_original_name }}
                                                                            </a>   <button type="button" class="btn btn-outline-danger removeDocument" onclick="removeAttachment({{ $file->id }})" style="width: 20px; height: 20px;">&times;</button><br>

                                                                    </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>


                                                        {{-- Notifications --}}
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label d-block">Notifications</label>
                                                                <div class="toggle-btn-group">
                                                                    <input type="radio" id="email" name="contact_method"
                                                                           value="email"
                                                                        {{ old('contact_method', $masterClass->email_notification) == true ? 'checked' : '' }}>
                                                                    <label for="email">Email</label>

                                                                    <input type="radio" id="whatsapp" name="contact_method"
                                                                           value="whatsapp"
                                                                        {{ old('contact_method', $masterClass->whatsapp_notification) == true ? 'checked' : '' }}>
                                                                    <label for="whatsapp">WhatsApp</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Pricing --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="price">Pricing of masterclass</label>
                                                            <input type="number" name="price" id="price"
                                                                   class="form-control"
                                                                   value="{{ old('price', $masterClass->price) }}"
                                                                   placeholder="price"/>
                                                        </div>

                                                        {{-- Discount --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label" for="discount_type">Discount Type</label>
                                                            <select name="discount_type" class="form-control" id="discount_type">
                                                                <option value="percent" {{ old('discount_type', $masterClass->discount_type) == 'percent' ? 'selected' : '' }}>Percent</option>
                                                                <option value="amount" {{ old('discount_type', $masterClass->discount_type) == 'amount' ? 'selected' : '' }}>Amount</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label" for="discount_value">Discount value</label>
                                                            <input type="number" name="discount_value" id="discount_value"
                                                                   class="form-control"
                                                                   value="{{ old('discount_value', $masterClass->discount_value) }}"
                                                                   placeholder="(if available)"/>
                                                        </div>
                                                        <div class="col-md-12 mt-2">

                                                            <input type="checkbox" name="isActive" id="isActive" class="form-checkbox" {{ old('isActive', $masterClass->isActive) ? 'checked' : '' }}/>
                                                            <label class="form-label" for="isActive" >Publish Masterclass</label>
                                                        </div>

                                                        <div class="col-md-12 mt-2">
                                                            <div class="d-flex justify-content-end mt-4">
                                                                <button type="button" class="btn btn-primary" id="toSessionsBtn">Next</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sessions Tab -->
                                            <div class="tab-pane fade" id="sessions" role="tabpanel"
                                                 aria-labelledby="sessions-tab">

                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div id="repetitive_container">
                                                            {{-- Preload existing sessions --}}
                                                            @foreach($masterClass->sessions as $number => $session)
                                                                @include('frontend._partial._session_form_edit', ['number' => $number, 'class' => $session])
                                                            @endforeach
                                                        </div>

                                                        <div class="col-12 mt-3">
                                                            <button type="button"
                                                                    class="btn btn-outline-secondary rounded-pill"
                                                                    id="add_session_btn">+ Add more sessions
                                                            </button>
                                                        </div>

                                                        <div class="d-flex justify-content-between mt-4">
                                                            <button type="button" class="btn btn-secondary" id="toDetailsBtn">Previous</button>
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </form>


                        </div>
                    </div>
                </div>

            </div>


        </div>

    @include('frontend.scripts.master-class-script')


@endsection
