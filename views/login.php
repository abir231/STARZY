<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
  <!-- MDB core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />

  <style>
    .gradient-form {
      height: 100vh;
      background-color: white; /* Fond blanc global */
    }

    .gradient-custom-2 {
      background: linear-gradient(to right, #0d1b2a, #1b3a59, #304e80, #5477a1); /* Dégradé cosmique à droite */
      border-top-right-radius: .3rem;
      border-bottom-right-radius: .3rem;
      position: relative; /* Enable positioning for child elements */
    }

    /* Adjust buttons and text colors */
    .btn-primary {
      background: #4c8bf5; /* Blue tone */
    }

    .btn-outline-danger {
      border-color: #7f2b83; /* Purple accent */
      color: #7f2b83;
    }

    .btn-outline-danger:hover {
      background-color: #7f2b83;
      color: white;
    }

    .form-label {
      color: #333; /* Black text for better contrast */
    }

    .text-white {
      color: #333 !important; /* Ensure text is legible on white background */
    }
    
    /* Message styles */
    .login-message {
      margin-top: 10px;
      font-size: 14px;
    }
    .text-danger {
      color: #dc3545 !important;
    }
    .text-success {
      color: #28a745 !important;
    }

    /* Animation astronaut floating */
    .astronaut-container {
      position: absolute;
      top: 50%; /* Center vertically */
      right: 20px; /* Place astronaut near the right edge */
      transform: translate(0, -50%);
      z-index: 10; /* Make sure the astronaut is above other elements */
      animation: float 3s ease-in-out infinite;
    }

    .astronaut-container img {
      width: 100%; /* Responsive, adjusts with container size */
      max-width: 500px; /* Optional: control max width */
    }

    @keyframes float {
      0% {
        transform: translate(0, -50%) translateY(0);
      }
      50% {
        transform: translate(0, -50%) translateY(-15px);
      }
      100% {
        transform: translate(0, -50%) translateY(0);
      }
    }
  </style>
</head>
<body>

<?php
// Empêcher l'accès si déjà connecté
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: users.php");
    exit;
}

// Gestion des messages de connexion
$loginMessage = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    require_once "../controllers/UserController.php";
    $controller = new UserController();
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $user = $controller->login(['email' => $email, 'password' => $password]);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: users.php");
        exit;
    } else {
        $loginMessage = 'Email ou mot de passe incorrect';
        $messageClass = 'text-danger';
    }
}
?>

<section class="h-100 gradient-form">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="../images/kawkab.png"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1 text-dark">We are The Lotus Team</h4>
                </div>

                <form action="" method="POST">  
                  <input type="hidden" name="login" value="1">
                
                  <!-- Email Field -->
                  <div class="form-outline mb-4">
                    <input type="email" name="email" id="form2Example11" class="form-control"
                      placeholder="Phone number or email address" required />
                    <label class="form-label" for="form2Example11">Username</label>
                  </div>
                
                  <!-- Password Field -->
                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example22" class="form-control" required />
                    <label class="form-label" for="form2Example22">Password</label>
                  </div>
                
                  <!-- Login Button -->
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log in</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                    <!-- Message de connexion -->
                    <?php if (!empty($loginMessage)): ?>
                      <div class="login-message <?php echo $messageClass; ?>">
                        <?php echo htmlspecialchars($loginMessage); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                
                  <!-- Sign up redirect -->
                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2 text-dark">Don't have an account?</p>
                    <button type="button" class="btn btn-outline-danger" onclick="window.location.href='register.php'">Create new</button>
                  </div>
                </form>
                
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="astronaut-container">
                <img src="../images/image.png" alt="Astronaut">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bootstrap core JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- MDB core JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>

</body>
</html>