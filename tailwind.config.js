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
                "app-white": "#f8fafc",
                "app-black": "#111827"
            }
        },
    },
    plugins: [],
};
