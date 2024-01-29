// Definisci la funzione handlePhotoUpload prima di chiamarla
function handlePhotoUpload(event) {
    const fileInput = document.getElementById('photoInput');
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('postImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}