import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
        "./node_modules/flowbite/**/*.js",
        "./node_modules/flowbite-datepicker/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Yantramanav",
                    "Figtree",
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            colors: {
                primary: "#CD5700",
                secondary: "#D77933",
                "secondary-text": "#E7E7E7",
                tertiary: "#863900",
                "primary-light": "#F1F1F1",
            },
            backgroundImage: {
                "hero-cualtos": "url('/public/img/login_bg.png')",
                login: "url('/public/img/log.png')",
            },
        },
    },

    plugins: [
        forms,
        require("tailwind-hamburgers"),
        require("flowbite/plugin"),
    ],
};
