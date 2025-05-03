<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}





?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Portail Stellaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --space-dark: #0f172a;
            --space-light: #1e293b;
            --neon-blue: #38bdf8;
            --neon-purple: #818cf8;
            --plasma: #e879f9;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: var(--space-dark);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: 
                url('anim/stars-bg.png'),
                radial-gradient(circle at 25% 25%, rgba(56, 189, 248, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(129, 140, 248, 0.1) 0%, transparent 50%);
            overflow: hidden;
        }

        .login-portal {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(56, 189, 248, 0.2);
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 16px rgba(56, 189, 248, 0.1);
            overflow: hidden;
            position: relative;
            z-index: 10;
            transform: translateY(0);
            transition: transform 0.5s ease;
        }

        .login-portal:hover {
            transform: translateY(-5px);
        }

        .portal-header {
            background: linear-gradient(90deg, var(--neon-blue), var(--neon-purple));
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .portal-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 20px;
            background: radial-gradient(ellipse at center, rgba(56, 189, 248, 0.4) 0%, transparent 70%);
        }

        .portal-title {
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .portal-body {
            padding: 2rem;
        }

        .form-label {
            color: var(--neon-blue);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            background-color: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--neon-blue);
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
            background-color: rgba(30, 41, 59, 0.7);
        }

        .login-btn {
            background: linear-gradient(135deg, var(--neon-blue), var(--neon-purple));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(56, 189, 248, 0.4);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .error-pulse {
            animation: pulse 0.5s ease;
        }

        @keyframes pulse {
            0% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        /* Animations spatiales */
        .space-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            pointer-events: none;
        }

        .floating-astronaut {
            position: absolute;
            width: 150px;
            right: -50px;
            top: 20%;
            animation: float-astronaut 25s linear infinite;
            opacity: 0.7;
        }

        .rotating-planet {
            position: absolute;
            width: 120px;
            left: -30px;
            bottom: 10%;
            animation: rotate-planet 40s linear infinite;
        }

        @keyframes float-astronaut {
            0% { transform: translateX(0) translateY(0) rotate(0deg); }
            50% { transform: translateX(-100px) translateY(-50px) rotate(10deg); }
            100% { transform: translateX(0) translateY(0) rotate(0deg); }
        }

        @keyframes rotate-planet {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .floating-astronaut {
                width: 100px;
                right: -30px;
            }
            .rotating-planet {
                width: 80px;
                left: -20px;
            }
        }
    </style>
</head>
<body>
    <!-- Animations spatiales -->
    <div class="space-animation">
        <img src="astronaut.png" class="floating-astronaut" alt="Astronaut floating">
        <img src="planet.png" class="rotating-planet" alt="Planet rotating">
    </div>

    <div class="container">
        <div class="login-portal">
            <div class="portal-header">
                <h1 class="portal-title">
                    <i class="bi bi-stars"></i>
                    <span>PORTAL ACCESS</span>
                    <i class="bi bi-stars"></i>
                </h1>
            </div>
            
            <div class="portal-body">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger error-pulse mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <form method="POST" action="auth.php">
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill"></i>
                            <span>IDENTIFIANT STELLAIRE</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="votre@galaxie.com">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock-fill"></i>
                            <span>MOT DE PASSE COSMIQUE</span>
                        </label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="bi bi-unlock-fill me-2"></i>
                        <span>ACTIVER L'ACCÈS</span>
                    </button>
                    <div class="text-center mt-3">
    <a href="forgot_password.php" class="text-decoration-none" style="color: var(--plasma);">
        <i class="bi bi-question-circle me-1"></i>
        Mot de passe oublié ?
    </a>
</div>
<div class="text-center mt-4">
    <p class="text-muted mb-2">Nouveau dans l'espace ?</p>
    <a href="register.php" class="btn btn-outline-primary portal-btn">
        <i class="bi bi-rocket me-2"></i>
        Inscription stellaire
    </a>
</div>

<style>
    .portal-btn {
        border: 1px solid var(--neon-purple);
        color: var(--neon-purple);
        position: relative;
        overflow: hidden;
        transition: all 0.5s ease;
    }
    
    .portal-btn:hover {
        background: rgba(129, 140, 248, 0.1);
        color: var(--neon-blue);
        border-color: var(--neon-blue);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(56, 189, 248, 0.2);
    }
    
    .portal-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.1), transparent);
        transition: 0.5s;
    }
    
    .portal-btn:hover::before {
        left: 100%;
    }
</style>

                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation pour les étoiles de fond
        document.addEventListener('DOMContentLoaded', function() {
            // Ajoute un effet de scintillement aléatoire aux étoiles
            if (document.body.style.backgroundImage.includes('stars-bg.png')) {
                setInterval(() => {
                    const intensity = Math.floor(Math.random() * 3) + 1;
                    document.body.style.backgroundImage = 
                        `url('anim/stars-bg${intensity}.png'),
                        radial-gradient(circle at 25% 25%, rgba(56, 189, 248, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 75% 75%, rgba(129, 140, 248, 0.1) 0%, transparent 50%)`;
                }, 1000);
            }

            // Animation au chargement
            const portal = document.querySelector('.login-portal');
            setTimeout(() => {
                portal.style.transform = 'translateY(0)';
            }, 100);
        });

        // Effet de focus amélioré
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.form-label').style.color = 'var(--plasma)';
                this.style.boxShadow = '0 0 15px rgba(232, 121, 249, 0.3)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.form-label').style.color = 'var(--neon-blue)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>