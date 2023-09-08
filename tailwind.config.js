/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    screens: {
      'res' : '1100px'
    },
    extend: {
      colors: {
        'primary-color' : '#0057A3',
        'primary_light_color' : '#E2EFEF',
        'accent-color' : '#FFA600',
        "light-red-color" : "#FF5555",
        "light-green-color" : "#529665",
        "light-gray-color" : "#F0F0F0",
        "dark-gray-color" : "#696060"

      }
    },
  },
  plugins: [],
}

