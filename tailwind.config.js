/** @type {import('tailwindcss').Config} */
module.exports = {
  // --Regarde tous les fichiers HTML et PHP à la racine--
  content: ["./*.{html,php}"],
  
  theme: {
    container: {
      center: true, // centrer à chaque fois que j'utilise la classe container
      padding: '2rem',
    },
    
    extend: {
      colors: {
        'primary': '#54A0FF',    // BLEU
        'secondary': '#2ECC71',  // VERT
        'tertiary': '#FF9F43',   // ORANGE
        'quaternary': '#FF5252', // ROUGE
        'default': '#F5F6FA',    // GRIS FOND
      },
      
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  
  plugins: [],
}