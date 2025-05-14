<?php
// Empêcher l'accès si déjà connecté
session_start();
if (isset($_SESSION['user'])) {
    header("Location: /integration/view/designe.php");


    exit;
}



// 1. Gérer l'enregistrement sans session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    require_once __DIR__ . "/controller/UserController.php";
    $controller = new UserController();
    
    // Enregistrer l'utilisateur
    if ($controller->register($_POST)) {
        // Rediriger seulement si l'enregistrement réussit
        header("Location: views/users.php");
        exit;
    }
    // Si échec, continuer vers le formulaire
}

// 2. Vérifier la connexion SAUF pour la page de login/register
$allowed_pages = ['login.php', 'register.php', 'index.php']; // ← Ajoute index.php

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['user_id']) && 
    !(in_array($current_page, $allowed_pages) || 
    (isset($_GET['action']) && $_GET['action'] === 'delete'))) {
    header("Location: views/login.php");
    exit;
}


// 3. Si connecté ou page autorisée, continuer
require_once __DIR__ . "/controller/UserController.php";

$controller = new UserController();

// 4. Gérer la suppression
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $controller->deleteUser($_GET['id']);
    header("Location: views/users.php");
    exit;
}

// 5. Récupérer les utilisateurs seulement si nécessaire
if ($current_page === 'users.php') {
    $users = $controller->getAllUsers();
}

// Inclure la vue appropriée
if ($current_page === 'users.php') {
    include 'views/users.php';
} elseif ($current_page === 'login.php') {
    include 'views/login.php';
} elseif ($current_page === 'register.php') {
    include 'views/register.php';
}



// Si une recherche est effectuée
$search = $_GET['search'] ?? '';
$users = $controller->getAllUsers();

// Filtrer les utilisateurs par nom (si champ rempli)
if ($search !== '') {
    $users = array_filter($users, function ($user) use ($search) {
        return stripos($user['name'], $search) !== false;
    });
}






// Récupérer le terme de recherche s'il existe
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Récupérer les utilisateurs (filtrés si recherche)
$controller = new UserController();
$users = $controller->getAllUsers();

// Filtrer les utilisateurs si un terme de recherche est présent
if (!empty($search)) {
    $users = array_filter($users, function($user) use ($search) {
        return stripos($user['name'], $search) !== false;
    });
}





// Vérification que la requête est POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Récupération des données
$data = [
    'name' => trim($_POST['name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'password' => $_POST['password'] ?? '',
    'confirm_password' => $_POST['confirm_password'] ?? '',
    'terms' => $_POST['terms'] ?? '0'
];

// Validation côté serveur
$errors = [];

// Validation du nom
if (empty($data['name'])) {
    $errors['name'] = 'Name is required';
} elseif (strlen($data['name']) < 2) {
    $errors['name'] = 'Name must be at least 2 characters';
}

// Validation de l'email
if (empty($data['email'])) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
} elseif (!preg_match('/^[a-zA-Z0-9._-]+@gmail\.com$/', $data['email'])) {
    $errors['email'] = 'Email must be in format: example@gmail.com';
}

// Validation du mot de passe
if (empty($data['password'])) {
    $errors['password'] = 'Password is required';
} else {
    if (strlen($data['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    if (!preg_match('/[A-Z]/', $data['password'])) {
        $errors['password'] = 'Password must contain at least one uppercase letter';
    }
    if (!preg_match('/[@#$%^&+=]/', $data['password'])) {
        $errors['password'] = 'Password must contain at least one special character (@, #, $, %, ^, &, +, =)';
    }
}

// Vérification de la correspondance des mots de passe
if ($data['password'] !== $data['confirm_password']) {
    $errors['confirm_password'] = 'Passwords do not match';
}

// Vérification des termes
if ($data['terms'] !== '1') {
    $errors['terms'] = 'You must agree to the terms of service';
}


// Si validation OK, procéder à l'inscription
$userController = new UserController();
$result = $userController->register([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => $data['password']
]);


?>