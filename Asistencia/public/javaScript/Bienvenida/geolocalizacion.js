document.getElementById('marcar').addEventListener('click', function () {
    const procesandoDiv = document.getElementById('procesando');
    const respuestaDiv = document.getElementById('respuesta');

    if ("geolocation" in navigator) {
        procesandoDiv.classList.remove('d-none');
        respuestaDiv.classList.add('d-none');
        respuestaDiv.innerHTML = '';

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                console.log(`Ubicacion: ${lat}, ${lon}`);

                fetch('/bievenida/marcar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ lat: lat, lon: lon })
                })
                    .then(res => res.json())
                    .then(data => {
                        let html = "";
                        if (data.dentro) {
                            html += `<h5 class="text-success">✔ Estás dentro del campus (100m)</h5>`;
                        } else {
                            html += `<h5 class="text-danger">✖ No estás dentro del campus (100m)</h5>`;
                        }

                        html += `
                            <p><strong>Tu ubicación:</strong></p>
                            <ul>
                                <li><strong>Latitud:</strong> ${data.lat}</li>
                                <li><strong>Longitud:</strong> ${data.lon}</li>
                            </ul>
                            <p><strong>Ubicación de la escuela:</strong></p>
                            <ul>
                                <li><strong>Latitud:</strong> ${data.campusLat}</li>
                                <li><strong>Longitud:</strong> ${data.campusLon}</li>
                            </ul>
                        `;

                        respuestaDiv.innerHTML = html;
                        respuestaDiv.classList.remove('d-none');
                    })
                    .catch(err => {
                        alert("Ocurrió un error al enviar los datos: " + err.message);
                    })
                    .finally(() => {
                        procesandoDiv.classList.add('d-none');
                    });

            },
            function (err) {
                procesandoDiv.classList.add('d-none');
                switch (err.code) {
                    case 1: alert("Permiso denegado"); break;
                    case 2: alert("Posición no disponible"); break;
                    case 3: alert("Timeout al obtener ubicación"); break;
                    default: alert("Error desconocido: " + err.message);
                }
            },
            { enableHighAccuracy: true, timeout: 15000 }
        );
    } else {
        alert("Tu navegador no soporta geolocalización.");
    }
});
