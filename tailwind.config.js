/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#B22222',
                secondary: '#6c757d',
                // ...
            }
        },
    },
    safelist: [
        'tw-bg-gray-300',
        'tw-bg-green-500',
        'tw-left-1',
        'tw-translate-x-14'
    ],
    plugins: [],
    prefix: 'tw-',
}
