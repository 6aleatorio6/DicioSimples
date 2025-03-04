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
                    DEFAULT: '#D1D5DB', // gray-200 in hex
                    100: '#F3F4F6',
                    200: '#E5E7EB',
                    300: '#D1D5DB',
                    400: '#9CA3AF',
                    500: '#6B7280',
                    600: '#4B5563',
                    700: '#374151',
                    800: '#1F2937',
                    900: '#111827',
                },
                bodySec: {
                    DEFAULT: '#C8B798',
                    100: '#F5F3EF',
                    200: '#EDE8E0',
                    300: '#E4DCCF',
                    400: '#D3C4B0',
                    500: '#C8B798',
                    600: '#B39F7A',
                    700: '#8A7A5E',
                    800: '#625542',
                    900: '#3A3026',
                },
                bodyTri: {
                    DEFAULT: '#88A5BF',
                    100: '#EAF1F7',
                    200: '#D5E3EF',
                    300: '#C0D5E7',
                    400: '#A3C0D9',
                    500: '#88A5BF',
                    600: '#6D8AA5',
                    700: '#526F8B',
                    800: '#375471',
                    900: '#1C3957',
                },
                text: {
                    DEFAULT: '#232A33',
                    100: '#E6E7E8',
                    200: '#C0C3C6',
                    300: '#9A9FA4',
                    400: '#6E747A',
                    500: '#232A33',
                    600: '#1F252D',
                    700: '#1A1F26',
                    800: '#15191F',
                    900: '#101318',
                },
                textSec: {
                    DEFAULT: '#324E73',
                    100: '#E8EDF3',
                    200: '#C5D1E1',
                    300: '#A2B5CF',
                    400: '#7F99BD',
                    500: '#324E73',
                    600: '#2D4667',
                    700: '#263B58',
                    800: '#1F3048',
                    900: '#182538',
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
