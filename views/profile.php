<?php
session_start();

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user'])) {
    $_SESSION['login_error'] = "Session expirée ou non connecté";
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

require_once __DIR__ . '/../models/Profile.php';

$profileModel = new Profile();
$profileData = $profileModel->readByUserId($user['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroProfile | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --space-blue: #0b0e23;
            --neon-blue: #00f0ff;
            --deep-purple: #6a00f4;
            --star-yellow: #ffe700;
            --cosmic-pink: #ff00e4;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--space-blue);
            color: white;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(106, 0, 244, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 240, 255, 0.15) 0%, transparent 20%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="20" cy="30" r="0.5" fill="white" opacity="0.8"/><circle cx="50" cy="15" r="0.7" fill="white" opacity="0.8"/><circle cx="80" cy="40" r="0.3" fill="white" opacity="0.8"/><circle cx="10" cy="70" r="0.4" fill="white" opacity="0.8"/><circle cx="90" cy="90" r="0.6" fill="white" opacity="0.8"/></svg>');
        }
        
        h1, h2, h3, h4, .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
        }
        
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
        }
        
        .profile-card {
            background: rgba(15, 20, 50, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 240, 255, 0.1);
            transition: transform 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
        }
        
        .profile-header {
            background: linear-gradient(135deg, var(--deep-purple), var(--space-blue));
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 240, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .avatar-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid var(--neon-blue);
            overflow: hidden;
            position: relative;
            z-index: 2;
            background-color: var(--space-blue);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.5);
        }
        
        .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .default-avatar {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--deep-purple), var(--space-blue));
            color: white;
            font-size: 3rem;
        }
        
        .profile-badge {
            background: rgba(0, 240, 255, 0.1);
            border: 1px solid var(--neon-blue);
            color: var(--neon-blue);
            border-radius: 20px;
            padding: 0.3rem 1rem;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .profile-badge.admin {
            background: rgba(255, 0, 228, 0.1);
            border-color: var(--cosmic-pink);
            color: var(--cosmic-pink);
        }
        
        .profile-section {
            padding: 2rem;
            border-bottom: 1px solid rgba(0, 240, 255, 0.1);
        }
        
        .profile-section:last-child {
            border-bottom: none;
        }
        
        .section-title {
            color: var(--neon-blue);
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, var(--neon-blue), transparent);
        }
        
        .info-item {
            margin-bottom: 1rem;
        }
        
        .info-label {
            color: var(--neon-blue);
            font-weight: 500;
            margin-bottom: 0.3rem;
        }
        
        .info-value {
            font-size: 1.1rem;
        }
        
        .btn-astronaut {
            background: linear-gradient(135deg, var(--neon-blue), var(--deep-purple));
            border: none;
            color: white;
            font-weight: 500;
            letter-spacing: 1px;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0, 240, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-astronaut:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 240, 255, 0.4);
            color: white;
        }
        
        .btn-astronaut::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }
        
        .btn-astronaut:hover::before {
            left: 100%;
        }
        
        .navbar {
            background: rgba(11, 14, 35, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 240, 255, 0.1);
        }
        
        .navbar-brand {
            color: var(--neon-blue) !important;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .nav-link {
            color: white !important;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--neon-blue) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--neon-blue);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--neon-blue);
            box-shadow: 0 0 10px var(--neon-blue);
            display: inline-block;
            margin-right: 0.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-rocket me-2"></i>AstroProfile
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">
                            <span class="status-dot"></span>
                            <?= htmlspecialchars($user['email']) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header text-center">
                <div class="d-flex justify-content-center mb-3">
                    <div class="avatar-container">
                        <?php if (!empty($profileData['avatar'])): ?>
                            <img src="uploads/<?= htmlspecialchars($profileData['avatar']) ?>" alt="Avatar">
                        <?php else: ?>
                            <div class="default-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <h2 class="mb-1"><?= htmlspecialchars($user['name'] ?? 'Astronaute') ?></h2>
                <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                    <span class="profile-badge <?= $user['role'] === 'admin' ? 'admin' : '' ?>">
                        <i class="bi bi-<?= $user['role'] === 'admin' ? 'star-fill' : 'person-fill' ?> me-1"></i>
                        <?= htmlspecialchars($user['role']) ?>
                    </span>
                    <span class="text-muted">|</span>
                    <span class="text-muted">ID: <?= htmlspecialchars($user['id']) ?></span>
                </div>
            </div>
            
            <div class="profile-section">
                <h4 class="section-title"><i class="bi bi-person-lines-fill me-2"></i>Informations personnelles</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="glass-card mb-3">
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-envelope-fill me-2"></i>Email</div>
                                <div class="info-value"><?= htmlspecialchars($user['email']) ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="glass-card mb-3">
                            <div class="info-item">
                                <div class="info-label"><i class="bi bi-calendar-event me-2"></i>Date de naissance</div>
                                <div class="info-value"><?= htmlspecialchars($profileData['date_naissance'] ?? 'Non spécifiée') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($profileData && !empty($profileData['bio'])): ?>
                <div class="glass-card mt-3">
                    <div class="info-item">
                        <div class="info-label"><i class="bi bi-file-earmark-person-fill me-2"></i>Bio</div>
                        <div class="info-value"><?= htmlspecialchars($profileData['bio']) ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="profile-section">
                <h4 class="section-title"><i class="bi bi-rocket-takeoff-fill me-2"></i>Statistiques</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="glass-card text-center py-3">
                            <div class="info-label"><i class="bi bi-clock-history me-2"></i>Dernière connexion</div>
                            <div class="info-value">Il y a 2 jours</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card text-center py-3">
                            <div class="info-label"><i class="bi bi-activity me-2"></i>Activité</div>
                            <div class="info-value">Élevée</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card text-center py-3">
                            <div class="info-label"><i class="bi bi-award-fill me-2"></i>Niveau</div>
                            <div class="info-value">Astronaute <?= rand(1, 10) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="profile-section text-center">
    <div class="d-flex justify-content-center gap-3">
       
            <!-- Affiche ces boutons si le profil existe -->
            <a href="edit_profile.php" class="btn btn-astronaut">
                <i class="bi bi-pencil-square me-2"></i>Modifier le profil
            </a>
            <form action="delete_profile.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre profil ? Cette action est irréversible.')">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash-fill me-2"></i>Supprimer
                </button>
            </form>
       
            <!-- Affiche ce bouton si aucun profil n'existe -->
            <a href="create_profile.php" class="btn btn-astronaut">
                <i class="bi bi-plus-circle-fill me-2"></i>Créer un profil
            </a>
            
    </div>
