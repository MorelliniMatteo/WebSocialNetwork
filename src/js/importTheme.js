
// Carica la preferenza del tema al caricamento della pagina
document.addEventListener('DOMContentLoaded', () => {
  const themePreference = getThemePreference();
  if (themePreference) {
    document.body.classList.toggle("dark", themePreference === 'dark');
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