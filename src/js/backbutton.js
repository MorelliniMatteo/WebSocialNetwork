function goBack() {
    // Salva l'URL corrente
    let currentURL = window.location.href;

    // Reindirizza alla pagina precedente
    window.history.back();

    // Si può anche utilizzare setTimeout per assicurarti che l'URL sia stato modificato prima di tornare indietro
    setTimeout(function() {
        // Torna all'URL originale se non ci sono pagine precedenti nello storico
        if (window.location.href === currentURL) {
            window.location.href = currentURL;
        }
    }, 100);
}