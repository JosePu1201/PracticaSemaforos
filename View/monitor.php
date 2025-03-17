<!-- filepath: /opt/lampp/htdocs/Semaforos/View/monitor.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Monitor - Sistema de Tránsito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/admin.css">
    <link rel="stylesheet" href="../assets/simulation.css">
</head>

<body>
    <div class="traffic-background"></div>

    <!-- Header/Navbar -->
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-traffic-light"></i>
                    Sistema de Tránsito

                    <?php
                    session_start();
                    include '../Model/configServer.php';
                    include '../Model/consulSQL.php';

                    // Verificar si las variables de sesión existen
                    if (!isset($_SESSION["user"]) || !isset($_SESSION["UserType"]) || $_SESSION["UserType"] != "Monitor") {
                        header("Location: ../Controller/logout.php");
                        exit(); // Importante añadir exit después de redirect
                    }

                    $nombre = $_SESSION["user"];
                    echo '<span class="admin-badge">Supervisor: ' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . '</span>';
                    ?>

                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto me-4">
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-cog"></i> Configuración</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fas fa-question-circle"></i> Ayuda</a>
                        </li>
                    </ul>

                    <div class="semaforo">
                        <div class="luz rojo"></div>
                        <div class="luz amarillo"></div>
                        <div class="luz verde"></div>
                    </div>

                    <div class="user-actions d-flex">
                        <a href="#" class="btn btn-outline-warning me-2">
                            <i class="fas fa-user-edit"></i> Actualizar Info
                        </a>
                        <a href="../Controller/logout.php" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <div class="container">
            <!-- Selección de Intersección -->
            <div class="grid-container">
                <div class="dashboard-card bg-blue">
                    <h3><i class="fas fa-crosshairs"></i> Intersección Actual</h3>
                    <select class="input-field" name="interseccionSeleccionada" id="interseccionSeleccionada">
                        <?php
                        $interseccion = ejecutarSQL::consultar("SELECT * FROM Interseccion");
                        while ($inter = mysqli_fetch_array($interseccion)) {
                            echo '<option value="' . $inter['id'] . '">' . $inter['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Contenedor para mostrar los vehículos -->
            <div id="vehiculos-container" class="dashboard-card bg-light">
                <h3><i class="fas fa-car"></i> Vehículos en la Intersección</h3>
                <ul id="vehiculos-list">
                    <!-- Aquí se mostrarán los vehículos -->
                </ul>
            </div>

            <!-- Botones de Control -->
            <div class="action-buttons">
                <button class="action-btn bg-green" id="start-iteration">
                    <i class="fas fa-play-circle"></i> Iniciar Iteración
                </button>
                <button class="action-btn bg-red" id="stop-iteration" disabled>
                    <i class="fas fa-stop-circle"></i> Finalizar Iteración
                </button>
                <button class="action-btn bg-yellow">
                    <i class="fas fa-file-upload"></i>
                    <label for="csvFile">Cargar Archivo CSV</label>
                    <input type="file" id="csvFile" accept=".csv" class="d-none">
                </button>
                <button class="action-btn bg-blue" id="generateRandomVehicles">
                    <i class="fas fa-random"></i> Generar Vehículos Aleatorios
                </button>
            </div>
            <div class="dashboard-card bg-light">
                <h3><i class="fas fa-clock"></i> Modificar Tiempos de Semáforos</h3>
                <form id="semaforo-form">
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <select id="direccion" class="input-field">
                            <option value="N">Norte</option>
                            <option value="S">Sur</option>
                            <option value="E">Este</option>
                            <option value="O">Oeste</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tiempo-verde">Tiempo Verde (segundos)</label>
                        <input type="number" id="tiempo-verde" class="input-field" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="tiempo-amarillo">Tiempo Amarillo (segundos)</label>
                        <input type="number" id="tiempo-amarillo" class="input-field" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="tiempo-rojo">Tiempo Rojo (segundos)</label>
                        <input type="number" id="tiempo-rojo" class="input-field" min="1" required>
                    </div>
                    <button type="submit" class="action-btn bg-blue">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </form>
            </div>
            <!-- Visualización de Tráfico -->
            <div class="sim-traffic-panel">
                <h3 class="sim-title"><i class="fas fa-car-side"></i> Simulación en Tiempo Real</h3>
                <div class="sim-intersection">

                    <!-- Calles del cruce -->
                    <div class="sim-street sim-street-horizontal"></div>
                    <div class="sim-street sim-street-vertical"></div>

                    <!-- Líneas divisorias -->
                    <div class="sim-divider sim-divider-horizontal"></div>
                    <div class="sim-divider sim-divider-vertical"></div>

                    <!-- Semáforos -->
                    <div class="sim-traffic-light sim-light-north">
                        <div class="sim-bulb sim-red active"></div>
                        <div class="sim-bulb sim-yellow"></div>
                        <div class="sim-bulb sim-green"></div>
                        <span class="sim-direction">Norte</span>
                    </div>

                    <div class="sim-traffic-light sim-light-east">
                        <div class="sim-bulb sim-red"></div>
                        <div class="sim-bulb sim-yellow"></div>
                        <div class="sim-bulb sim-green active"></div>
                        <span class="sim-direction">Este</span>
                    </div>

                    <div class="sim-traffic-light sim-light-south">
                        <div class="sim-bulb sim-red active"></div>
                        <div class="sim-bulb sim-yellow"></div>
                        <div class="sim-bulb sim-green"></div>
                        <span class="sim-direction">Sur</span>
                    </div>

                    <div class="sim-traffic-light sim-light-west">
                        <div class="sim-bulb sim-red"></div>
                        <div class="sim-bulb sim-yellow active"></div>
                        <div class="sim-bulb sim-green"></div>
                        <span class="sim-direction">Oeste</span>
                    </div>
                </div>
                <!-- Agregar después de sim-intersection -->

                <div class="dashboard-card bg-light">
                    <h3><i class="fas fa-clock"></i> Tiempos de Semáforos</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dirección</th>
                                <th>Rojo (segundos)</th>
                                <th>Amarillo (segundos)</th>
                                <th>Verde (segundos)</th>
                            </tr>
                        </thead>
                        <tbody id="semaforo-table-body">
                            <!-- Aquí se mostrarán los tiempos de los semáforos -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Historial de Archivos -->
            <div class="file-history">
                <h3><i class="fas fa-history"></i> Archivos Cargados</h3>
                <div class="file-list">
                    <div class="file-item">
                        <i class="fas fa-file-csv"></i> simulacion_20231025.csv
                        <span class="file-status success">Cargado</span>
                    </div>
                    <div class="file-item">
                        <i class="fas fa-file-excel"></i> datos_vehiculos.xlsx
                        <span class="file-status warning">Pendiente</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
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
                        li.textContent = `${vehiculo.tipo} - ${vehiculo.placa}- ${vehiculo.direccion}`;
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
            iniciarIteracion();
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

        let inicioIteracion = null;

        function iniciarIteracion() {
            inicioIteracion = new Date().toISOString();
            console.log("Iteración iniciada a las: " + inicioIteracion);
        }
        let vehiculosInfo = [];
        function finalizarIteracion() {
            const finIteracion = new Date().toISOString();
            console.log("Iteración finalizada a las: " + finIteracion);

            // Mostrar área de texto emergente para el comentario
            Swal.fire({
                title: 'Comentario sobre la iteración',
                input: 'textarea',
                inputLabel: 'Comentario',
                inputPlaceholder: 'Escribe tu comentario aquí...',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const comentario = result.value;
                    const usuario = '<?php echo $_SESSION["user"]; ?>'; // Obtener el nombre de usuario de la sesión

                    // Enviar los datos al servidor
                    fetchCrearIteracion(inicioIteracion, finIteracion, usuario, comentario);
                    console.log(JSON.stringify(vehiculosInfo, null, 2));
                }
            });
        }

        async function fetchCrearIteracion(inicio, fin, usuario, comentario) {
            const response = await fetch('../Controller/crearIteracion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `inicio=${inicio}&fin=${fin}&usuario=${usuario}&comentario=${comentario}`
            });

            if (response.ok) {
                console.log("Iteración guardada correctamente");
            } else {
                console.error("Error al guardar la iteración");
            }
        }
    </script>

    <script>
        let simulationInterval; // Para controlar la generación de vehículos
        let lightTimeout; // Para controlar el cambio de semáforos
        let isSimulationRunning = false; // Bandera para el estado de la simulación

        async function startSimulation() {


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

            async function lightCycle() {
                if (!isSimulationRunning) return; // Detener el ciclo si la simulación no está activa

                const currentLight = lights[order[currentIndex]]; // Semáforo actual
                const nextIndex = (currentIndex + 1) % order.length; // Próximo semáforo
                const interseccionId = document.getElementById('interseccionSeleccionada').value;
                const semaforos = await fetchSemaforos(interseccionId);
                // Separar semáforos por dirección
                const semaforosPorDireccion = {
                    N: null,
                    S: null,
                    E: null,
                    O: null
                };

                // Agrupar los semáforos por dirección
                semaforos.forEach(semaforo => {
                    if (semaforo.direccion === 'N') {
                        semaforosPorDireccion.N = semaforo;
                    } else if (semaforo.direccion === 'S') {
                        semaforosPorDireccion.S = semaforo;
                    } else if (semaforo.direccion === 'E') {
                        semaforosPorDireccion.E = semaforo;
                    } else if (semaforo.direccion === 'O') {
                        semaforosPorDireccion.O = semaforo;
                    }
                });

                // Ahora puedes acceder a los tiempos de cada dirección, por ejemplo:
                const tiempoVerdeN = semaforosPorDireccion.N?.tiempoVerde;
                const tiempoAmarilloN = semaforosPorDireccion.N?.tiempoAmarillo;

                const tiempoVerdeS = semaforosPorDireccion.S?.tiempoVerde;
                const tiempoAmarilloS = semaforosPorDireccion.S?.tiempoAmarillo;

                const tiempoVerdeE = semaforosPorDireccion.E?.tiempoVerde;
                const tiempoAmarilloE = semaforosPorDireccion.E?.tiempoAmarillo;

                const tiempoVerdeO = semaforosPorDireccion.O?.tiempoVerde;
                const tiempoAmarilloO = semaforosPorDireccion.O?.tiempoAmarillo;
                if (currentIndex === 0) {
                    Object.values(lights).forEach(light => setLightState(light, 'red'));
                    setLightState(currentLight, 'green');
                    lightTimeout = setTimeout(() => {
                        // Cambia a amarillo después de 5s
                        setLightState(currentLight, 'yellow');

                        lightTimeout = setTimeout(() => {
                            // Cambia al siguiente semáforo después de 2s
                            currentIndex = nextIndex;
                            lightCycle();
                        }, tiempoAmarilloN * 1000); // Amarillo 2s

                    }, tiempoVerdeN * 1000); // Verde 5s

                } else if (currentIndex === 1) {
                    Object.values(lights).forEach(light => setLightState(light, 'red'));
                    setLightState(currentLight, 'green');
                    lightTimeout = setTimeout(() => {
                        // Cambia a amarillo después de 5s
                        setLightState(currentLight, 'yellow');

                        lightTimeout = setTimeout(() => {
                            // Cambia al siguiente semáforo después de 2s
                            currentIndex = nextIndex;
                            lightCycle();
                        }, tiempoAmarilloE * 1000); // Amarillo 2s

                    }, tiempoVerdeE * 1000);

                } else if (currentIndex === 2) {
                    Object.values(lights).forEach(light => setLightState(light, 'red'));
                    setLightState(currentLight, 'green');
                    lightTimeout = setTimeout(() => {
                        // Cambia a amarillo después de 5s
                        setLightState(currentLight, 'yellow');

                        lightTimeout = setTimeout(() => {
                            // Cambia al siguiente semáforo después de 2s
                            currentIndex = nextIndex;
                            lightCycle();
                        }, tiempoAmarilloS * 1000); // Amarillo 2s

                    }, tiempoVerdeS * 1000);

                } else if (currentIndex === 3) {
                    Object.values(lights).forEach(light => setLightState(light, 'red'));
                    setLightState(currentLight, 'green');
                    lightTimeout = setTimeout(() => {
                        // Cambia a amarillo después de 5s
                        setLightState(currentLight, 'yellow');

                        lightTimeout = setTimeout(() => {
                            // Cambia al siguiente semáforo después de 2s
                            currentIndex = nextIndex;
                            lightCycle();
                        }, tiempoAmarilloO * 1000); // Amarillo 2s

                    }, tiempoVerdeO * 1000);
                }
                // Activar verde en el actual y rojo en todos los demás
                // Verde 5s
            }

            lightCycle(); // Iniciar el ciclo

            // Generación de vehículos
            const vehicleQueues = {
                north: [],
                south: [],
                east: [],
                west: []
            };

            function createVehicle(direction) {
                if (!isSimulationRunning) return; // Detener la creación si la simulación está apagada

                const vehicleElem = document.createElement('div');
                vehicleElem.className = `sim-vehicle ${direction}`;
                document.querySelector('.sim-intersection').appendChild(vehicleElem);

                let x, y;
                const speed = 2;
                if (direction === 'north') {
                    x = 250;
                    y = -30;
                } else if (direction === 'south') {
                    x = 250;
                    y = 530;
                } else if (direction === 'east') {
                    x = 530;
                    y = 250;
                } else if (direction === 'west') {
                    x = -30;
                    y = 250;
                }

                // Creamos el objeto vehículo con los datos de llegada
                const vehicleObj = {
                    element: vehicleElem,
                    x: x,
                    y: y,
                    speed: speed,
                    arrivalTime: Date.now(), // Tiempo en el que llegó al semáforo
                    passedIntersection: false
                };

                // Agrega el vehículo a la cola correspondiente
                vehicleQueues[direction].push(vehicleObj);

                // Si es el primer vehículo de la cola, iniciamos su movimiento
                if (vehicleQueues[direction].length === 1) {
                    moveVehicle(vehicleObj, direction);
                }
            }

            function moveVehicle(vehicleObj, direction) {
                function animate() {
                    if (!isSimulationRunning) return; // Si se detuvo la simulación, termina

                    // Consultar el semáforo actual para esa dirección
                    const currentLight = lights[direction]; // lights obtenido en startSimulation (debe estar en alcance)
                    const isGreen = currentLight.querySelector('.sim-green.active');

                    // Si el semáforo no está en verde, esperar sin mover el vehículo
                    if (!isGreen) {
                        requestAnimationFrame(animate);
                        return;
                    }

                    // Mover el vehículo según su dirección
                    if (direction === 'north') {
                        vehicleObj.y += vehicleObj.speed;
                    } else if (direction === 'south') {
                        vehicleObj.y -= vehicleObj.speed;
                    } else if (direction === 'east') {
                        vehicleObj.x -= vehicleObj.speed;
                    } else if (direction === 'west') {
                        vehicleObj.x += vehicleObj.speed;
                    }
                    vehicleObj.element.style.transform = `translate(${vehicleObj.x}px, ${vehicleObj.y}px)`;

                    // Si el vehículo sale del área visible, lo eliminamos y actualizamos la cola
                    if (vehicleObj.y < -50 || vehicleObj.y > 550 || vehicleObj.x < -50 || vehicleObj.x > 550) {
                        const timeTaken = (Date.now() - vehicleObj.arrivalTime) / 1000; // En segundos
                        console.log(`El vehículo de dirección ${direction} pasó en ${timeTaken} segundos`);
                        vehiculosInfo.push({
                            direccion: direction,
                            tiempo: timeTaken
                        });
                        vehicleObj.element.remove();
                        vehicleQueues[direction].shift();
                        // Iniciar el siguiente vehículo de la cola con un pequeño retraso
                        if (vehicleQueues[direction].length > 0) {
                            setTimeout(() => {
                                moveVehicle(vehicleQueues[direction][0], direction);
                            }, 500);
                        }
                        return;
                    }

                    requestAnimationFrame(animate);
                }
                animate();
            }
            simulationInterval = setInterval(() => {
                const directions = ['north', 'south', 'east', 'west'];
                createVehicle(directions[Math.floor(Math.random() * 4)]);
            }, 1500);
        }

        document.getElementById('stop-iteration').addEventListener('click', function() {
            isSimulationRunning = false; // Cambiar el estado de la simulación
            clearInterval(simulationInterval); // Detener la generación de vehículos
            clearTimeout(lightTimeout); // Detener los cambios de semáforo

            // Apagar todos los semáforos (rojo por defecto)
            document.querySelectorAll('.sim-bulb').forEach(bulb => bulb.classList.remove('active'));
            document.querySelectorAll('.sim-red').forEach(red => red.classList.add('active'));

            // Restaurar los botones
            document.getElementById('start-iteration').disabled = false;
            document.getElementById('stop-iteration').disabled = true;
            finalizarIteracion();
        });
    </script>
</body>

</html>