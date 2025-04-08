<?php

 require_once('C:\xampp\htdocs\chaima\controller\ressourceC.php');
 $ressourceC= new ressourceC();
$ressourceC->deleteRessource($_GET['id'] );
header('Location: liste.php');
?>