</div>
        </div>
    </div>
    <div class="profile-section">
    

    <div id="universeContainer" class="mt-5">
        <!-- Ici sera injectée la scène Three.js -->
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/three@0.153.0/build/three.min.js"></script>
<script src="/assets/js/universe_explorer.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add animated elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add floating animation to profile card
            const card = document.querySelector('.profile-card');
            if (card) {
                card.style.transform = 'translateY(0)';
            }
            
            // Add twinkling stars effect
            const stars = document.createElement('div');
            stars.style.position = 'fixed';
            stars.style.top = '0';
            stars.style.left = '0';
            stars.style.width = '100%';
            stars.style.height = '100%';
            stars.style.pointerEvents = 'none';
            stars.style.zIndex = '-1';
            document.body.appendChild(stars);
            
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.style.position = 'absolute';
                star.style.width = Math.random() * 3 + 'px';
                star.style.height = star.style.width;
                star.style.backgroundColor = 'white';
                star.style.borderRadius = '50%';
                star.style.top = Math.random() * 100 + '%';
                star.style.left = Math.random() * 100 + '%';
                star.style.opacity = Math.random();
                star.style.animation = `twinkle ${Math.random() * 5 + 3}s infinite alternate`;
                stars.appendChild(star);
            }
            
            // Add CSS for twinkling animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes twinkle {
                    0% { opacity: 0.2; }
                    100% { opacity: 1; }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>