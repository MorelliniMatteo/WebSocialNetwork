let menu = document.querySelector(".menu");
let aside = document.querySelector(".menu-content");

menu.addEventListener('click', () => {
    if(aside.classList.contains("show")){
        aside.classList.remove("show");
    } else {
        aside.classList.add("show");
    }
});

const checkbox = document.querySelector(".checkbox");

// Carica la preferenza del tema al caricamento della pagina
document.addEventListener('DOMContentLoaded', () => {
  const themePreference = getThemePreference();
  if (themePreference) {
    document.body.classList.toggle("dark", themePreference === 'dark');
  }
});

// Aggiorna la preferenza del tema quando il checkbox viene modificato
checkbox.addEventListener('change', () => {
  const isDarkTheme = checkbox.checked;
  document.body.classList.toggle("dark", isDarkTheme);
  
  // Salva la preferenza del tema nei cookie
  setThemePreference(isDarkTheme ? 'dark' : 'light');
});

// Funzione per impostare il cookie con la preferenza del tema
function setThemePreference(theme) {
  document.cookie = `theme=${theme}; expires=${new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toUTCString()}; path=/`;
}

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
