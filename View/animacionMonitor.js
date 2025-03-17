
document.getElementById('interseccionSeleccionada').addEventListener('change', function() {
    const interseccionId = this.value;
    fetchVehiculos(interseccionId);
});

document.getElementById('generateRandomVehicles').addEventListener('click', function() {
    const interseccionId = document.getElementById('interseccionSeleccionada').value;
    generateRandomVehicles(interseccionId);
});

function fetchVehiculos(interseccionId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../Controller/getVehiculos.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const vehiculos = JSON.parse(this.responseText);
            const vehiculosList = document.getElementById('vehiculos-list');
            vehiculosList.innerHTML = '';
            vehiculos.forEach(vehiculo => {
                const li = document.createElement('li');
                li.textContent = `${vehiculo.tipo} - ${vehiculo.placa}`;
                vehiculosList.appendChild(li);
            });
        }
    };
    xhr.send('interseccionId=' + interseccionId);
}

function generateRandomVehicles(interseccionId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../Controller/randomVeiculos.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            if (response.status === 'success') {
                fetchVehiculos(interseccionId);
                alert(response.message);
            } else {
                alert('Error al generar vehículos aleatorios');
            }
        }
    };
    xhr.send('interseccionId=' + interseccionId);
}

// Cargar los vehículos de la intersección seleccionada al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const interseccionId = document.getElementById('interseccionSeleccionada').value;
    fetchVehiculos(interseccionId);
});
document.getElementById('csvFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('csvFile', file);
    formData.append('interseccionId', document.getElementById('interseccionSeleccionada').value);

    // Mostrar loader o indicador de carga
    Swal.fire({
        title: 'Cargando archivo...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('../Controller/cargarCSV.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: data.message
                });
                // Recargar la lista de vehículos
                fetchVehiculos(document.getElementById('interseccionSeleccionada').value);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al procesar el archivo: ' + error.message
            });
        });

    // Limpiar el input para permitir cargar el mismo archivo nuevamente
    e.target.value = '';
});

// Agregar dentro del bloque <script> existente
let simulationInterval; // Para controlar la generación de vehículos
let lightTimeout; // Para controlar el cambio de semáforos
let isSimulationRunning = false; // Bandera para el estado de la simulación

document.getElementById('start-iteration').addEventListener('click', async function() {
    const interseccionId = document.getElementById('interseccionSeleccionada').value;
    const semaforos = await fetchSemaforos(interseccionId);

    if (semaforos.length !== 4) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La intersección debe tener 4 semáforos.'
        });
        return;
    } else {
        startSimulation();
    }

    // Iniciar la simulación
    //simulation.start();
    document.getElementById('start-iteration').disabled = true;
    document.getElementById('stop-iteration').disabled = false;
});


async function fetchSemaforos(interseccionId) {
    const response = await fetch('../Controller/getSemaforo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `interseccionId=${interseccionId}`
    });
    return await response.json();
}

// Agregar dentro del bloque <script> existente

document.getElementById('semaforo-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const interseccionId = document.getElementById('interseccionSeleccionada').value;
    const direccion = document.getElementById('direccion').value;
    const tiempoVerde = document.getElementById('tiempo-verde').value;
    const tiempoAmarillo = document.getElementById('tiempo-amarillo').value;
    const tiempoRojo = document.getElementById('tiempo-rojo').value;

    const response = await fetch('../Controller/updateSemaforo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `interseccionId=${interseccionId}&direccion=${direccion}&tiempoVerde=${tiempoVerde}&tiempoAmarillo=${tiempoAmarillo}&tiempoRojo=${tiempoRojo}`
    });
    const result = await response.json();

    if (result.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: result.message
        });
        const interseccionId = document.getElementById('interseccionSeleccionada').value;
        fetchSemaforos(interseccionId).then(updateSemaforoTable);
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: result.message
        });
    }
});

// Agregar dentro del bloque <script> existente

function updateSemaforoTable(semaforos) {
    const tableBody = document.getElementById('semaforo-table-body');
    tableBody.innerHTML = '';

    semaforos.forEach(semaforo => {
        const row = document.createElement('tr');
        row.innerHTML = `
    <td>${semaforo.direccion}</td>
    <td>${semaforo.tiempoRojo}</td>
    <td>${semaforo.tiempoAmarillo}</td>
    <td>${semaforo.tiempoVerde}</td>
`;
        tableBody.appendChild(row);
    });
}

// Cargar los tiempos de los semáforos al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const interseccionId = document.getElementById('interseccionSeleccionada').value;
    fetchSemaforos(interseccionId).then(updateSemaforoTable);
});

let simulando = false;

