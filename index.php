<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tránsito - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="traffic-background"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <div class="login-container">
                    <div class="login-header text-center">
                        <div class="traffic-light-container">
                            <div class="traffic-light">
                                <div class="light red"></div>
                                <div class="light yellow"></div>
                                <div class="light green"></div>
                            </div>
                        </div>
                        <h2>Sistema de Tránsito</h2>
                        <p>Ingrese sus credenciales para acceder</p>
                    </div>
                    
                    <div class="login-form">
                        <form id="loginForm" action="./Controller/login.php" method="post" role="form" class="FormCatElec" data-form="login">
                            <div class="form-group mb-3">
                                <label for="username">Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" placeholder="Ingresa tu nombre de usuario" required>
                                </div>
                                <div class="invalid-feedback" id="usernameError"></div>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" placeholder="Ingresa tu contraseña" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="passwordError"></div>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Recordarme
                                </label>
                                <a href="#" class="float-end forgot-password">¿Olvidaste tu contraseña?</a>
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary login-btn">Iniciar Sesión</button>
                            </div>
                        </form>
                        
                        <div class="login-divider">
                            <span>O inicia sesión con</span>
                        </div>
                        
                        <div class="social-login">
                            <button class="btn btn-outline-danger social-btn google-btn" disabled>
                                <i class="bi bi-google"></i> Google
                            </button>
                            <button class="btn btn-outline-primary social-btn facebook-btn" disabled>
                                <i class="bi bi-facebook"></i> Facebook
                            </button>
                        </div>
                        
                        <div class="register-link text-center mt-3">
                            <p>¿No tienes una cuenta? <a href="#">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>