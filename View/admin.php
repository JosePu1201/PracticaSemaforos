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
                    if (!isset($_SESSION["user"]) || !isset($_SESSION["UserType"]) || $_SESSION["UserType"] != "Admin") {
                        header("Location: ../Controller/logout.php");
                        exit(); // Importante añadir exit después de redirect
                    }

                    $nombre = $_SESSION["user"];
                    echo '<span class="admin-badge">Administrador: ' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . '</span>';
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
                                        <?php
                                        $salida = ejecutarSQL::consultar("SELECT COUNT(id_usuario) AS total FROM Usuario WHERE id_rol = 2 OR id_rol = 3");
                                        $total = mysqli_fetch_array($salida);
                                        echo '<div class="summary-count">' . $total['total'] . '</div>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="summary-item">
                                    <div class="summary-icon" style="background-color: rgba(52, 199, 89, 0.15); color: var(--green-light);">
                                        <i class="fas fa-road"></i>
                                    </div>
                                    <div class="summary-text">
                                        <div>Total Intersecciones</div>
                                        <?php
                                        $salida = ejecutarSQL::consultar("SELECT COUNT(id) AS total FROM Interseccion");
                                        $total = mysqli_fetch_array($salida);
                                        echo '<div class="summary-count">' . $total['total'] . '</div>';
                                        ?>

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
                                        <?php
                                        $salida = ejecutarSQL::consultar("SELECT COUNT(id) AS total FROM Semaforo");
                                        $total = mysqli_fetch_array($salida);
                                        echo '<div class="summary-count">' . $total['total'] . '</div>';
                                        ?>
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
                    <h4 class="form-title"><i class="fas fa-user-cog me-2"></i>Gestión de Usuarios</h4>
                    <button class="form-close">&times;</button>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary me-2" onclick="showCreateUserForm()">Crear Usuario</button>
                    <button class="btn btn-secondary" onclick="showUserList()">Listar Usuarios</button>
                </div>
                <div id="createUserForm" style="display: none;">
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
                            <label>Contraseña</label>
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
                <div id="userList" style="display: none;">
                    <h5>Lista de Usuarios</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            <!-- Aquí se llenará la tabla con los usuarios -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- formulario para la creacion de interseccion -->
            <div class="form-container" id="vias">
                <div class="form-header">
                    <h4 class="form-title"><i class="fas fa-road me-2"></i>Gestión de Intersecciones</h4>
                    <button class="form-close">&times;</button>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary me-2" onclick="showCreateIntersectionForm()">Crear Intersección</button>
                    <button class="btn btn-secondary" onclick="showIntersectionList()">Listar Intersecciones</button>
                </div>
                <div id="createIntersectionForm" style="display: none;">
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
                            <i class="fas fa-save me-2"></i>Guardar Intersección
                        </button>
                    </form>
                </div>
                <div id="intersectionList" style="display: none;">
                    <h5>Lista de Intersecciones</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Calle</th>
                                <th>Avenida</th>
                                <th>Zona</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody id="intersectionTableBody">
                            <!-- Aquí se llenará la tabla con las intersecciones -->
                        </tbody>
                    </table>
                </div>
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
                    <h4 class="form-title"><i class="fas fa-traffic-light me-2"></i>Gestión de Semáforos</h4>
                    <button class="form-close">&times;</button>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary me-2" onclick="showCreateSemaforoForm()">Crear Semáforo</button>
                    <button class="btn btn-secondary" onclick="showSemaforoList()">Listar Semáforos</button>
                </div>
                <div id="createSemaforoForm" style="display: none;">
                    <img src="../assets/semaforos.jpeg" alt="Calles" class="form-img">
                    <form action="../Controller/newSemaforo.php" method="post" role="form" class="FormCatElec" data-form="login">
                        <div class="form-group">
                            <label>Número de intersección</label>
                            <input type="number" name="interseccion" class="input-field" required>
                        </div>
                        <div class="form-group">
                            <label>Tiempo para color Verde</label>
                            <input type="number" name="timeGreen" class="input-field" required>
                        </div>
                        <div class="form-group">
                            <label>Tiempo para color Amarillo</label>
                            <input type="number" name="timeYellow" class="input-field" required>
                        </div>
                        <div class="form-group">
                            <label>Tiempo para color Rojo</label>
                            <input type="number" name="timeRed" class="input-field" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <select class="input-field" name="direccion" required>
                                <option value="">Seleccionar Dirección</option>
                                <option value="norte">Norte</option>
                                <option value="sur">Sur</option>
                                <option value="este">Este</option>
                                <option value="oeste">Oeste</option>
                            </select>
                        </div>
                        <button type="submit" class="form-submit-btn btn-user-submit">
                            <i class="fas fa-save me-2"></i>Guardar Semáforo
                        </button>
                    </form>
                </div>
                <div id="semaforoList" style="display: none;">
                    <h5>Lista de Semáforos</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Intersección</th>
                                <th>Dirección</th>
                                <th>Verde</th>
                                <th>Amarillo</th>
                                <th>Rojo</th>
                            </tr>
                        </thead>
                        <tbody id="semaforoTableBody">
                            <!-- Aquí se llenará la tabla con los semáforos -->
                        </tbody>
                    </table>
                </div>
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

        function showCreateUserForm() {
            document.getElementById('createUserForm').style.display = 'block';
            document.getElementById('userList').style.display = 'none';
        }

        function showUserList() {
            document.getElementById('createUserForm').style.display = 'none';
            document.getElementById('userList').style.display = 'block';

            // Llamar a la función para cargar la lista de usuarios
            fetchUserList();
        }

        async function fetchUserList() {
            const response = await fetch('../Controller/getUsers.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const users = await response.json();

            const userTableBody = document.getElementById('userTableBody');
            userTableBody.innerHTML = ''; // Limpiar la tabla antes de llenarla
            let contador = 1;
            users.forEach(user => {

                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${contador}</td>
            <td>${user.id}</td>
            <td>${user.nombre}</td>
            <td>${user.correo}</td>
            <td>${user.rol}</td>
        `;
                userTableBody.appendChild(row);
                contador++;
            });
        }

        function showCreateIntersectionForm() {
            document.getElementById('createIntersectionForm').style.display = 'block';
            document.getElementById('intersectionList').style.display = 'none';
        }

        function showIntersectionList() {
            document.getElementById('createIntersectionForm').style.display = 'none';
            document.getElementById('intersectionList').style.display = 'block';

            // Llamar a la función para cargar la lista de intersecciones
            fetchIntersectionList();
        }

        async function fetchIntersectionList() {
            const response = await fetch('../Controller/getIntersections.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const intersections = await response.json();

            const intersectionTableBody = document.getElementById('intersectionTableBody');
            intersectionTableBody.innerHTML = ''; // Limpiar la tabla antes de llenarla
            let contador = 1;
            intersections.forEach(intersection => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${contador}</td>
            <td>${intersection.calle}</td>
            <td>${intersection.avenida}</td>
            <td>${intersection.zona}</td>
            <th>${intersection.nombre}</th>
        `;
                intersectionTableBody.appendChild(row);
                contador++;
            });
        }
        function showCreateSemaforoForm() {
    document.getElementById('createSemaforoForm').style.display = 'block';
    document.getElementById('semaforoList').style.display = 'none';
}

function showSemaforoList() {
    document.getElementById('createSemaforoForm').style.display = 'none';
    document.getElementById('semaforoList').style.display = 'block';

    // Llamar a la función para cargar la lista de semáforos
    fetchSemaforoList();
}

async function fetchSemaforoList() {
    const response = await fetch('../Controller/getSemaforosAdmin.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    const semaforos = await response.json();

    const semaforoTableBody = document.getElementById('semaforoTableBody');
    semaforoTableBody.innerHTML = ''; // Limpiar la tabla antes de llenarla
    let contador = 1;
    semaforos.forEach(semaforo => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${contador}</td>
            <td>${semaforo.interseccion}</td>
            <td>${semaforo.direccion}</td>
            <td>${semaforo.tiempoVerde}</td>
            <td>${semaforo.tiempoAmarillo}</td>
            <td>${semaforo.tiempoRojo}</td>
        `;
        semaforoTableBody.appendChild(row);
        contador++;
    });
}
    </script>
</body>

</html>