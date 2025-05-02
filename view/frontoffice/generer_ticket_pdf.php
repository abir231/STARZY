<?php
require_once '../../model/Config.php';
require_once '../../lib/fpdf/fpdf.php'; // Assure-toi que FPDF est dans ce dossier

$pdo = Config::getConnection();

if (isset($_GET['ticket_id'])) {
    $ticket_id = intval($_GET['ticket_id']);

    $stmt = $pdo->prepare("
        SELECT t.ticket_id, e.nom_event, e.prix, t.ticket_date, u.nom_user, u.email
        FROM ticket t
        JOIN evenements e ON t.event_id = e.event_id
        JOIN users u ON t.user_id = u.user_id
        WHERE t.ticket_id = ?
    ");
    $stmt->execute([$ticket_id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ticket) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $pdf->Cell(0, 10, 'Ticket de Reservation', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(10);

        $pdf->Cell(50, 10, 'Nom:', 0, 0);
        $pdf->Cell(100, 10, $ticket['nom_user'], 0, 1);

        $pdf->Cell(50, 10, 'Email:', 0, 0);
        $pdf->Cell(100, 10, $ticket['email'], 0, 1);

        $pdf->Cell(50, 10, 'Nom de l\'événement:', 0, 0);
        $pdf->Cell(100, 10, $ticket['nom_event'], 0, 1);

        $pdf->Cell(50, 10, 'Prix:', 0, 0);
        $pdf->Cell(100, 10, $ticket['prix'] . ' DT', 0, 1);

        $pdf->Cell(50, 10, 'Date de Réservation:', 0, 0);
        $pdf->Cell(100, 10, $ticket['ticket_date'], 0, 1);

        $pdf->Output('D', 'ticket_' . $ticket['ticket_id'] . '.pdf');
    } else {
        echo "Ticket non trouvé.";
    }
} else {
    echo "Paramètre ticket_id manquant.";
}
