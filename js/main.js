$(document).ready(function() {
    $('#login-form').submit(function(event) {
        var valid = true;

        // Limpiar mensajes de error
        $('.error-message').text('');

        // Verificar campos obligatorios
        $('#server, #username, #password').each(function() {
            if ($(this).val() === '') {
                var fieldName = $(this).attr('name');
                $('#' + fieldName + '-error').text('Este campo es obligatorio');
                valid = false;
            }
        });

        // Si hay campos obligatorios vacíos, detener el envío del formulario
        if (!valid) {
            event.preventDefault();
        }
    });
});
