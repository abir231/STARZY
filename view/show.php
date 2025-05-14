<?php
require_once('C:\xampp\htdocs\integration\controller\ressourceC.php');
require_once('C:\xampp\htdocs\integration\model\ressource.php');
$id = $_GET["id"];
$ressourceC = new ressourceC();
$ressource = $ressourceC->showRessource($id);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STARZY - Détail de la Ressource</title>
	
	<!-- Bootstrap CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome for icons -->
	<link href="css/font-awesome.min.css" rel="stylesheet">
	
	<style>
		:root {
			--primary-color: #0f0c29;
			--secondary-color: #1a237e;
			--accent-color: rgb(207, 144, 165);
			--text-light: #ffffff;
		}

		body {
			background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
			color: var(--text-light);
			font-family: Arial, sans-serif;
			min-height: 100vh;
		}

		.wrapper {
			display: flex;
			min-height: 100vh;
		}

		/* Sidebar Styles */
		.sidebar {
			width: 250px;
			background: rgba(15, 12, 41, 0.95);
			padding: 20px 0;
		}

		.sidebar-brand {
			padding: 20px;
			text-align: center;
			color: var(--text-light);
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}

		.sidebar-link {
			display: block;
			padding: 12px 20px;
			color: var(--text-light);
			text-decoration: none;
			transition: all 0.3s;
		}

		.sidebar-link:hover,
		.sidebar-link.active {
			background: rgba(255, 255, 255, 0.1);
			color: var(--accent-color);
		}

		/* Main Content Styles */
		.main {
			flex: 1;
			padding: 20px;
		}

		.card {
			background: rgba(15, 12, 41, 0.95);
			border-radius: 10px;
			box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
			margin-bottom: 20px;
		}

		.card-header {
			padding: 20px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}

		.card-body {
			padding: 20px;
		}

		.resource-details {
			background: rgba(255, 255, 255, 0.05);
			border-radius: 10px;
			padding: 20px;
			margin-bottom: 20px;
		}

		.detail-item {
			margin-bottom: 15px;
			padding-bottom: 10px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}

		.detail-label {
			font-size: 0.9em;
			color: var(--accent-color);
			margin-bottom: 5px;
		}

		.detail-value {
			font-size: 1.1em;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
			border: none;
			padding: 8px 16px;
			color: var(--text-light);
			border-radius: 5px;
			transition: all 0.3s;
		}

		.btn-primary:hover {
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
		}

		/* Footer Styles */
		.footer {
			padding: 20px;
			border-top: 1px solid rgba(255, 255, 255, 0.1);
			margin-top: auto;
		}
	</style>
</head>

<body>
	<div class="wrapper">
		<!-- Sidebar -->
		<nav class="sidebar">
			<div class="sidebar-brand">
				<h2>STARZY</h2>
			</div>
			<div class="sidebar-menu">
				<a href="indiv.php" class="sidebar-link">
					<i class="fa fa-dashboard"></i> Tableau de bord
				</a>
				<a href="liste.php" class="sidebar-link active">
					<i class="fa fa-book"></i> Ressources
				</a>
				<a href="listeco.php" class="sidebar-link">
					<i class="fa fa-comments"></i> Commentaires
				</a>
				<a href="statistiques.php" class="sidebar-link">
					<i class="fa fa-bar-chart"></i> Statistiques
				</a>
			</div>
		</nav>

		<!-- Main Content -->
		<div class="main">
			<div class="card">
				<div class="card-header">
					<h4>Détail de la Ressource</h4>
				</div>
				<div class="card-body">
					<div class="resource-details">
						<div class="detail-item">
							<div class="detail-label">ID de la ressource</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["id"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Titre</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["titre"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Type</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["type_ressource"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Catégorie</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["categorie"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Date de publication</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["date_publication"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Description</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["description"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Référence</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["fichier_ou_lien"]) ?></div>
						</div>
						<div class="detail-item">
							<div class="detail-label">Statut</div>
							<div class="detail-value"><?= htmlspecialchars($ressource["statut"]) ?></div>
						</div>
					</div>
					<a href="liste.php" class="btn btn-primary">
						<i class="fa fa-arrow-left"></i> Retour à la liste
					</a>
				</div>
			</div>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row">
						<div class="col-6">
							<p class="mb-0">
								<strong>Starzy</strong> &copy; <?= date('Y') ?>
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline mb-0">
								<li class="list-inline-item">
									<a href="#" class="text-light">Support</a>
								</li>
								<li class="list-inline-item">
									<a href="#" class="text-light">Centre d'aide</a>
								</li>
								<li class="list-inline-item">
									<a href="#" class="text-light">Confidentialité</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<!-- Essential Scripts -->
	<script src="js/vendor/jquery-1.12.4.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>

</html>