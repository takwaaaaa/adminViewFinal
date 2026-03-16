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
                // ── Brand: deep electric blue ──────────────────────────────
                brand: {
                    25:  '#EEF2FF',
                    50:  '#E0E7FF',
                    100: '#C7D2FE',
                    200: '#A5B4FC',
                    300: '#818CF8',
                    400: '#6366F1',
                    500: '#4F46E5',
                    600: '#4338CA',
                    700: '#3730A3',
                    800: '#312E81',
                    900: '#1E1B4B',
                    950: '#0F0E2E',
                },
                // ── Dark backgrounds: deep navy ────────────────────────────
                gray: {
                    50:  '#F0F4FF',
                    100: '#E0E7F0',
                    200: '#C8D3E0',
                    300: '#A0AFBE',
                    400: '#6B7A8D',
                    500: '#4A5568',
                    600: '#2D3748',
                    700: '#1A2236',
                    800: '#111827',
                    900: '#0A0F1E',
                    950: '#060A14',
                },
                dark: {
                    900: '#0D1117',
                },
            },
            zIndex: {
                1:       '1',
                99999:   '99999',
                999990:  '999990',
            },
            fontSize: {
                'theme-xs':   ['0.75rem',  { lineHeight: '1rem' }],
                'theme-sm':   ['0.875rem', { lineHeight: '1.25rem' }],
                'theme-base': ['1rem',     { lineHeight: '1.5rem' }],
                'theme-xl':   ['1.125rem', { lineHeight: '1.75rem' }],
                'title-sm':   ['1.25rem',  { lineHeight: '1.75rem', fontWeight: '600' }],
                'title-md':   ['1.5rem',   { lineHeight: '2rem',    fontWeight: '600' }],
                'title-2xl':  ['2rem',     { lineHeight: '2.5rem',  fontWeight: '700' }],
            },
            boxShadow: {
                'theme-xs': '0px 1px 2px 0px rgba(0, 0, 0, 0.3)',
                'theme-sm': '0px 1px 3px 0px rgba(0, 0, 0, 0.4), 0px 1px 2px -1px rgba(0, 0, 0, 0.4)',
                'theme-md': '0px 4px 6px -1px rgba(0, 0, 0, 0.4), 0px 2px 4px -2px rgba(0, 0, 0, 0.4)',
                'neon':     '0 0 20px rgba(79, 70, 229, 0.4), 0 0 40px rgba(79, 70, 229, 0.1)',
            },
        },
    },

    // ─── PLUGINS ────────────────────────────────────────────────────────────────
    plugins: [
        forms,
    ],
};