<?php
require_once(__DIR__.'/../controller/commentaireC.php');
$commentaire = new commentaireC();
$idr = isset($_GET['idc']) ? intval($_GET['idc']) : 0;
$pid = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($idr) {
    $commentaire->deleteCommentaire($idr);
    header('Location: clientco.php?id=' . $pid);
    exit;
} else {
    echo '<div class="alert alert-danger">commentaire introuvable.</div>';
}
?>
