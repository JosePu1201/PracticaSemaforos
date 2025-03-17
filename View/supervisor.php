<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Sistema de Tránsito</title>
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

                    // Verificar si las variables de sesión existen
                    if (!isset($_SESSION["user"]) || !isset($_SESSION["UserType"]) || $_SESSION["UserType"] != "Supervisor") {
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
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="text-center fw-bold mb-4">Panel de Supervision</h2>
                    <p class="text-center">Reportes de inicios de sesion e Iteraciones</p>
                </div>
            </div>

            <!-- Stats Summary -->


            <!-- Action Buttons -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="action-buttons">
                        <!-- Botones de acción -->
                        <button class="action-btn btn-user text-white" onclick="showForm('consultaIniciosSesion')">
                            <i class="fas fa-user-plus"></i> Inicios de sesion
                        </button>
                        <button class="action-btn btn-intersection text-white" onclick="showForm('consultaIteraciones')">
                            <i class="fas fa-road"></i> Iteraciones
                        </button>
                    </div>
                </div>
            </div>

            <!-- Formulario de inicio de sesion -->
            <div class="form-container" id="consultaIniciosSesion">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-search me-2"></i>Consulta de Inicios de Sesión</h4>
                    <button class="form-close">&times;</button>
                </div>
                <form id="consultaSesion" method="post">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="input-field" name="usuarioConsulta" required>
                    </div>
                    <button type="submit" class="form-submit-btn btn-user-submit">
                        <i class="fas fa-search me-2"></i>Consultar
                    </button>
                </form>
                <div id="resultadosConsulta"></div>
            </div>

            <!-- Formulario de iteraciones -->
            <div class="form-container" id="consultaIteraciones">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-search me-2"></i>Consulta de Iteraciones</h4>
                    <button class="form-close">&times;</button>
                </div>
                <form id="consultaIteracionesForm" method="post">
                    <button type="submit" class="form-submit-btn btn-user-submit">
                        <i class="fas fa-search me-2"></i>Consultar
                    </button>
                </form>
                <div id="resultadosIteraciones"></div>
            </div>

            <!-- formulario para la creacion de interseccion -->
            <div class="form-container" id="iteracion">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-user-cog me-2"></i>Nueva Interseccion</h4>
                    <button class="form-close">&times;</button>
                </div>
                <img src="../assets/calles.jpeg" alt="Calles" class="form-img">
                <form action="../Controller/newInterseccion.php" method="post" role="form" class="FormCatElec" data-form="login">
                    <div class="form-group">
                        <label>Número calle</label>
                        <input type="number" name="calle" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Número avenida</label>
                        <input type="number" name="numAv" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Número Zona</label>
                        <input type="number" name="numZona" class="input-field" required>
                    </div>
                    <button type="submit" class="form-submit-btn btn-user-submit">
                        <i class="fas fa-save me-2"></i>Guardar Interseccion
                    </button>
                </form>
            </div>

            <style>
                .form-container {
                    display: none; /* Ocultar todos los formularios inicialmente */
                    text-align: center; /* Centra el contenido dentro del contenedor */
                }

                .form-img {
                    display: block;
                    margin: 0 auto; /* Centra la imagen */
                    width: 80%; /* Ajusta el tamaño sin ocupar toda la pantalla */
                    max-width: 500px; /* Límite de tamaño para evitar imágenes muy grandes */
                    height: auto;
                    border-radius: 8px; /* Opcional: bordes redondeados */
                }
            </style>

            <!-- Footer -->
            <footer class="footer mt-auto">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-0">
                                © 2024 Sistema de Tránsito. Todos los derechos reservados.
                                <span class="d-block d-md-inline mt-2 mt-md-0">
                                    <a href="#" class="text-light mx-2">Políticas de Privacidad</a> |
                                    <a href="#" class="text-light mx-2">Términos de Servicio</a>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
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

        async function fetchIniciosSesion(usuarioConsulta) {
            const response = await fetch('../Controller/consultaIniciosSesion.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `usuarioConsulta=${usuarioConsulta}`
            });
            return await response.json();
        }

        async function fetchIteraciones() {
            const response = await fetch('../Controller/getIteraciones.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
            return await response.json();
        }

        document.getElementById('consultaSesion').addEventListener('submit', async function(e) {
            e.preventDefault();

            const usuarioConsulta = document.querySelector('input[name="usuarioConsulta"]').value;
            const resultados = await fetchIniciosSesion(usuarioConsulta);

            console.log(resultados); // Imprimir los datos obtenidos en la consola

            const resultadosDiv = document.getElementById('resultadosConsulta');
            resultadosDiv.innerHTML = '<h5>Resultados de la Consulta:</h5>';
            if (resultados.length > 0) {
                const table = document.createElement('table');
                table.className = 'table table-striped';
                const thead = document.createElement('thead');
                thead.innerHTML = '<tr><th>Usuario</th><th>Fecha Inicio</th><th>Fecha Final</th><th>Tiempo Total</th></tr>';
                table.appendChild(thead);
                const tbody = document.createElement('tbody');
                resultados.forEach(resultado => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td>${resultado.usuario}</td><td>${resultado.fechaInicio}</td><td>${resultado.fechaFinal}</td><td>${resultado.tiempoTotal}</td>`;
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);
                resultadosDiv.appendChild(table);
            } else {
                resultadosDiv.innerHTML += '<p>No se encontraron resultados.</p>';
            }
        });

        document.getElementById('consultaIteracionesForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const resultados = await fetchIteraciones();

            console.log(resultados); // Imprimir los datos obtenidos en la consola

            const resultadosDiv = document.getElementById('resultadosIteraciones');
            resultadosDiv.innerHTML = '<h5>Resultados de la Consulta:</h5>';
            if (resultados.length > 0) {
                const table = document.createElement('table');
                table.className = 'table table-striped';
                const thead = document.createElement('thead');
                thead.innerHTML = '<tr><th>ID</th><th>Monitor</th><th>Inicio</th><th>Fin</th><th>Comentario</th></tr>';
                table.appendChild(thead);
                const tbody = document.createElement('tbody');
                resultados.forEach(resultado => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td>${resultado.id}</td><td>${resultado.monitor}</td><td>${resultado.inicio}</td><td>${resultado.fin}</td><td>${resultado.comentario}</td>`;
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);
                resultadosDiv.appendChild(table);
            } else {
                resultadosDiv.innerHTML += '<p>No se encontraron resultados.</p>';
            }
        });
    </script>
</body>

</html>