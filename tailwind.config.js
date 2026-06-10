import defaultTheme from 'tailwindcss/defaultTheme';

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
            },
            colors: {
                scms: {
                    primary: '#004AC6',
                    bg: '#FAF8FF',
                    text: '#191B23',
                    muted: '#434655',
                    border: '#EDEDF9',
                    'border-input': '#C3C6D7',
                    badge: '#D0E1FB',
                    'badge-text': '#54647A',
                },
            },
            boxShadow: {
                card: '0 4px 20px rgba(0, 0, 0, 0.04)',
                btn: '0 8px 30px rgba(0, 0, 0, 0.08)',
            },
        },
    },
    plugins: [],
};
