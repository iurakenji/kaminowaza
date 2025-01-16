/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./www/index.php",
    "./www/Components/**/*.{html,js}",
    "./www/**/*.{html,js,css,php}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
          job: '#ab9b6a',
          jobHover: '#C9BC95AF',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')({
        datatables: true,
    }),
    require('flowbite-typography'),
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}