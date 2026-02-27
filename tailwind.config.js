import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // ─── DARK MODE ──────────────────────────────────────────────────────────────
    darkMode: 'class',

    // ─── CONTENT ────────────────────────────────────────────────────────────────
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    // ─── THEME ──────────────────────────────────────────────────────────────────
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    25:  '#F5F8FF',
                    50:  '#EFF4FF',
                    100: '#D1E0FF',
                    200: '#B2CCFF',
                    300: '#84ADFF',
                    400: '#528BFF',
                    500: '#2970FF',
                    600: '#155EEF',
                    700: '#004EEB',
                    800: '#0040C1',
                    900: '#00359E',
                    950: '#002366',
                },
                dark: {
                    900: '#1C2333',
                },
            },
            zIndex: {
                1:       '1',
                99999:   '99999',
                999990:  '999990',
            },
            fontSize: {
                'theme-xs':  ['0.75rem',  { lineHeight: '1rem' }],
                'theme-sm':  ['0.875rem', { lineHeight: '1.25rem' }],
                'theme-base':['1rem',     { lineHeight: '1.5rem' }],
                'theme-xl':  ['1.125rem', { lineHeight: '1.75rem' }],
                'title-sm':  ['1.25rem',  { lineHeight: '1.75rem', fontWeight: '600' }],
                'title-md':  ['1.5rem',   { lineHeight: '2rem',    fontWeight: '600' }],
                'title-2xl': ['2rem',     { lineHeight: '2.5rem',  fontWeight: '700' }],
            },
            boxShadow: {
                'theme-xs': '0px 1px 2px 0px rgba(16, 24, 40, 0.05)',
                'theme-sm': '0px 1px 3px 0px rgba(16, 24, 40, 0.10), 0px 1px 2px -1px rgba(16, 24, 40, 0.10)',
                'theme-md': '0px 4px 6px -1px rgba(16, 24, 40, 0.10), 0px 2px 4px -2px rgba(16, 24, 40, 0.10)',
            },
        },
    },

    // ─── PLUGINS ────────────────────────────────────────────────────────────────
    plugins: [
        forms,
    ],
};