// Contrôle de la saisie du formulaire
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    if (form) {
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Reset error messages
            const errorMessages = document.querySelectorAll(".error-message");
            errorMessages.forEach(el => {
                el.textContent = "";
            });
            
            let isValid = true;
            
            // Validate title
            const titre = document.getElementById("titre");
            if (!titre.value.trim()) {
                document.querySelector("[for='titre'] + input + .error-message").textContent = "Le titre est obligatoire";
                isValid = false;
            }
            
            // Validate description
            const description = document.getElementById("description");
            if (!description.value.trim()) {
                document.querySelector("[for='description'] + textarea + .error-message").textContent = "La description est obligatoire";
                isValid = false;
            }
            
            // Validate date
            const datePublication = document.getElementById("date_publication");
            if (!datePublication.value) {
                document.querySelector("[for='date_publication'] + input + .error-message").textContent = "La date de publication est obligatoire";
                isValid = false;
            }
            
            // Validate captcha
            const captcha = document.getElementById("captcha");
            if (!captcha.value.trim()) {
                document.querySelector(".captcha-error").textContent = "Veuillez entrer le code de sécurité";
                isValid = false;
            }
            
            // Submit form if valid
            if (isValid) {
                form.submit();
            }
        });
    }
});
