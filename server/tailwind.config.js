import forms from '@tailwindcss/forms';
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                ...defaultTheme.colors,
                body: '#E5E7EB', // gray-200 in hex
                bodySec: '#C8B798',
                bodyTri: '#88A5BF',
                text: '#232A33',
                textSec: '#324E73',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                Jomhuria: ['Jomhuria', ...defaultTheme.fontFamily.sans], // Adiciona a fonte Johuria,
                inter: ['Inter', ...defaultTheme.fontFamily.sans], // Adiciona a fonte Inter,
            },
        },
    },

    plugins: [forms],
};
