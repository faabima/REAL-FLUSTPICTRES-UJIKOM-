/** @type {import('tailwindcss').Config} */
module.exports = ({
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily:{
        hurricane: ['Hurricane'],
        pacifico: ['Pacifico'],
      },
      backgroundColor:{
        'bgcolor1':'#FCF9F9',
        'bgcolor2': '#D9D9D9',
        'biru': '#103F77'
      },
      textColor: {
        'abuabu':'#AEAEAE'
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
});

