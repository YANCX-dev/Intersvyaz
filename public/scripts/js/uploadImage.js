console.log('Upload script loaded')
document.querySelector('form').addEventListener('submit', function (event) {

    const logoInput = document.querySelector('#logo');

    if (logoInput.files.length > 0) {

        const file = logoInput.files[0];

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Допустимые форматы: JPG и PNG');
            event.preventDefault();
            return;
        }


        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const maxWidth = 250;
                const maxHeight = 250;

                let width = img.width;
                let height = img.height;


                if (width > height) {
                    if (width > maxWidth) {
                        height = Math.round(height * (maxWidth / width));
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width = Math.round(width * (maxHeight / height));
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);


                canvas.toBlob(function (blob) {

                    const fileInput = new File([blob], file.name, {type: 'image/jpeg'});
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(fileInput);
                    logoInput.files = dataTransfer.files;


                }, 'image/jpeg', 0.7);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        event.preventDefault();
    }
});