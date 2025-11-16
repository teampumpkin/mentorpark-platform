<x-app-layout>
    <x-slot name="header">
        <div class="page-title-head d-flex align-items-center gap-2">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-bold mb-0">Permissions</h4>
            </div>
            <div class="text-end">
                <a href="{{ route('permissions.create') }}" class="btn btn-outline-primary rounded-pill">Add Permission</a>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-secondary alert-dismissible d-flex align-items-center border-2 border border-secondary"
                             role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            <iconify-icon icon="solar:bicycling-round-bold-duotone"
                                          class="fs-20 me-1"></iconify-icon>
                            <div class="lh-1"><strong> {{ session('success') }} </strong></div>
                        </div>
                    @endif

                    <table class="table table-striped dt-responsive w-100">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->name }}</td>
                                <td>

                                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-info btn-sm">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this permission?')">
                                            <i data-lucide="trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
