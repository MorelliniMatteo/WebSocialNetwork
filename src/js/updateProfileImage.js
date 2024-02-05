document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('image');
    const imageLabel = document.getElementById('imageLabel');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            imageLabel.innerText = fileInput.files[0].name;
        } else {
            imageLabel.innerText = 'Select Image';
        }
    });
});
