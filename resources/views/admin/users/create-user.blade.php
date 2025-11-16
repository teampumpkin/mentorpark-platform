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
                    <div class="col-lg-6">
                        <form id="userForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- User Basic Information -->
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile number" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>

                            <!-- User Information Fields -->
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-control select2" name="user_types[]" id="user_types" data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($userType as $type)
                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="user_type" class="form-label">Organization</label>
                                <select class="form-control" name="organization_id" id="organization_id">
                                    <option value="">Select Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
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
                                <textarea class="form-control" id="about" name="about" rows="3" placeholder="Tell us about yourself" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter job title" required>
                            </div>
                            <div class="mb-3">
                                <label for="total_experience" class="form-label">Total Experience (in years)</label>
                                <input type="text" class="form-control" id="total_experience" name="total_experience" placeholder="Enter total experience" required>
                            </div>
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                {{--<input type="text" class="form-control" id="skills" name="skills" placeholder="Enter skills (comma separated)" required>--}}
                                <select class="form-control select2 skills-select" name="skills[]" id="skills" data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="goal" class="form-label">Goal </label>
                                {{--<textarea class="form-control" id="goal" name="goal" rows="3" placeholder="Your goal" required></textarea>--}}
                                <select class="form-control select2 goals-select" name="goals[]" id="goals" data-toggle="select2" multiple required>
                                    <option value="">Select</option>
                                    @foreach($goals as $goal)
                                        <option value="{{ $goal->id }}">{{ $goal->name }}</option>
                                    @endforeach
                                </select>


                            </div>

                            <!-- Social Media Links -->
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="Enter LinkedIn URL">
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" class="form-control" id="twitter" name="twitter" placeholder="Enter Twitter URL">
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook" placeholder="Enter Facebook URL">
                            </div>
                            <div class="mb-3">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram" placeholder="Enter Instagram URL">
                            </div>
                            <div class="mb-3">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="url" class="form-control" id="youtube" name="youtube" placeholder="Enter YouTube URL">
                            </div>

                            <!-- Profile Photo Upload -->
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/*">
                            </div>

                            <!-- Additional Fields -->
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
                            </div>
                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" placeholder="Enter country" required>
                            </div>

                            <!-- Terms and Conditions Checkbox -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkmeout" name="checkmeout" required>
                                    <label class="form-check-label" for="checkmeout">I accept the terms and conditions</label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End -->

</x-app-layout>
