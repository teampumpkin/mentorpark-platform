<x-app-layout>
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">{{ $breadcrumb }}</h4>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('permissions.update', $permission) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" name="name" value="{{ $permission->name }}" class="form-control" required>
                        </div>

                        <button class="btn btn-primary rounded-pill">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
