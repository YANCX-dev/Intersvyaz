console.log("Edit script loaded")

document.querySelector('form').addEventListener('submit', async function (event) {

    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const response = await fetch(form.action, {
        method: form.method,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Cache-Control': 'no-cache',
        },
        body: formData,
    });


    if (!response.ok) {
        throw new Error('Произошла ошибка при обновлении тарифа');
    }

    const result = await response.json();

    if (result.status === 'success') {
        alert(result.message);
    } else {
        alert(`Ошибка: ${result.message}`);
    }

});