function startSimulation() {
    simulando = true;
    if (isSimulationRunning) return; // Evitar múltiples inicios
    isSimulationRunning = true;
    const lights = {
        north: document.querySelector('.sim-light-north'),
        east: document.querySelector('.sim-light-east'),
        south: document.querySelector('.sim-light-south'),
        west: document.querySelector('.sim-light-west')
    };

    const order = ['north', 'east', 'south', 'west']; // Orden circular
    let currentIndex = 0; // Empezamos con el semáforo norte

    function setLightState(light, state) {
        light.querySelectorAll('.sim-bulb').forEach(bulb => bulb.classList.remove('active'));
        if (state === 'green') light.querySelector('.sim-green').classList.add('active');
        if (state === 'yellow') light.querySelector('.sim-yellow').classList.add('active');
        if (state === 'red') light.querySelector('.sim-red').classList.add('active');
    }

    function lightCycle() {
        if (!simulando) {
            exit();
        }
        const currentLight = lights[order[currentIndex]]; // Semáforo actual
        const nextIndex = (currentIndex + 1) % order.length; // Próximo semáforo

        // Activar verde en el actual y rojo en todos los demás
        Object.values(lights).forEach(light => setLightState(light, 'red'));
        setLightState(currentLight, 'green');

        setTimeout(() => {
            // Cambia a amarillo después de 5s
            setLightState(currentLight, 'yellow');

            setTimeout(() => {
                // Cambia al siguiente semáforo después de 2s
                currentIndex = nextIndex;
                lightCycle();
            }, 2000); // Amarillo 2s

        }, 5000); // Verde 5s
    }

    lightCycle(); // Iniciar el ciclo

    // Generación de vehículos
    function createVehicle(direction) {
        if (!simulando) {
            exit();
        }
        const vehicle = document.createElement('div');
        vehicle.className = `sim-vehicle ${direction}`;
        document.querySelector('.sim-intersection').appendChild(vehicle);

        let x, y;
        const speed = 2;
        if (direction === 'north') {
            x = 250;
            y = -30;
        }
        if (direction === 'south') {
            x = 250;
            y = 530;
        }
        if (direction === 'east') {
            x = 530;
            y = 250;
        }
        if (direction === 'west') {
            x = -30;
            y = 250;
        }

        function move() {
            const nsGreen = document.querySelector('.sim-light-north .sim-green.active');
            const nsYellow = document.querySelector('.sim-light-north .sim-yellow.active');
            const nsRed = document.querySelector('.sim-light-north .sim-red.active');
            const ewGreen = document.querySelector('.sim-light-east .sim-green.active');
            const ewYellow = document.querySelector('.sim-light-east .sim-yellow.active');
            const ewRed = document.querySelector('.sim-light-east .sim-red.active');
            const ssGreen = document.querySelector('.sim-light-south .sim-green.active');
            const ssYellow = document.querySelector('.sim-light-south .sim-yellow.active');
            const ssRed = document.querySelector('.sim-light-south .sim-red.active');
            const wsGreen = document.querySelector('.sim-light-west .sim-green.active');
            const wsYellow = document.querySelector('.sim-light-west .sim-yellow.active');
            const wsRed = document.querySelector('.sim-light-west .sim-red.active');

            // Detectar semáforo
            let shouldStop = false;
            if (direction === 'north' && (!ssGreen || ssYellow || ssRed) && y > 150) shouldStop = true;
            if (direction === 'south' && (!nsGreen || nsYellow || nsRed) && y < 300) shouldStop = true;
            if (direction === 'east' && (!wsGreen || wsYellow || wsRed) && x < 300) shouldStop = true;
            if (direction === 'west' && (!ewGreen || ewYellow || ewRed) && x > 150) shouldStop = true;

            if (!shouldStop) {
                if (direction === 'north') y += speed;
                if (direction === 'south') y -= speed;
                if (direction === 'east') x -= speed;
                if (direction === 'west') x += speed;

                vehicle.style.transform = `translate(${x}px, ${y}px)`;

                // Eliminar al salir
                if (y < -50 || y > 550 || x < -50 || x > 550) {
                    vehicle.remove();
                    return;
                }
            }
            requestAnimationFrame(move);
        }
        move();
    }

    // Generar vehículos aleatorios
    setInterval(() => {
        const directions = ['north', 'south', 'east', 'west'];
        createVehicle(directions[Math.floor(Math.random() * 4)]);
    }, 1500);

}

document.getElementById('stop-iteration').addEventListener('click', function() {
    simulando = false;
    isSimulationRunning = false; // Cambiar el estado de la simulación
    clearInterval(simulationInterval); // Detener la generación de vehículos
    clearTimeout(lightTimeout); // Detener los cambios de semáforo



    // Apagar todos los semáforos (rojo por defecto)
    document.querySelectorAll('.sim-bulb').forEach(bulb => bulb.classList.remove('active'));
    document.querySelectorAll('.sim-red').forEach(red => red.classList.add('active'));

    // Restaurar los botones
    document.getElementById('start-iteration').disabled = false;
    document.getElementById('stop-iteration').disabled = true;
});
