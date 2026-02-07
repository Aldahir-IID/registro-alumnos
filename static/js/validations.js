// static/js/validations.js

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("registroForm");

    form.addEventListener("submit", function(event) {
        let valid = true;
        
        // Obtener campos importantes
        const telefono = document.querySelector('input[name="telefono_personal"]').value;
        const password = document.getElementById("password").value;

        // Validación simple de longitud de contraseña
        if (password.length < 6) {
            alert("La contraseña debe tener al menos 6 caracteres.");
            valid = false;
        }

        // Validación simple de que el teléfono sean números
        // Regex: solo permite dígitos
        const phoneRegex = /^[0-9]+$/;
        if (!phoneRegex.test(telefono)) {
            alert("El teléfono solo debe contener números.");
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Detiene el envío si hay error
        }
    });
});