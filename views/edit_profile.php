<?php
session_start();
require_once __DIR__ . '/../models/Profile.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$profile = new Profile();
$currentProfile = $profile->getByUserId($user['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'] ?? $currentProfile['bio'];
    $date_naissance = !empty($_POST['date_naissance']) ? $_POST['date_naissance'] : $currentProfile['date_naissance'];
    $avatar = $currentProfile['avatar'];

    if (!empty($_FILES['avatar']['name'])) {
        $target_dir = "uploads/";
        $avatar = basename($_FILES["avatar"]["name"]);
        move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_dir . $avatar);
    }

    $profile->edit($user['id'], $bio, $avatar, $date_naissance);
    header("Location: profile.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚡ COSMIC PROFILE EDITOR | Next-Gen UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@900&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-space: #0A0B20;
            --neon-blue: #00F9FF;
            --plasma-purple: #9D00FF;
            --cyber-pink: #FF00F5;
            --hud-green: #00FFA3;
            --star-yellow: #FFEE00;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--deep-space);
            color: white;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(157, 0, 255, 0.2) 0%, transparent 25%),
                radial-gradient(circle at 80% 70%, rgba(0, 249, 255, 0.2) 0%, transparent 25%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="20" cy="30" r="0.8" fill="white" opacity="0.8"/><circle cx="50" cy="15" r="1" fill="white" opacity="0.8"/><circle cx="80" cy="40" r="0.5" fill="white" opacity="0.8"/><circle cx="10" cy="70" r="0.7" fill="white" opacity="0.8"/><circle cx="90" cy="90" r="0.9" fill="white" opacity="0.8"/></svg>');
        }

        h1, h2, h3, .cyber-title {
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* INTERFACE CONTAINER */
        .cosmic-interface {
            max-width: 900px;
            margin: 3rem auto;
            position: relative;
            z-index: 10;
            perspective: 1000px;
        }

        /* HOLOGRAPHIC CARD */
        .holo-panel {
            background: rgba(15, 17, 40, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(0, 249, 255, 0.3);
            box-shadow: 
                0 0 40px rgba(0, 249, 255, 0.2),
                0 0 80px rgba(157, 0, 255, 0.15);
            padding: 3rem;
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }

        .holo-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right, 
                transparent, 
                transparent, 
                rgba(0, 249, 255, 0.1), 
                transparent
            );
            transform: rotate(45deg);
            animation: holo-glow 8s linear infinite;
        }

        @keyframes holo-glow {
            0% { transform: rotate(45deg) translate(-30%, -30%); }
            100% { transform: rotate(45deg) translate(30%, 30%); }
        }

        /* SECTIONS */
        .cyber-section {
            border-left: 3px solid var(--neon-blue);
            padding-left: 1.5rem;
            margin-bottom: 3rem;
            position: relative;
        }

        .cyber-section::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, var(--neon-blue), transparent);
        }

        .section-title {
            color: var(--neon-blue);
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 1.8rem;
            color: var(--cyber-pink);
        }

        /* AVATAR ORB */
        .avatar-orb {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--deep-space) 30%, var(--plasma-purple));
            border: 3px solid var(--neon-blue);
            box-shadow: 
                0 0 30px rgba(0, 249, 255, 0.6),
                inset 0 0 40px rgba(157, 0, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            overflow: hidden;
            position: relative;
            transition: all 0.5s ease;
        }

        .avatar-orb:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 
                0 0 40px rgba(0, 249, 255, 0.8),
                inset 0 0 50px rgba(157, 0, 255, 0.6);
        }

        .avatar-orb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-orb .default-avatar {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* FILE UPLOAD */
        .upload-zone {
            border: 2px dashed rgba(0, 249, 255, 0.5);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(0, 249, 255, 0.05);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .upload-zone:hover {
            border-color: var(--neon-blue);
            background: rgba(0, 249, 255, 0.1);
            box-shadow: 0 0 25px rgba(0, 249, 255, 0.3);
        }

        .upload-zone i {
            font-size: 3rem;
            color: var(--neon-blue);
            margin-bottom: 1rem;
            display: block;
        }

        .upload-zone span {
            display: block;
            font-size: 1.2rem;
            color: var(--neon-blue);
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .upload-zone small {
            color: rgba(255, 255, 255, 0.6);
        }

        /* FORM ELEMENTS */
        .cyber-input {
            background: rgba(0, 0, 0, 0.4) !important;
            border: 2px solid rgba(0, 249, 255, 0.3) !important;
            color: white !important;
            padding: 1rem !important;
            border-radius: 10px !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .cyber-input:focus {
            border-color: var(--neon-blue) !important;
            box-shadow: 0 0 20px rgba(0, 249, 255, 0.4) !important;
            background: rgba(0, 0, 0, 0.6) !important;
        }

        textarea.cyber-input {
            min-height: 150px;
        }

        /* BUTTONS */
        .plasma-btn {
            background: linear-gradient(135deg, var(--plasma-purple), var(--cyber-pink));
            border: none;
            color: white;
            font-weight: 700;
            letter-spacing: 2px;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 5px 20px rgba(157, 0, 255, 0.5),
                0 0 15px rgba(255, 0, 245, 0.4);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .plasma-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
            z-index: -1;
        }

        .plasma-btn:hover {
            transform: translateY(-3px);
            box-shadow: 
                0 8px 30px rgba(157, 0, 255, 0.7),
                0 0 20px rgba(255, 0, 245, 0.6);
            color: white;
        }

        .plasma-btn:hover::before {
            left: 100%;
        }

        .hologram-btn {
            background: transparent;
            border: 2px solid var(--neon-blue);
            color: var(--neon-blue);
            font-weight: 700;
            letter-spacing: 2px;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .hologram-btn:hover {
            background: rgba(0, 249, 255, 0.1);
            color: var(--neon-blue);
            box-shadow: 0 0 20px rgba(0, 249, 255, 0.4);
        }

        /* FLOATING ANIMATION */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* SPACE BACKGROUND ELEMENTS */
        .space-particle {
            position: fixed;
            background: white;
            border-radius: 50%;
            opacity: 0;
            z-index: 1;
        }

        .satellite {
            position: absolute;
            right: -100px;
            top: 100px;
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            z-index: 0;
        }
    </style>
</head>
<body>
    <!-- SPACE BACKGROUND ELEMENTS -->
    <div class="satellite">
        <i class="bi bi-satellite"></i>
    </div>
    
    <div class="cosmic-interface floating">
        <div class="holo-panel">
            <h2 class="text-center mb-5 cyber-title">
                <i class="bi bi-stars me-3"></i> COSMIC PROFILE EDITOR
                <i class="bi bi-stars ms-3"></i>
            </h2>
            
            <form method="POST" enctype="multipart/form-data">
                <!-- AVATAR SECTION -->
                <div class="cyber-section">
                    <div class="section-title">
                        <i class="bi bi-person-astronaut"></i>
                        <span>ASTRO IDENTITY</span>
                    </div>
                    
                    <div class="text-center">
                        <div class="avatar-orb">
                            <?php if (!empty($currentProfile['avatar'])): ?>
                                <img src="uploads/<?= htmlspecialchars($currentProfile['avatar']) ?>" alt="Astronaut Avatar">
                            <?php else: ?>
                                <div class="default-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <label class="upload-zone">
                            <input type="file" name="avatar" class="d-none">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span>UPLOAD NEW IMAGE</span>
                            <small>(Leave empty to keep current)</small>
                        </label>
                    </div>
                </div>
                
                <!-- BIO SECTION -->
                <div class="cyber-section">
                    <div class="section-title">
                        <i class="bi bi-journal-text"></i>
                        <span>STELLAR BIOGRAPHY</span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="bio" class="form-label">MISSION LOG</label>
                        <textarea name="bio" class="form-control cyber-input" required>
<?= isset($currentProfile['bio']) ? htmlspecialchars($currentProfile['bio']) : '' ?>
</textarea>


                    </div>
                </div>
                
                <!-- PERSONAL DATA -->
                <div class="cyber-section">
                    <div class="section-title">
                        <i class="bi bi-clipboard2-data"></i>
                        <span>ASTRONAUT DATA</span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="date_naissance" class="form-label">LAUNCH DATE</label>
                        <input type="date" name="date_naissance" class="form-control cyber-input" required value="<?= $currentProfile['date_naissance'] ?>">
                    </div>
                </div>
                
                <!-- ACTION BUTTONS -->
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="profile.php" class="hologram-btn">
                        <i class="bi bi-arrow-left me-2"></i> ABORT MISSION
                    </a>
                    <button type="submit" class="plasma-btn">
                        <i class="bi bi-save2-fill me-2"></i> SAVE TO DATABASE
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Create space particles
        function createParticles() {
            const container = document.body;
            const particleCount = 100;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'space-particle';
                
                // Random properties
                const size = Math.random() * 3 + 1;
                const posX = Math.random() * window.innerWidth;
                const posY = Math.random() * window.innerHeight;
                const opacity = Math.random() * 0.8 + 0.1;
                const delay = Math.random() * 5;
                const duration = Math.random() * 10 + 5;
                
                // Apply styles
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${posX}px`;
                particle.style.top = `${posY}px`;
                particle.style.opacity = opacity;
                particle.style.animation = `twinkle ${duration}s ${delay}s infinite`;
                
                container.appendChild(particle);
            }
        }
        
        // Twinkle animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes twinkle {
                0% { opacity: 0.1; transform: scale(0.8); }
                50% { opacity: 1; transform: scale(1.2); }
                100% { opacity: 0.1; transform: scale(0.8); }
            }
        `;
        document.head.appendChild(style);
        
        // File upload preview
        document.querySelector('input[name="avatar"]').addEventListener('change', function(e) {
            if (e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const avatarOrb = document.querySelector('.avatar-orb');
                    avatarOrb.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                    
                    // Add pulse effect
                    avatarOrb.style.animation = 'pulse 0.5s ease';
                    setTimeout(() => {
                        avatarOrb.style.animation = '';
                    }, 500);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Add floating animation to card
            const card = document.querySelector('.holo-panel');
            card.style.transform = 'translateY(0) rotateX(0)';
        });
    </script>
</body>
</html>