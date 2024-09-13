Laravel Inventory  System
This is an inventory  system built using Laravel, Vite, Tailwind CSS, and Laravel Breeze for authentication. The system allows users to manage product listings, including adding, editing, deleting, and viewing products. The system also supports image uploads for products and displays them in the product list.

Features
Product CRUD: Create, Read, Update, Delete items.
Image Upload: Upload and display product images.
Authentication: User login and registration using Laravel Breeze.
Responsive Design: Styled using Tailwind CSS for a clean UI.
Prerequisites

Before you begin, ensure you have the following installed on your local machine:
PHP 8.x or later
Composer (Dependency manager for PHP)
Node.js (version 16.x or later) with npm or Yarn
MySQL (or any database supported by Laravel)
Git (optional, for cloning the repository)

Installation Steps

## Install PHP Dependencies
Install all the necessary PHP packages using Composer:
composer install

## Install Node.js Dependencies
Install frontend dependencies for Vite and Tailwind CSS:
npm install

## Configure Environment Variables
Copy the .env.example file to .env and configure the environment variables:

cp .env.example .env

## Update the following variables for your database connection:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

## Set Up the Database
Run the migrations to create the necessary tables:
php artisan migrate

## Compile Frontend Assets
To compile frontend assets like CSS and JavaScript using Vite, run the following command:
npm run build

## For development mode with hot-reloading:
npm run dev

## Serve the Application
Start the Laravel development server:
php artisan serve

## Image Upload Configuration
Make sure that the public/images directory exists and is writable by your web server for image uploads. If it doesn't exist, create it:
store/images
When you upload product images, they will be stored in this folder, and you can access them via http://localhost:8000/storage/images/{image_name}

## Authentication Setup
Laravel Breeze has been installed for basic user authentication. You can modify the authentication views or functionality as needed.

If Breeze authentication isn't set up yet, you can install it with:
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate

## Using Tailwind CSS
Tailwind CSS is pre-configured with Vite. You can modify its configuration via the tailwind.config.js file if needed.

To watch for CSS changes during development, run:
npm run dev



