<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <!-- Link to Vite for CSS assets -->
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="card bg-base-100 w-96 shadow-xl p-6">
        <!-- Content displayed when the user is authenticated -->
        @auth
            <figure class="text-center">
                <img src="https://img.freepik.com/free-vector/hand-drawn-business-planning-with-task-list_23-2149164275.jpg?t=st=1723822521~exp=1723826121~hmac=ceb74b3043198453d63e011e4095cf4d4f03bc5b262f89197992e7c8766e36e7&w=740"
                    alt="Dashboard" class="w-full rounded-lg mb-4" />
            </figure>
            <div class="card-body text-center">
                <h2 class="card-title text-2xl font-bold mb-4">Welcome to your Dashboard</h2>
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        @else
            <!-- Content displayed when the user is not authenticated -->
            <figure class="text-center">
                <!-- Image displayed for unauthenticated users -->
                <img src="https://img.freepik.com/free-vector/workers-warehouse-storage-facility-sorting-labeling-items-barcode-scanning-barcode-generator-software-mobile-proof-delivery-concept-pinkish-coral-bluevector-isolated-illustration_335657-1781.jpg?t=st=1726070890~exp=1726074490~hmac=ff6f62642ef8af894d0f59100ae81f03a67a743860a5c2490bba63aca725f9c0&w=996"
                    alt="Task Tracker" class="w-full rounded-lg mb-4" />
            </figure>
            <div class="card-body text-center">
                <!-- Welcome message for unauthenticated users -->
                <h2 class="card-title text-2xl font-bold mb-4">Welcome to Inventory System</h2>
                <p class="mb-4">Please log in to manage your tasks.</p>
                <div class="card-actions justify-center mt-4">
                    <!-- Buttons for login and registration for unauthenticated users -->
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700">Register</a>
                </div>
            </div>
        @endauth
    </div>
</body>

</html>