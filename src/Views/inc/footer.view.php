<?php

?>
<footer>

</footer>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Script loaded');

        const form = document.querySelector('.editForm');
        const logoInput = document.querySelector('#logo');


        if (!form.dataset.bound) {
            form.dataset.bound = true;


            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                if (logoInput.files.length > 0) {
                    const file = logoInput.files[0];

                    if (!['image/jpeg', 'image/png'].includes(file.type)) {
                        alert('Допустимые форматы: JPG и PNG');
                        return;
                    }

                    const resizedBlob = await resizeImage(file);

                    const resizedFile = new File([resizedBlob], file.name, {type: 'image/jpeg'});
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(resizedFile);
                    logoInput.files = dataTransfer.files;
                }

                const formData = new FormData(form);
                try {
                    const response = await fetch(form.action, {
                        method: form.method,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Cache-Control': 'no-cache',
                        },
                        body: formData,
                    });
                    const result = await response.json();

                    if (!response.ok || result.status !== 'success') {
                        if (result.message && typeof result.message === 'object') {
                            let errorMessages = '';
                            for (const [field, messages] of Object.entries(result.message)) {
                                errorMessages += `${field}: ${messages.join(', ')}\n`;
                            }
                            alert(`Ошибки:\n${errorMessages}`);
                        } else {
                            alert(`Ошибка: ${result.message}`);
                        }
                    } else {

                        alert(result.message);
                    }
                } catch (error) {
                    alert(`Ошибка: ${error.message}`);
                }
            });
        }

        async function resizeImage(file) {
            return new Promise((resolve, reject) => {
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

                        canvas.toBlob(
                            (blob) => {
                                if (blob) {
                                    resolve(blob);
                                } else {
                                    reject(new Error('Ошибка уменьшения изображения'));
                                }
                            },
                            'image/jpeg',
                            0.7 // Качество изображения
                        );
                    };

                    img.src = e.target.result;
                };

                reader.onerror = function () {
                    reject(new Error('Ошибка чтения файла'));
                };

                reader.readAsDataURL(file);
            });
        }
    });

</script>
</body>
</html>