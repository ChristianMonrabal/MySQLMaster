// Obtener referencias a los elementos del formulario y a los mensajes de error
const form = document.querySelector('form');
const usernameInput = document.querySelector('input[name="username"]');
const passwordInput = document.querySelector('input[name="password"]');
const databaseInput = document.querySelector('input[name="database"]');
const usernameError = document.getElementById('username-error');
const passwordError = document.getElementById('password-error');

// Función para validar el formulario
function validateForm(event) {
    let isValid = true;

    // Validar nombre de usuario
    if (usernameInput.value.trim() === '' && databaseInput.value.trim() === '') {
        usernameError.textContent = 'Por favor, ingresa tu nombre de usuario o base de datos.';
        isValid = false;
    } else {
        usernameError.textContent = '';
    }

    // Validar contraseña
    if (passwordInput.value.trim() === '' && databaseInput.value.trim() === '') {
        passwordError.textContent = 'Por favor, ingresa tu contraseña o base de datos.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }

    if (!isValid) {
        event.preventDefault(); // Evitar el envío del formulario si no es válido
    }
}

// Agregar un evento de escucha para el envío del formulario
form.addEventListener('submit', validateForm);

// Función para mostrar mensajes de error específicos
function showError(inputElement, errorMessage) {
    const errorElement = document.getElementById(`${inputElement.name}-error`);
    errorElement.textContent = errorMessage;
}

// Función para restablecer los mensajes de error
function resetErrors() {
    usernameError.textContent = '';
    passwordError.textContent = '';
}
