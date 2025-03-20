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
                body: {
                    DEFAULT: '#e0e0e0' /* Fundo suave contrastando bem */,
                    200: '#d1d1d1',
                    300: '#bababa',
                    400: '#9e9e9e',
                    500: '#8c8c8c',
                    700: '#717171',
                },
                bodySec: {
                    DEFAULT: '#4a7b98',
                    200: '#8db7d2',
                    300: '#7faec9',
                    400: '#6ba5b8',
                    500: '#4f88a7',
                    700: '#3e6b7b',
                },
                bodyTri: {
                    DEFAULT: '#4B6499',
                    200: '#8193B8',
                    300: '#667BA8',
                    400: '#445A8A',
                    500: '#3C507A',
                    700: '#35466B',
                },
                text: {
                    DEFAULT: '#121212' /* Ajustando para melhor contraste */,
                    200: '#333333',
                    300: '#4d4d4d',
                    400: '#292929',
                    500: '#1c1c1c',
                    700: '#000000',
                },
                textSec: {
                    DEFAULT: '#e3f7dd',
                    200: '#d0e4e8',
                    300: '#b8d0d8',
                    400: '#a0bcc8',
                    500: '#88a8b8',
                    700: '#6a8694',
                },
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
