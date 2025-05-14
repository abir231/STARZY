<?php
// Démarrer la session pour le captcha
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starzy - Tutoriels & Livres</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Space+Mono&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        form {
    max-width: 500px;
    margin: 2rem auto;
    background: rgba(255, 255, 255, 0.1);
    padding: 1.5rem;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
}

.form-group {
    margin-bottom: 1rem;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #e0e0e0;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: #ecf0f4;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s ease;
}

input:focus, select:focus, textarea:focus {
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
}
input, select, textarea {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    color: #ecf0f4;
    font-size: 1rem;
    outline: none;
    transition: all 0.3s ease;
}

/* Spécifique au <select> */
select {
    background: rgba(255, 255, 255, 0.8); /* Fond plus clair pour le select */
    color: black; /* Texte noir si le fond est blanc */
}

/* Pour éviter que les options aient du texte blanc sur fond blanc */
select option {
    color: black;
    background: white;
}

.btn-reserve {
    display: block;
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, rgba(0, 191, 255, 0.7), rgba(138, 43, 226, 0.7));
    border: none;
    border-radius: 8px;
    color: white;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    margin-top: 1rem;
}

.btn-reserve:hover {
    background: linear-gradient(45deg, rgba(0, 191, 255, 1), rgba(138, 43, 226, 1));
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
}


        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #e0e0e0;
        }

        input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
        }

        .btn-reserve {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.7), rgba(138, 43, 226, 0.7));
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            margin-top: 1rem;
        }

        .btn-reserve:hover {
            background: linear-gradient(45deg, rgba(0, 191, 255, 1), rgba(138, 43, 226, 1));
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
        }

        body {
            font-family: 'Space Mono', monospace;
            background: #0a0818 url('https://images.unsplash.com/photo-1465101162946-4377e57745c3') center/cover;
            color: #e0e0e0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            right: -180px;
            top: 50%;
            transform: translateY(-50%);
            width: 240px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 15px 0 0 15px;
            box-shadow: -5px 0 30px rgba(0, 191, 255, 0.3);
            transition: right 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            
        }

        .sidebar:hover {
            right: 0;
        }

        .nav-links li {
            margin: 2rem 0;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.2rem;
            padding: 15px 25px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.4s ease;
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.1) 0%, rgba(138, 43, 226, 0.1) 100%);
        }

        .nav-links a:hover {
            transform: translateX(-20px) scale(1.1);
            box-shadow: 0 0 25px rgba(0, 191, 255, 0.4);
        }

        .content {
            display: none;
            padding: 20px;
            text-align: center;
        }

        .content.active {
            display: block;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            margin: 2rem 0;
            font-size: 2.5rem;
            text-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
        }

        p {
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        /* Container for books */
        .livre-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .livre-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0, 191, 255, 0.3);
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            overflow: hidden;
        }

        .livre-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
        }

        .livre-card a {
            color: #00BFFF;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: rgba(0, 191, 255, 0.2);
        }

        .livre-card a:hover {
            color: #FFFFFF;
            background: rgba(0, 191, 255, 0.4);
        }
        .error-message {
    font-size: 0.875em;
    margin-top: 5px;
    display: block;
}

