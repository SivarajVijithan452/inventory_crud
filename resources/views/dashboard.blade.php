<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System</title>
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
    <!-- Alpine.js for interactive UI components -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <!-- jQuery for DOM manipulation and AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSRF Token for security in AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .error {
            color: #f87171;
            /* Tailwind red-400 */
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation Bar -->
    @include('Navbar')

    <!-- Add Product Modal -->
    <div x-data="{ open: false }" x-show="open" @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center p-4 bg-gray-800 bg-opacity-60 z-50">
        <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Add New Product</h2>
            <form id="addProductForm" action="{{ route('products.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                </div>
                <!-- Product Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
                </div>
                <!-- Product Category -->
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" id="category"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required>
                </div>
                <!-- Product Image -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <!-- Product Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        min="0" required>
                </div>
                <!-- Product Price -->
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        step="0.01" min="0" required>
                </div>
                <!-- Form Buttons -->
                <div class="flex justify-end space-x-2">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-200">Add</button>
                    <button type="button"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 transition duration-200"
                        id="cancelButton">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Table -->
    <div class="container mx-auto p-6">
        <!-- Add Item Button -->
        <button
            class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-200 mb-6 flex justify-end mt-4"
            id="addItemButton">
            Add Item
        </button>
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Product List</h2>
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Price</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody" class="text-gray-900 text-sm">
                <!-- Table rows will be inserted here dynamically -->
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div id="paginationControls" class="flex justify-between mt-4">
            <button id="prevPage" class="bg-blue-600 text-white px-4 py-2 rounded-lg disabled:opacity-50"
                disabled>Previous</button>
            <span id="pageInfo" class="text-gray-700"></span>
            <button id="nextPage" class="bg-blue-600 text-white px-4 py-2 rounded-lg disabled:opacity-50">Next</button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let currentPage = 1; // Track the current page number
            const itemsPerPage = 5; // Number of items per page

            // Function to refresh the table with products data
            function refreshTable(page = 1) {
                $.ajax({
                    url: `/api/products?page=${page}&per_page=${itemsPerPage}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log('Fetched Products Data:', data);
                        let tableHtml = '';

                        if (data && Array.isArray(data.data)) {
                            $.each(data.data, function (index, product) {
                                tableHtml += `
                        <tr class="border-b bg-white hover:bg-gray-50">
                            <td class="py-4 px-6 text-gray-800">${product.id}</td>
                            <td class="py-4 px-6">${product.name}</td>
                            <td class="py-4 px-6">${product.category}</td>
                            <td class="py-4 px-6">${product.description || 'No Description'}</td>
                            <td class="py-4 px-6">${product.quantity}</td>
                            <td class="py-4 px-6">${product.price}</td>
                            <td class="py-4 px-6">
                                ${product.image ? `<img src="storage/${product.image}" alt="${product.name}" class="w-20 h-20 object-cover rounded-md">` : 'No Image'}
                            </td>
                            <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <button class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded transition duration-200" data-id="${product.id}" data-action="edit">Edit</button>
                                <button class="bg-red-500 text-white hover:bg-red-600 px-4 py-2 rounded transition duration-200" data-id="${product.id}" data-action="delete">Delete</button>
                                <button class="bg-green-500 text-white hover:bg-green-600 px-4 py-2 rounded transition duration-200" data-id="${product.id}" data-action="view">View</button>
                            </div>
                        </td>

                        </tr>`;
                            });

                            $('#productsTableBody').html(tableHtml);

                            // Update pagination controls based on fetched data
                            updatePaginationControls(data);
                        } else {
                            tableHtml = '<tr><td colspan="8" class="py-4 px-6 text-center text-gray-600">No products found.</td></tr>';
                            $('#productsTableBody').html(tableHtml);
                        }
                    },
                    error: function (error) {
                        console.error('Error fetching products:', error);
                    }
                });
            }

            // Function to update pagination controls
            function updatePaginationControls(data) {
                const totalPages = data.last_page;
                const currentPage = data.current_page;

                $('#pageInfo').text(`Page ${currentPage} of ${totalPages}`);

                $('#prevPage').prop('disabled', currentPage <= 1);
                $('#nextPage').prop('disabled', currentPage >= totalPages);

                // Bind click event to Previous button
                $('#prevPage').off('click').on('click', function () {
                    if (currentPage > 1) {
                        refreshTable(currentPage - 1);
                    }
                });

                // Bind click event to Next button
                $('#nextPage').off('click').on('click', function () {
                    if (currentPage < totalPages) {
                        refreshTable(currentPage + 1);
                    }
                });
            }

            // Function to show the Add Product modal
            function showAddProductModal() {
                // Using Alpine.js to control the modal
                $('[x-data]').each(function () {
                    if (this.__x) this.__x.$data.open = true;
                });
            }

            // Bind click event to Add Item button
            $('#addItemButton').on('click', function () {
                showAddProductModal();
            });

            // Bind click event to Cancel button in the modal
            $('#cancelButton').on('click', function () {
                $('[x-data]').each(function () {
                    if (this.__x) this.__x.$data.open = false;
                });
            });

            // Handle Add Product form submission
            $('#addProductForm').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                const formData = new FormData(this);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log('Response JSON:', data);
                        if (data.errors) {
                            console.error('Validation errors:', data.errors);
                            displayErrors(data.errors);
                        } else {
                            alert('Item added successfully!');
                            // Refresh the table with updated products and close the modal
                            refreshTable();
                            $('[x-data]').each(function () {
                                if (this.__x) this.__x.$data.open = false; // Close the modal
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Handle Delete action
            $(document).on('click', '[data-action="delete"]', function () {
                const productId = $(this).data('id');
                if (confirm('Are you sure you want to delete this product?')) {
                    $.ajax({
                        url: `/api/products/${productId}`,
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            refreshTable();
                            alert('Product deleted successfully!');
                        },
                        error: function (error) {
                            console.error('Error deleting product:', error);
                        }
                    });
                }
            });

            // Handle Edit action
            $(document).on('click', '[data-action="edit"]', function () {
                const productId = $(this).data('id');
                window.location.href = `/edit-product/${productId}`;
            });

            $(document).on('click', '[data-action="view"]', function () {
                const productId = $(this).data('id');
                window.location.href = `/View/${productId}`;
            });


            // Initial table load
            refreshTable();
        });
    </script>
</body>

</html>