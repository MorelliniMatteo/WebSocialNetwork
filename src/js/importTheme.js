
// Carica la preferenza del tema al caricamento della pagina
document.addEventListener('DOMContentLoaded', () => {
  const themePreference = getThemePreference();
  if (themePreference) {
    document.body.classList.toggle("dark", themePreference === 'dark');
    if (document.querySelector('.checkbox')){
      document.querySelector(".checkbox").checked = true;
    }
  }
});

// Funzione per ottenere la preferenza del tema dai cookie
function getThemePreference() {
  const cookieArray = document.cookie.split('; ');
  for (const cookie of cookieArray) {
    const [name, value] = cookie.split('=');
    if (name === 'theme') {
      return value;
    }
  }
  return null;
}