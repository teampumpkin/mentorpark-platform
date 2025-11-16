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
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <p>Assign Permissions</p>
                                <span class="text-primary" style="cursor: pointer;">
                                    <input type="checkbox" id="select-all-permissions" class="form-check-input me-1">
                                    <label for="select-all-permissions" class="form-check-label">Select All</label>
                                </span>
                            </label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   id="perm_{{ $permission->id }}"
                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button class="btn btn-primary rounded-pill">Update Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JS: Select All -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAll = document.getElementById('select-all-permissions');
            const checkboxes = document.querySelectorAll('.permission-checkbox');

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        });
    </script>
</x-app-layout>
