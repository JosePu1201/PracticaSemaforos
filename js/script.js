document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const togglePasswordButton = document.querySelector('.toggle-password');

    // Toggle password visibility
    togglePasswordButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle eye icon
        const icon = this.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });

    // Form validation
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        let isValid = true;

        // Reset previous errors
        usernameInput.classList.remove('is-invalid');
        passwordInput.classList.remove('is-invalid');
        usernameError.style.display = 'none';
        passwordError.style.display = 'none';

        // Username validation
        if (!usernameInput.value) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = 'Por favor, ingresa tu nombre de usuario.';
            usernameError.style.display = 'block';
            isValid = false;
        } else if (usernameInput.value.length < 3) {
            usernameInput.classList.add('is-invalid');
            usernameError.textContent = 'El nombre de usuario debe tener al menos 3 caracteres.';
            usernameError.style.display = 'block';
            isValid = false;
        }

        // Password validation
        if (!passwordInput.value) {
            passwordInput.classList.add('is-invalid');
            passwordError.textContent = 'Por favor, ingresa tu contraseña.';
            passwordError.style.display = 'block';
            isValid = false;
        } else if (passwordInput.value.length < 6) {
            passwordInput.classList.add('is-invalid');
            passwordError.textContent = 'La contraseña debe tener al menos 6 caracteres.';
            passwordError.style.display = 'block';
            isValid = false;
        }

        if (isValid) {
          
        } else {
            // Apply shake animation to login container
            const loginContainer = document.querySelector('.login-container');
            loginContainer.classList.add('shake');
            
            // Remove animation class after animation completes
            setTimeout(() => {
                loginContainer.classList.remove('shake');
            }, 500);
        }
    });

    // Simulate login process


    // Demo: Handle forgot password link
    document.querySelector('.forgot-password').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Funcionalidad de recuperación de contraseña');
    });

    // Demo: Handle register link
    document.querySelector('.register-link a').addEventListener('click', function(e) {
        e.preventDefault();
        alert('Redirigiendo a la página de registro...');
    });
});