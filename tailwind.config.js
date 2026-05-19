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
            fontFamily: {
                sans: ['PT Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'green-theme': '#357635',
                'green-light': '#f0f7f1',
                'green-tint': '#f4fcf4',
            }
        },
    },

    plugins: [forms],
};
