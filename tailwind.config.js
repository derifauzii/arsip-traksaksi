import defaultTheme from "tailwindcss/defaultTheme";
const forms = require("@tailwindcss/forms");
const typography = require("@tailwindcss/typography");

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/filament/**/*.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#e0f4ff",
                    100: "#d0e8f2", // pastel hospital blue
                    500: "#5bc0de", // light sky blue
                    600: "#007bff", // medikal blue
                    700: "#0056b3",
                },
                background: "#f8f9fa", // light hospital white
            },
            fontFamily: {
                sans: [
                    "Instrument Sans",
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                    "Apple Color Emoji",
                    "Segoe UI Emoji",
                    "Segoe UI Symbol",
                    "Noto Color Emoji",
                ],
            },
        },
    },
    plugins: [forms, typography],
};
