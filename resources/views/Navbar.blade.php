<nav class="bg-white shadow-md">
        <div class="container mx-auto flex items-center justify-between p-4">
            <!-- Logo -->
            <div class="text-2xl font-bold text-gray-800">
                <a href="{{ url('/dashboard') }}">Inventory System</a>
            </div>

            <!-- User Info and Logout -->
            <div class="flex items-center space-x-4">
                <!-- Display logged-in user's name -->
                <span class="text-gray-700">{{ Auth::user()->name }}</span>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>