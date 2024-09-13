import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
          colors: {
            primary: '#4F46E5', 
            secondary: '#6B7280', 
          },
          spacing: {
            28: '7rem',
            32: '8rem',
          },
        },
      },

    plugins: [
        forms
    ],
};
