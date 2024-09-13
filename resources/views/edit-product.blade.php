<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Vite CSS for styling -->
    @vite('resources/css/app.css')
    <!-- Alpine.js for interactive UI components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <!-- jQuery for DOM manipulation and AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSRF Token for security in AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .error {
            color: #f87171; /* Tailwind red-400 */
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation Bar -->
    @include('Navbar')

    <!-- Edit Product Form -->
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Edit Product</h2>
        <!-- Form for editing a product -->
        <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>

            <!-- Product Description Input -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ $product->description }}</textarea>
            </div>

            <!-- Product Category Input -->
            <div class="mb-4">
                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                <input type="text" name="category" id="category" value="{{ $product->category }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
            </div>

            <!-- Product Image Input -->
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-20 h-20 object-cover rounded-md mt-2">
                @endif
            </div>

            <!-- Product Quantity Input -->
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $product->quantity }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" min="0" required>
            </div>

            <!-- Product Price Input -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price" value="{{ $product->price }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" step="0.01" min="0" required>
            </div>

            <!-- Form Buttons -->
            <div class="flex justify-end space-x-2">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Update</button>
                <a href="{{ url('/dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-200">Cancel</a>
            </div>
        </form>
    </div>

    <!-- JavaScript for handling form submission -->
    <script>
        $(document).ready(function () {
            // Handle form submission via AJAX
            $('#editProductForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const form = $(this);
                const formData = new FormData(this); // Create FormData object to handle file uploads

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false, // Prevent jQuery from setting content type
                    processData: false, // Prevent jQuery from processing data
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                            displayErrors(data.errors); // Display validation errors
                        } else {
                            alert('Product updated successfully!'); // Show success message
                            window.location.href = '/dashboard'; // Redirect to dashboard
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Function to display validation errors
            function displayErrors(errors) {
                // Clear previous errors
                $('.error').remove();

                $.each(errors, function (field, messages) {
                    const $field = $(`#${field}`);
                    if ($field.length) {
                        $('<span>', {
                            class: 'error text-red-500 text-sm',
                            text: messages.join(', ')
                        }).appendTo($field.parent()); // Append error messages below the field
                    }
                });
            }
        });
    </script>
</body>

</html>
