<?php
require_once "../controllers/UserController.php";



if (isset($_POST['update'])) {
    $controller = new UserController();
    $controller->updateUser($_POST); // Update the user with the POST data
    header("Location: users.php"); // Redirect back to users list after update
    exit;
}
?>
