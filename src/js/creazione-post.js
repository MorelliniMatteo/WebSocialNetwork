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

document.addEventListener('DOMContentLoaded', function () {
    function openGallery() {
        document.getElementById('photoInput').click();
    }

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

    function handleConfirmation() {
        console.log("Funzione handleConfirmation chiamata");
        const photoInput = document.getElementById('photoInput');
        const descriptionInput = document.getElementById('descriptionInput');

        // Resetta i campi
        photoInput.value = '';
        document.getElementById('postImage').src = '../icon/aggiungi-foto.svg';
        descriptionInput.value = '';
    }

    document.getElementById('photoInput').addEventListener('change', handlePhotoUpload);
});
	