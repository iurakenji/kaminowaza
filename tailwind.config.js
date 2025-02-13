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
          color_1: 'var(--color_1)',
          color_2: 'var(--color_2)',
          color_3: 'var(--color_3)',
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