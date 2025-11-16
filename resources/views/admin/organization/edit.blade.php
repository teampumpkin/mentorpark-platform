<x-app-layout>
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">{{ $breadcrumb }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0 fs-13">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $breadcrumb }}</li>
                </ol>
            </div>
        </div>
    </x-slot>

    <!-- Page Content Start -->
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form id="organizationForm" action="{{ route('organization.update', $organization->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>There were some problems with your input:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="name" class="form-label">Organization Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $organization->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email (optional)</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $organization->email) }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone (optional)</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $organization->phone) }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror"
                                       id="website" name="website" value="{{ old('website', $organization->website) }}">
                                @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="2">{{ old('address', $organization->address) }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-control @error('country') is-invalid @enderror countryList" data-selected="{{ $organization->country }}" id="country" name="country">
                                        <option value="">-- Select Country --</option>
                                    </select>
                                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select class="form-control @error('state') is-invalid @enderror" data-selected="{{ $organization->state }}" id="state" name="state">
                                        <option value="">-- Select State --</option>
                                    </select>
                                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <select class="form-control cityList @error('city') is-invalid @enderror" data-selected="{{ $organization->city }}" id="city" name="city">
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                           id="postal_code" name="postal_code" value="{{ old('postal_code', $organization->postal_code) }}">
                                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="industry_type" class="form-label">Industry Type</label>
                                <select class="form-control industry_type @error('industry_type') is-invalid @enderror" data-selected="{{ $organization->industry_type }}" id="industry_type" name="industry_type">
                                    <option value="">-- Select Industry Type --</option>
                                </select>
                                @error('industry_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="registration_number" class="form-label">Registration Number</label>
                                <input type="text" class="form-control @error('registration_number') is-invalid @enderror"
                                       id="registration_number" name="registration_number" value="{{ old('registration_number', $organization->registration_number) }}">
                                @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="founded_date" class="form-label">Founded Date</label>
                                <input type="date" class="form-control @error('founded_date') is-invalid @enderror"
                                       id="founded_date" name="founded_date" value="{{ old('founded_date', $organization->founded_date) }}">
                                @error('founded_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="logo_path" class="form-label">Logo</label>
                                @if($organization->logo_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $organization->logo_path) }}" alt="Logo" width="80">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('logo_path') is-invalid @enderror"
                                       id="logo_path" name="logo_path" accept="image/*">
                                @error('logo_path') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    {{ old('is_active', $organization->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->
</x-app-layout>
