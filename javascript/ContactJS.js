var form = document.getElementById("contact-form");

async function handleSubmit(event) {
    event.preventDefault();
    var data = new FormData(event.target);
    fetch(event.target.action, {
        method: form.method,
        body: data,
        headers: {
            'Accept': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            alert("Se ha enviado correctamente el correo.");
            form.reset();
        } else {
            response.json().then(data => {
                if (Object.hasOwn(data, 'errors')) {
                    alert("No se ha enviado correctamente el correo por unos errores.");
                } else {
                    alert("¡Ups! Hubo un problema al enviar su formulario");
                }
            })
        }
    }).catch(error => {
        alert("¡Ups! Hubo un problema al enviar su formulario");
    });
}
form.addEventListener("submit", handleSubmit)