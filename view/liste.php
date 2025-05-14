<?php



// Include the necessary userC.php file
require_once('C:\xampp\htdocs\integration\controller\ressourceC.php');

// Create an instance of UserC class
$ressourceC = new ressourceC();

// Fetch the list of users
$tab = $ressourceC->listRessources();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STARZY - Gestion des Ressources</title>
	
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
			padding: 15px 20px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
			display: flex;
			justify-content: space-between;
			align-items: center;
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

		/* Table Styles */
		.table {
			color: var(--text-light);
		}

		.table th {
			background: rgba(26, 35, 126, 0.3);
			border-color: rgba(255, 255, 255, 0.1);
		}

		.table td {
			border-color: rgba(255, 255, 255, 0.1);
		}

		.table tr:hover {
			background: rgba(255, 255, 255, 0.05);
		}

		.btn-action {
			padding: 5px 10px;
			margin: 0 2px;
			border-radius: 4px;
			color: var(--text-light);
		}

		.btn-info { background-color: #17a2b8; }
		.btn-warning { background-color: #ffc107; }
		.btn-danger { background-color: #dc3545; }
		.btn-secondary { background-color: #6c757d; }

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
 
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Titre</th>
									<th>Type</th>
									<th>Catégorie</th>
									<th>Date</th>
									<th>Statut</th>
									<th>Évaluation</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tab as $ressource) {
									$evaluation = $ressourceC->getAverageRating($ressource['id']);
								?>
								<tr>
									<td><?= htmlspecialchars($ressource['id']) ?></td>
									<td><?= htmlspecialchars($ressource['titre']) ?></td>
									<td><?= htmlspecialchars($ressource['type_ressource']) ?></td>
									<td><?= htmlspecialchars($ressource['categorie']) ?></td>
									<td><?= htmlspecialchars($ressource['date_publication']) ?></td>
									<td><?= htmlspecialchars($ressource['statut']) ?></td>
									<td><?= ($evaluation === 'N/A') ? '0.0' : number_format($evaluation, 1) ?> <i class="fa fa-star" style="color: #ffc107;"></i></td>
									<td>
										<a href="show.php?id=<?= $ressource['id'] ?>" class="btn btn-action btn-info" title="Voir">
											<i class="fa fa-eye"></i>
										</a>
										<a href="update.php?id=<?= $ressource['id'] ?>" class="btn btn-action btn-warning" title="Modifier">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="delete.php?id=<?= $ressource['id'] ?>" class="btn btn-action btn-danger" title="Supprimer" 
										   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')">
											<i class="fa fa-trash"></i>
										</a>
										<a href="listec.php?id=<?= $ressource['id'] ?>" class="btn btn-action btn-secondary" title="Commentaires">
											<i class="fa fa-comments"></i>
										</a>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
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