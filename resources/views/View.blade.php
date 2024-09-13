<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
    <!-- Alpine.js for interactive UI components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <!-- jQuery for DOM manipulation and AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSRF Token for security in AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-50">
    <!-- Navigation Bar -->
    @include('Navbar')

    <!-- Product Details -->
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Product Details</h2>
        @if($product)
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">ID</label>
                <p class="text-gray-800">{{ $product->id }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <p class="text-gray-800">{{ $product->name }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="text-gray-800">{{ $product->description ?? 'No Description' }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <p class="text-gray-800">{{ $product->category }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Quantity</label>
                <p class="text-gray-800">{{ $product->quantity }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <p class="text-gray-800">${{ $product->price }}</p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <div>
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-48 h-48 object-cover rounded-md">
                    @else
                    <p class="text-gray-800">No Image</p>
                    @endif
                </div>
            </div>
            <div class="flex justify-end">
            <a href="{{ url('/dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-200">Back</a>
            </div>
        </div>
        @else
        <p class="text-gray-800">Product not found.</p>
        @endif
    </div>
</body>

</html>
