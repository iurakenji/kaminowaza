/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/index.php",
    "./public/Components/**/*.{html,js}",
    "./public/**/*.{html,js,css,php}",
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