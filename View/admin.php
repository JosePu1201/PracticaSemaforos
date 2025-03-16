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
                    $nombre = $_SESSION["user"];
                    echo '
                     <span class="admin-badge">Administrador: '.$nombre.'</span>';
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
                    <h2 class="text-center fw-bold mb-4">Panel de Administrador</h2>
                    <p class="text-center">Gestión de usuarios, intersecciones y semáforos del sistema</p>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="admin-summary">
                        <h3><i class="fas fa-chart-line me-2"></i>Resumen del Sistema</h3>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="summary-item">
                                    <div class="summary-icon" style="background-color: rgba(26, 115, 232, 0.15); color: var(--blue-traffic);">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="summary-text">
                                        <div>Total Usuarios</div>
                                        <div class="summary-count">128</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="summary-item">
                                    <div class="summary-icon" style="background-color: rgba(52, 199, 89, 0.15); color: var(--green-light);">
                                        <i class="fas fa-road"></i>
                                    </div>
                                    <div class="summary-text">
                                        <div>Total Calles</div>
                                        <div class="summary-count">45</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="summary-item">
                                    <div class="summary-icon" style="background-color: rgba(255, 204, 0, 0.15); color: var(--yellow-light);">
                                        <i class="fas fa-traffic-light"></i>
                                    </div>
                                    <div class="summary-text">
                                        <div>Semáforos Activos</div>
                                        <div class="summary-count">62</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="action-buttons">
                        <!-- Botones de acción -->
                        <button class="action-btn btn-user text-white" onclick="showForm('userForm')">
                            <i class="fas fa-user-plus"></i> Gestionar Usuarios
                        </button>
                        <button class="action-btn btn-intersection text-white" onclick="showForm('vias')">
                            <i class="fas fa-road"></i> Administrar Vías
                        </button>
                        <button class="action-btn btn-traffic-light text-white" onclick="showForm('semaforo')">
                            <i class="fas fa-traffic-light"></i> Control Semáforos
                        </button>
                    </div>
                </div>
            </div>

            <!-- Formulario de Usuario (Ejemplo) -->
            <div class="form-container" id="userForm">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-user-cog me-2"></i>Nuevo Usuario</h4>
                    <button class="form-close">&times;</button>
                </div>
                <form action="../Controller/newUser.php" method="post" role="form" class="FormCatElec" data-form="login">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="input-field" required name="usuarioNuevo"> Sin espacios
                    </div>
                    <div class="form-group">
                        <label>Nombre de usuario</label>
                        <input type="text" class="input-field" required name="nombreUserNuevo">
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" class="input-field" required name="emailNuevo">
                    </div>
                    <div class="form-group">
                        <label>Contrasenea</label>
                        <input type="password" class="input-field" name="newPass" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de usuario</label>
                        <select class="input-field" name="rolNuevo" required>
                            <option value="">Seleccionar rol</option>
                            <option value="monitor">Monitor</option>
                            <option value="supervisor">Supervisor</option>
                        </select>
                    </div>
                    <button type="submit" class="form-submit-btn btn-user-submit">
                        <i class="fas fa-save me-2"></i>Guardar Usuario
                    </button>
                </form>
            </div>
            <!-- formulario para la creacion de interseccion -->
            <div class="form-container" id="vias">



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
                    text-align: center;
                    /* Centra el contenido dentro del contenedor */
                }

                .form-img {
                    display: block;
                    margin: 0 auto;
                    /* Centra la imagen */
                    width: 80%;
                    /* Ajusta el tamaño sin ocupar toda la pantalla */
                    max-width: 500px;
                    /* Límite de tamaño para evitar imágenes muy grandes */
                    height: auto;
                    border-radius: 8px;
                    /* Opcional: bordes redondeados */
                }
            </style>

            <!-- formulario para la creacion de semaforos -->
            <div class="form-container" id="semaforo">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-user-cog me-2"></i>Nuevo Semaforo</h4>
                    <button class="form-close">&times;</button>
                </div>
                <img src="../assets/semaforos.jpeg" alt="Calles" class="form-img">
                <form action="../Controller/newSemaforo.php" method="post" role="form" class="FormCatElec" data-form="login">
                    <div class="form-group">
                        <label>Número de interseccion</label>
                        <input type="number" name="interseccion" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo para color Verde</label>
                        <input type="number" name="timeGreen" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo para color amarillo</label>
                        <input type="number" name="timeYellow" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Tiempo para color Rojo</label>
                        <input type="number" name="timeRed" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label>Tipo de usuario</label>
                        <select class="input-field" name="direccion" required>
                            <option value="">Seleccionar Direccion</option>
                            <option value="norte">Norte</option>
                            <option value="sur">Sur</option>
                            <option value="este">Este</option>
                            <option value="oeste">Oeste</option>
                        </select>
                    </div>
                    <button type="submit" class="form-submit-btn btn-user-submit">
                        <i class="fas fa-save me-2"></i>Guardar Interseccion
                    </button>
                </form>
            </div>


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
    </script>
</body>

</html>