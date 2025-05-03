// Contrôle de la saisie du formulaire
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
        let isValid = true;

        // Effacer les messages d'erreur et de succès précédents
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach(message => message.remove());

        // Vérification du champ "Titre"
        const titre = document.getElementById("titre");
        const titreMessage = validateField(titre, "Le champ Titre est obligatoire.");
        if (!titreMessage) isValid = false;
        
        // Vérification du champ "Type de Ressource"
        const typeRessource = document.getElementById("type_ressource");
        const typeRessourceMessage = validateField(typeRessource, "Le champ Type de Ressource est obligatoire.");
        if (!typeRessourceMessage) isValid = false;

        // Vérification du champ "Catégorie"
        const categorie = document.getElementById("categorie");
        const categorieMessage = validateField(categorie, "Le champ Catégorie est obligatoire.");
        if (!categorieMessage) isValid = false;

        // Vérification du champ "Date de Publication"
        const datePublication = document.getElementById("date_publication");
        const datePublicationMessage = validateField(datePublication, "Le champ Date de Publication est obligatoire.");
        if (!datePublicationMessage) isValid = false;

        // Vérification du champ "Description"
        const description = document.getElementById("description");
        const descriptionMessage = validateField(description, "Le champ Description est obligatoire.");
        if (!descriptionMessage) isValid = false;

        // Vérification du champ "Fichier ou Lien"
        const fichierOuLien = document.getElementById("fichier_ou_lien");
        if (fichierOuLien.files.length === 0) {
            displayError(fichierOuLien, "Veuillez sélectionner un fichier à insérer.");
            isValid = false;
        } else {
            displaySuccess(fichierOuLien);
        }

        // Vérification du champ "Statut"
        const statut = document.getElementById("statut");
        const statutMessage = validateField(statut, "Le champ Statut est obligatoire.");
        if (!statutMessage) isValid = false;

        // Si un champ est invalide, empêcher l'envoi du formulaire
        if (!isValid) {
            event.preventDefault(); // Empêcher la soumission du formulaire
        }
    });

    // Fonction de validation générique
    function validateField(field, message) {
        if (!field.value.trim()) {
            displayError(field, message);
            return false;
        } else {
            displaySuccess(field);
            return true;
        }
    }

    // Fonction pour afficher le message d'erreur
    function displayError(field, message) {
        let errorMessage = field.parentNode.querySelector(".error-message");
        if (!errorMessage) {
            errorMessage = document.createElement("span");
            errorMessage.classList.add("error-message");
            errorMessage.style.color = "red";
            errorMessage.style.fontSize = "0.875em";
            field.parentNode.appendChild(errorMessage);
        }
        errorMessage.textContent = message;
        field.style.borderColor = "red";
    }

    // Fonction pour afficher le message de succès
    function displaySuccess(field) {
        let successMessage = field.parentNode.querySelector(".error-message");
        if (!successMessage) {
            successMessage = document.createElement("span");
            successMessage.classList.add("error-message");
            successMessage.style.color = "green";
            successMessage.style.fontSize = "0.875em";
            field.parentNode.appendChild(successMessage);
        }
        successMessage.textContent = "Valide!";
        field.style.borderColor = "green";
    }
});
