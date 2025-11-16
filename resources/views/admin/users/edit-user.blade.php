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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-6">
                        <form id="userForm" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Indicating the method is PUT for updating -->

                            <!-- User Basic Information -->
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                                       placeholder="Enter first name" required>
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                       placeholder="Enter last name" required>
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email" required>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" placeholder="Enter mobile number"
                                       required>
                                @error('mobile')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password field optional for update -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current password">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- User Information Fields -->
                            <div class="mb-3">
                                <label for="user_types" class="form-label">User Type</label>
                                <select class="form-control select2" name="user_types[]" id="user_types" data-toggle="select2" multiple required>
                                    @foreach($userTypes as $type)
                                        <option value="{{ $type->name }}"
                                                @if(in_array($type->name, old('user_types', $user->information->user_type))) selected @endif>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_types')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="user_types" class="form-label">Organization</label>
                                <select class="form-control select2" name="organization_id" id="organization_id">
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ $user->information->organization_id == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                                @error('organization_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="roles" class="form-label">Assign Roles</label>
                                <select name="roles[]" id="roles" class="form-control select2" data-toggle="select2" multiple>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                                @if(isset($user) && $user->roles->contains('name', $role->name)) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="about" class="form-label">About</label>
                                <textarea class="form-control" id="about" name="about" rows="3" placeholder="Tell us about yourself"
                                          required>{{ old('about', $user->information->about) }}</textarea>
                                @error('about')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title', $user->information->job_title) }}"
                                       placeholder="Enter job title" required>
                                @error('job_title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_experience" class="form-label">Total Experience (in years)</label>
                                <input type="text" class="form-control" id="total_experience" name="total_experience"
                                       value="{{ old('total_experience', $user->information->total_experience) }}" placeholder="Enter total experience" required>
                                @error('total_experience')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Skills -->
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <select class="form-control select2 skills-select" name="skills[]" id="skills" data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}"
                                                @if(in_array($skill->id, old('skills', $user->skills->pluck('id')->toArray()))) selected @endif>
                                            {{ $skill->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('skills')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Goals -->
                            <div class="mb-3">
                                <label for="goals" class="form-label">Goal</label>
                                <select class="form-control select2 goals-select" name="goals[]" id="goals" data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}"
                                                @if(in_array($goal->id, old('goals', $user->goals->pluck('id')->toArray()))) selected @endif>
                                            {{ $goal->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('goals')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Social Media Links -->
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin" value="{{ old('linkedin', $user->information->linkedin) }}"
                                       placeholder="Enter LinkedIn URL">
                                @error('linkedin')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control" id="twitter" name="twitter" value="{{ old('twitter', $user->information->twitter) }}"
                                       placeholder="Enter Twitter URL">
                                @error('twitter')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $user->information->facebook) }}"
                                       placeholder="Enter Facebook URL">
                                @error('facebook')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $user->information->instagram) }}"
                                       placeholder="Enter Instagram URL">
                                @error('instagram')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="url" class="form-control" id="youtube" name="youtube" value="{{ old('youtube', $user->information->youtube) }}"
                                       placeholder="Enter YouTube URL">
                                @error('youtube')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Photo Upload -->
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                                @error('profile_photo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror

                                @if (!empty($user->userInformation?->profile_photo))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $user->userInformation->profile_photo) }}"
                                             alt="Profile Photo"
                                             class="img-thumbnail"
                                             style="max-height: 120px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Additional Fields -->
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ old('state', $user->information->state) }}" placeholder="Enter state"
                                       required>
                                @error('state')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user->information->country) }}"
                                       placeholder="Enter country" required>
                                @error('country')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->
</x-app-layout>
