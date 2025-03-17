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
                    $nombre = $_SESSION["user"];
                    echo '
                     <span class="admin-badge">Monitor: ' . $nombre . '</span>';
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
                <button class="action-btn bg-green">
                    <i class="fas fa-play-circle"></i> Iniciar Iteración
                </button>
                <button class="action-btn bg-red" disabled>
                    <i class="fas fa-stop-circle"></i> Finalizar Iteración
                </button>
                <button class="action-btn bg-yellow">
                    <i class="fas fa-file-upload"></i> Cargar Archivo CSV
                </button>
                <button class="action-btn bg-blue" id="generateRandomVehicles">
                    <i class="fas fa-random"></i> Generar Vehículos Aleatorios
                </button>
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
    </script>
</body>

</html>