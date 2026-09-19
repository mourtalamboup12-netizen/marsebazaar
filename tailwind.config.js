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
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['Sora', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                indigo: {
                    DEFAULT: '#1E2A4A',
                    light: '#2E3F68',
                },
                amber: {
                    DEFAULT: '#E1A940',
                    dark: '#B9822A',
                },
                brick: '#C1502E',
                marche: {
                    green: '#3B6E4E',
                    paper: '#FAF5EA',
                    'paper-dim': '#F1E9D8',
                    ink: '#1B1A17',
                    'ink-soft': '#6b6558',
                    line: '#E4DAC5',
                },
            },
        },
    },

    plugins: [forms],
};