<?php

 require_once('C:\xampp\htdocs\integration\controller\ressourceC.php');
 $ressourceC= new ressourceC();
$ressourceC->deleteRessource($_GET['id'] );
header('Location: liste.php');
?>