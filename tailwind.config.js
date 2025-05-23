/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./vendor/filament/**/*.blade.php", // هام لدعم filament
  ],
  safelist: [
  'bg-yellow-500',
  'bg-red-500',
  'bg-green-500',
  'bg-blue-500',
  ],
  darkMode: 'class', // أو 'media'
  theme: {
    extend: {
      colors: {
        primary: '#3b82f6', // blue
        success: '#10b981', // green
        warning: '#f59e0b', // yellow
        danger: '#ef4444',  // red
        info: '#06b6d4',    // cyan
      },
    },
  },
  plugins: [],
};