<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Skeleton with Role Modal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-sm p-5 hidden md:block">
    <div class="h-10 w-32 bg-gray-200 rounded mb-6"></div>

    <nav class="space-y-4">
        <div class="h-4 w-3/4 bg-gray-200 rounded"></div>
        <div class="h-4 w-1/2 bg-gray-200 rounded"></div>
        <div class="h-4 w-2/3 bg-gray-200 rounded"></div>
        <div class="h-4 w-1/3 bg-gray-200 rounded"></div>
    </nav>
</aside>

<!-- Main Content -->
<div class="flex-1 flex flex-col">
    <!-- Topbar -->
    <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
        <div class="h-8 w-40 bg-gray-200 rounded"></div>
        <div class="flex items-center space-x-4">
            <div class="h-8 w-64 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-6 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-6 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-6 bg-gray-200 rounded-full"></div>
            <div class="h-6 w-24 bg-gray-200 rounded"></div>
        </div>
    </header>

    <!-- Dashboard Content -->
    <main class="flex-1 p-8 space-y-8 animate-pulse">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="h-32 bg-gray-200 rounded-xl"></div>
            <div class="h-32 bg-gray-200 rounded-xl"></div>
            <div class="h-32 bg-gray-200 rounded-xl"></div>
            <div class="h-32 bg-gray-200 rounded-xl"></div>
        </div>

        <div class="h-96 bg-gray-200 rounded-xl"></div>

        <div class="space-y-4">
            <div class="h-6 w-1/4 bg-gray-200 rounded"></div>
            <div class="h-12 bg-gray-200 rounded"></div>
            <div class="h-12 bg-gray-200 rounded"></div>
            <div class="h-12 bg-gray-200 rounded"></div>
        </div>
    </main>
</div>

<!-- Role Selection Modal -->
<div id="roleModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md">
{{--        <h2 class="text-xl font-semibold mb-4 text-gray-700">Login as</h2>--}}
        <select id="roleSelect" class="w-full border border-gray-300 rounded-lg p-2 focus:ring focus:ring-indigo-200">
            <option value="">Login as</option>
            <option value="Mentor">Mentor</option>
            <option value="Mentee">Mentee</option>
            <option value="Organization">Organization</option>
        </select>
        <div class="mt-6 text-right">
            <button id="closeModal" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2">Cancel</button>
            <button id="submitRole" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Continue</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Modal open automatically
        $('#roleModal').show();

        // Close button
        $('#closeModal').click(function () {
            $('#roleModal').hide();
        });

        // On click Continue
        $('#submitRole').click(function () {
            const selectedRole = $('#roleSelect').val();

            if (!selectedRole) {
                alert('Please select a role');
                return;
            }

            $.ajax({
                url: '/set-user-role', // your backend route
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // if in Blade file
                    role: selectedRole
                },
                success: function (response) {
                    // alert('Role set as: ' + selectedRole);
                    $('#roleModal').hide();
                    // location.reload();
                    // You can redirect if needed
                    window.location.href = '/dashboard';
                },
                error: function () {
                    alert('Failed to set role.');
                }
            });
        });
    });
</script>

</body>
</html>
