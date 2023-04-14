const defaultColors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue'
    ],

    theme: {
        extend: {
            colors: () => ({
                primary:   defaultColors.slate['900'],
                secondary: defaultColors.amber['600'],
                accent:    defaultColors.green['600']
            })
        }
    },

    plugins: [require('@tailwindcss/forms')]
};
