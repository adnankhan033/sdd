/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./**/*.html.twig",  // Scan twig templates for Tailwind classes
      "./assets/js/**/*.js" // If you have custom JS that uses classes
    ],
    theme: {
      extend: {}
    },
    plugins: []
  }
  