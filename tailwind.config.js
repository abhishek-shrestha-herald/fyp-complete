import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/usernotnull/tall-toasts/config/**/*.php',
        './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            screen: {
                sm: "576px",
                md: "768px",
                lg: "992px",
                xl: "1200px",
            },
            container: {
                center: true,
                padding: "1rem",
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", "sans-serif"],
                roboto: ["Roboto", "sans-serif"],
            },
            colors: {
                primary: "#1bae4e",
            },
        },
    },

    plugins: [forms, typography],
};