input:focus, select:focus, textarea:focus {
    border-color: #007bff;
}

        /* Captcha styling */
        .captcha-container {
            margin-bottom: 15px;
        }
        
        .captcha-image {
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .refresh-captcha {
            display: inline-block;
            padding: 5px 10px;
            background: rgba(0, 191, 255, 0.2);
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            margin-left: 10px;
            transition: all 0.3s ease;
        }
        
        .refresh-captcha:hover {
            background: rgba(0, 191, 255, 0.4);
        }

        @media (max-width: 768px) {
            .livre-container {
                grid-template-columns: 1fr;
            }
        }

        .btn-back {
            display: inline-block;
            padding: 10px 30px;
            background: linear-gradient(45deg, rgba(0, 191, 255, 0.7), rgba(138, 43, 226, 0.7));
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 20px;
            text-transform: uppercase;
        }

        .btn-back:hover {
            background: linear-gradient(45deg, rgba(0, 191, 255, 1), rgba(138, 43, 226, 1));
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.5);
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
  <a href="../designe.php" class="btn-back">
    <i class="fa fa-arrow-left"></i> Retour
  </a>

    <nav class="sidebar">
        <ul class="nav-links">
            <li><a href="#" onclick="showSection('accueil')">🚀 Accueil</a></li>
            <li><a href="#" onclick="showSection('tutoriels')">📚 Tutoriels</a></li>
            <li><a href="#" onclick="showSection('livres')">📖 Livres</a></li>
        </ul>
    </nav>

    <div id="accueil" class="content active">
        <h2>Bienvenue sur Starzy</h2>
        <p>Découvrez l'univers fascinant de l'astronomie et des sciences.</p>
        <form action="../ajout.php" method="POST">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre">
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="type_ressource">Type de Ressource</label>
        <select id="type_ressource" name="type_ressource">
            <option value="pdf">PDF</option>
            <option value="article">Article</option>
            <option value="video">Vidéo</option>
            <option value="autre">Autre</option>
        </select>
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="categorie">Catégorie</label>
        <select id="categorie" name="categorie">
            <option value="astronomie_generale">Astronomie Générale</option>
            <option value="planetes">Planètes</option>
            <option value="etoiles">Étoiles</option>
            <option value="galaxies">Galaxies</option>
            <option value="cosmologie">Cosmologie</option>
        </select>
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="date_publication">Date de Publication</label>
        <input type="date" id="date_publication" name="date_publication">
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3"></textarea>
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="fichier_ou_lien">Fichier à insérer</label>
        <input type="file" id="fichier_ou_lien" name="fichier_ou_lien">
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="form-group">
        <label for="statut">Statut</label>
        <select id="statut" name="statut">
            <option value="publie">Publié</option>
            <option value="brouillon">Brouillon</option>
            <option value="archive">Archivé</option>
        </select>
        <!-- Message d'erreur ou succès -->
        <span class="error-message"></span>
    </div>

    <div class="captcha-container">
        <label for="captcha">Code de sécurité</label>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <img src="generate_captcha.php" alt="Captcha" class="captcha-image" id="captcha-image">
            <a href="#" onclick="refreshCaptcha(event)" class="refresh-captcha">Rafraîchir</a>
        </div>
        <input type="text" id="captcha" name="captcha" placeholder="Entrez le texte affiché ci-dessus">
        <span class="error-message captcha-error"></span>
    </div>

    <button type="submit" class="btn-reserve">Ajouter la Ressource</button>
</form>

    </div>
    
    <div id="livres" class="content">
        <h2>📖 Livres</h2>
         <p>Découvrez une sélection de livres sur l'astronomie et les sciences.</p>

        <div class="livre-container">
            <div class="livre-card">
                <img src="img1.jfif" alt="Livre 1">
                <a href="https://example.com/livre1.pdf" target="_blank">Livre 1</a>
            </div>
            <div class="livre-card">
                <img src="img2.jfif" alt="Livre 2">
                <a href="https://example.com/livre2.pdf" target="_blank">Livre 2</a>
            </div>
            <div class="livre-card">
                <img src="img3.jfif" alt="Livre 3">
                <a href="https://example.com/livre3.pdf" target="_blank">Livre 3</a>
            </div>
            <div class="livre-card">
                <img src="img4.jfif" alt="Livre 4">
                <a href="https://example.com/livre4.pdf" target="_blank">Livre 4</a>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            let sections = document.querySelectorAll('.content');
            sections.forEach(sec => sec.classList.remove('active'));
            document.getElementById(section).classList.add('active');
        }
        
        // Fonction pour rafraîchir le captcha
        function refreshCaptcha(event) {
            event.preventDefault();
            const captchaImg = document.getElementById('captcha-image');
            // Ajouter un paramètre aléatoire pour éviter la mise en cache
            captchaImg.src = 'generate_captcha.php?rand=' + Math.random();
        }

        // Gestionnaire d'erreur pour l'image du captcha
        document.addEventListener('DOMContentLoaded', function() {
            const captchaImg = document.getElementById('captcha-image');
            if (captchaImg) {
                captchaImg.onerror = function() {
                    // Si l'image ne peut pas être chargée, utiliser le captcha texte
                    const captchaContainer = document.querySelector('.captcha-container');
                    
                    // Créer un iframe pour le captcha texte
                    const iframe = document.createElement('iframe');
                    iframe.src = 'simple_captcha.php';
                    iframe.style.width = '100%';
                    iframe.style.height = '60px';
                    iframe.style.border = 'none';
                    iframe.style.overflow = 'hidden';
                    
                    // Remplacer l'image et le lien de rafraîchissement
                    const imgContainer = document.querySelector('.captcha-container > div');
                    imgContainer.innerHTML = '';
                    imgContainer.appendChild(iframe);
                    
                    // Ajouter un bouton pour rafraîchir le captcha texte
                    const refreshBtn = document.createElement('a');
                    refreshBtn.href = '#';
                    refreshBtn.className = 'refresh-captcha';
                    refreshBtn.textContent = 'Rafraîchir';
                    refreshBtn.onclick = function(e) {
                        e.preventDefault();
                        iframe.src = 'simple_captcha.php?rand=' + Math.random();
                    };
                    imgContainer.appendChild(refreshBtn);
                };
            }
        });
    </script>
    <script src="controle_saisie.js"></script>
    </body>
</html>