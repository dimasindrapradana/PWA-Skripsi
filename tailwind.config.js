module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css', 
  ],
  theme: {
    extend: {
      colors: {
        primary: '#2563eb', 
        secondary: '#f59e42',
      },
      fontFamily: {
        heading: ['Poppins', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
