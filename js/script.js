document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
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