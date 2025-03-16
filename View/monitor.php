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
                    <select class="input-field" name="interseccionSeleccionada" >
                        <?php
                        $interseccion = ejecutarSQL::consultar("SELECT * FROM nterseccion");
                        while ($inter = mysqli_fetch_array($interseccion)) {
                            echo '
                        <option>' . $inter['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
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
                <button class="action-btn bg-blue">
                    <i class="fas fa-random"></i> Generar Vehículos Aleatorios
                </button>
            </div>

            <!-- Visualización de Tráfico -->
            <div class="traffic-visualization">
                <h3><i class="fas fa-car-side"></i> Simulación en Tiempo Real</h3>
                <div class="simulation-grid">
                    <div class="lane horizontal"></div>
                    <div class="lane vertical"></div>
                    <div class="vehicle-car"></div>
                    <div class="vehicle-bus"></div>
                    <div class="vehicle-truck"></div>
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
        function showForm(formId) {
            // Oculta todos los formularios
            document.querySelectorAll('.form-container').forEach(form => {
                form.style.display = 'none';
            });

            // Muestra el formulario solicitado
            const form = document.getElementById(formId);
            if (form) {
                form.style.display = 'block';
                form.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        // Cerrar formularios
        document.querySelectorAll('.form-close').forEach(closeBtn => {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                closeBtn.closest('.form-container').style.display = 'none';
            });
        });
    </script>
</body>

</html>