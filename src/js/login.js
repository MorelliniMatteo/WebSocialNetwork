const chkSignup = document.getElementById('chk-signup');
const chkLogin = document.getElementById('chk-login');
const loginLabel = document.getElementById('loginLabel');

chkLogin.addEventListener('change', function() {
    if (chkSignup.checked === true) {
        chkSignup.checked = !this.checked; // Se è selezionata, la deseleziona
    } else {
        chkSignup.checked = this.checked; // Se non è selezionata, la seleziona
    }
    
    //chkSignup.checked = !this.checked;
});

loginLabel.addEventListener('click', function() {
    chkLogin.checked = !chkLogin.checked;
    chkSignup.checked = !chkLogin.checked;

    // Simula il click sulla chk-signup
    const event = new MouseEvent('click', {
        'view': window,
        'bubbles': true,
        'cancelable': true
    });
    chkSignup.dispatchEvent(event);
});