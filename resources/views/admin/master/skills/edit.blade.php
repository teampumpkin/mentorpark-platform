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
                        <form id="userForm" action="{{ route('master.skills.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Skill</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $data->name) }}" placeholder="Enter Skill" required>
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
