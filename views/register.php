<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  
  <!-- MDB CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
  <!-- Font Awesome (for icons) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <!-- Bootstrap Core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .vh-100 {
      height: 100vh !important;
    }
    .error-message {
      color: red;
      font-size: 0.8rem;
      margin-top: 5px;
      display: none;
    }
    .valid-feedback {
      color: green;
      font-size: 0.8rem;
      margin-top: 5px;
      display: none;
    }
    .is-invalid {
      border-color: #dc3545 !important;
    }
    .is-valid {
      border-color: #28a745 !important;
    }
  </style>

<?php
session_start();

// Traitement de l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    require_once "../controllers/UserController.php";
    $controller = new UserController();
    
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'role' => 'user' // Par défaut tous les nouveaux sont 'user'
    ];
    
    if ($controller->register($data)) {
      // Message de succès sans connexion automatique
      $_SESSION['registration_success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
      header("Location: login.php"); // Redirige toujours vers la page de login
      exit;
  } else {
      $_SESSION['registration_error'] = "Erreur lors de l'inscription";
  }
}
?>

<!-- Le reste de votre HTML existant -->
</head>
<body>

  <section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <!-- Left Column (Form Section) -->
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                  <form class="mx-1 mx-md-4" action="" method="POST" id="registrationForm">
                    <input type="hidden" name="register" value="1">
                  
                    <!-- Name Field -->
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div data-mdb-input-init class="form-outline flex-fill mb-0">
                        <input type="text" name="name" id="form3Example1c" class="form-control" required />
                        <label class="form-label" for="form3Example1c">Your Name</label>
                      </div>
                    </div>
                  
                    <!-- Email Field -->
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div data-mdb-input-init class="form-outline flex-fill mb-0">
                        <input type="email" name="email" id="emailInput" class="form-control" required />
                        <label class="form-label" for="emailInput">Your Email</label>
                        <div id="emailError" class="error-message">Email must be in format: example@gmail.com</div>
                        <div id="emailValid" class="valid-feedback">Email is valid!</div>
                      </div>
                    </div>
                  
                    <!-- Password Field -->
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div data-mdb-input-init class="form-outline flex-fill mb-0">
                        <input type="password" name="password" id="passwordInput" class="form-control" required />
                        <label class="form-label" for="passwordInput">Password</label>
                        <div id="passwordError" class="error-message">
                          Password must contain: 
                          <ul>
                            <li id="lengthCheck">At least 8 characters</li>
                            <li id="uppercaseCheck">At least one uppercase letter</li>
                            <li id="specialCharCheck">At least one special character (@, #, $, etc.)</li>
                          </ul>
                        </div>
                        <div id="passwordValid" class="valid-feedback">Password is valid!</div>
                      </div>
                    </div>
                  
                    <!-- Repeat Password -->
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                      <div data-mdb-input-init class="form-outline flex-fill mb-0">
                        <input type="password" id="confirmPassword" class="form-control" />
                        <label class="form-label" for="confirmPassword">Repeat your password</label>
                        <div id="confirmError" class="error-message">Passwords do not match!</div>
                      </div>
                    </div>
                  
                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-5">
                      <input class="form-check-input me-2" type="checkbox" value="" id="termsCheck" required />
                      <label class="form-check-label" for="termsCheck">
                        I agree all statements in <a href="#!">Terms of service</a>
                      </label>
                    </div>
                  
                    <!-- Register Button -->
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">Register</button>
                    </div>
                  </form>
                  
                </div>

                <!-- Right Column (Image Section) -->
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                  <img src="../images/sign.jpg" class="img-fluid" alt="Sample image">
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MDB JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const emailInput = document.getElementById('emailInput');
      const passwordInput = document.getElementById('passwordInput');
      const confirmPassword = document.getElementById('confirmPassword');
      const submitBtn = document.getElementById('submitBtn');
      const form = document.getElementById('registrationForm');

      // Email validation
      emailInput.addEventListener('input', function() {
        const email = emailInput.value;
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        
        if (!emailRegex.test(email)) {
          document.getElementById('emailError').style.display = 'block';
          document.getElementById('emailValid').style.display = 'none';
          emailInput.classList.add('is-invalid');
          emailInput.classList.remove('is-valid');
        } else {
          document.getElementById('emailError').style.display = 'none';
          document.getElementById('emailValid').style.display = 'block';
          emailInput.classList.remove('is-invalid');
          emailInput.classList.add('is-valid');
        }
      });

      // Password validation
      passwordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasSpecialChar = /[@#$%^&+=!]/.test(password);
        const hasMinLength = password.length >= 8;

        // Update checklist
        document.getElementById('lengthCheck').style.color = hasMinLength ? 'green' : 'red';
        document.getElementById('uppercaseCheck').style.color = hasUpperCase ? 'green' : 'red';
        document.getElementById('specialCharCheck').style.color = hasSpecialChar ? 'green' : 'red';

        if (hasUpperCase && hasSpecialChar && hasMinLength) {
          document.getElementById('passwordError').style.display = 'none';
          document.getElementById('passwordValid').style.display = 'block';
          passwordInput.classList.remove('is-invalid');
          passwordInput.classList.add('is-valid');
        } else {
          document.getElementById('passwordError').style.display = 'block';
          document.getElementById('passwordValid').style.display = 'none';
          passwordInput.classList.add('is-invalid');
          passwordInput.classList.remove('is-valid');
        }

        // Check password match if confirm password has value
        if (confirmPassword.value) {
          validatePasswordMatch();
        }
      });

      // Confirm password validation
      confirmPassword.addEventListener('input', validatePasswordMatch);

      function validatePasswordMatch() {
        if (passwordInput.value !== confirmPassword.value) {
          document.getElementById('confirmError').style.display = 'block';
          confirmPassword.classList.add('is-invalid');
          confirmPassword.classList.remove('is-valid');
        } else {
          document.getElementById('confirmError').style.display = 'none';
          confirmPassword.classList.remove('is-invalid');
          confirmPassword.classList.add('is-valid');
        }
      }

      // Form submission validation
      form.addEventListener('submit', function(event) {
        if (!validateForm()) {
          event.preventDefault();
        }
      });

      function validateForm() {
        const emailValid = !emailInput.classList.contains('is-invalid');
        const passwordValid = !passwordInput.classList.contains('is-invalid');
        const passwordsMatch = passwordInput.value === confirmPassword.value;
        const termsChecked = document.getElementById('termsCheck').checked;

        if (!emailValid || !passwordValid || !passwordsMatch || !termsChecked) {
          if (!termsChecked) {
            alert('Please agree to the terms of service');
          }
          return false;
        }
        return true;
      }
    });
  </script>
</body>
</html>