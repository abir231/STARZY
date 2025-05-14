<?php



// Include the necessary userC.php file
require_once('C:\xampp\htdocs\integration\controller\commentaireC.php');

// Create an instance of UserC class
$commentaire = new commentaireC();

// Fetch the list of users
$tab = $commentaire->listCommentaires();
$id  = isset($_GET['id']) ? intval($_GET['id']) : 0;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STARZY - Gestion des Commentaires</title>
	
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

		/* Table Styles */
		.table {
			color: var(--text-light);
		}

		.table th {
			background: rgba(26, 35, 126, 0.3);
			border-color: rgba(255, 255, 255, 0.1);
			font-weight: 600;
			text-transform: uppercase;
			font-size: 0.75rem;
			letter-spacing: 0.5px;
		}

		.table td {
			border-color: rgba(255, 255, 255, 0.1);
			vertical-align: middle;
		}

		.table tr:hover {
			background: rgba(255, 255, 255, 0.05);
		}

		/* Button Styles */
		.btn {
			padding: 6px 12px;
			border-radius: 4px;
			transition: all 0.3s;
			text-decoration: none;
			font-size: 0.875rem;
		}

		.sort-controls {
			margin-bottom: 20px;
		}

		.sort-btn {
			margin-right: 5px;
			background: transparent;
			border: 1px solid var(--accent-color);
			color: var(--text-light);
			padding: 5px 10px;
		}

		.sort-btn:hover,
		.sort-btn.active {
			background: var(--accent-color);
			color: var(--primary-color);
		}

		.badge {
			padding: 5px 10px;
			border-radius: 15px;
			font-weight: 500;
			text-decoration: none;
			display: inline-block;
		}

		.badge.bg-danger {
			background: linear-gradient(135deg, #dc3545, #b02a37) !important;
		}

		.badge.bg-success {
			background: linear-gradient(135deg, #198754, #146c43) !important;
		}

		.badge a {
			color: var(--text-light);
			text-decoration: none;
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
				<a href="liste.php" class="sidebar-link">
					<i class="fa fa-book"></i> Ressources
				</a>
				<a href="listeco.php" class="sidebar-link active">
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
					<h4 class="card-title">Liste des commentaires</h4>
					<div class="sort-controls">
						<button class="btn sort-btn" onclick="sortTable('default')">Par défaut</button>
						<button class="btn sort-btn" onclick="sortTable('rating-high')">Notes élevées</button>
						<button class="btn sort-btn" onclick="sortTable('rating-low')">Notes basses</button>
						<button class="btn sort-btn" onclick="sortTable('date')">Date récente</button>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table align-items-center">
							<thead>
								<tr>
									<th>ID Commentaire</th>
									<th>Contenu</th>
									<th>Date création</th>
									<th>Évaluation</th>
									<th>ID Ressource</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($tab as $commentaire) { ?>
								<tr>
									<td><?= htmlspecialchars($commentaire['idc']) ?></td>
									<td><?= htmlspecialchars($commentaire['contenu']) ?></td>
									<td><?= htmlspecialchars($commentaire['datec']) ?></td>
									<td>
										<?= number_format(floatval($commentaire['note']), 1) ?>
										<i class="fa fa-star" style="color: #ffc107;"></i>
									</td>
									<td><?= htmlspecialchars($commentaire['id']) ?></td>
									<td>
										<a href="showc.php?idc=<?= $commentaire['idc'] ?>&id=<?= $commentaire['id'] ?>" 
										   class="btn btn-info btn-sm" title="Voir">
											<i class="fa fa-eye"></i>
										</a>
										<a href="deletec.php?idc=<?= $commentaire['idc'] ?>&id=<?= $commentaire['id'] ?>" 
										   class="btn btn-danger btn-sm" title="Supprimer"
										   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
											<i class="fa fa-trash"></i>
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

	<script>
		function sortTable(sortType) {
			const tbody = document.querySelector('table.align-items-center tbody');
			const rows = Array.from(tbody.querySelectorAll('tr'));
			
			// Update active button state
			document.querySelectorAll('.sort-btn').forEach(btn => {
				btn.classList.remove('active');
			});
			event.target.classList.add('active');
			
			// Return to default order
			if (sortType === 'default') {
				window.location.reload();
				return;
			}
			
			rows.sort((a, b) => {
				let aValue, bValue;
				
				switch(sortType) {
					case 'rating-high':
					case 'rating-low':
						aValue = parseFloat(a.querySelector('td:nth-child(4)').textContent);
						bValue = parseFloat(b.querySelector('td:nth-child(4)').textContent);
						return sortType === 'rating-high' ? bValue - aValue : aValue - bValue;
						
					case 'date':
						aValue = new Date(a.querySelector('td:nth-child(3)').textContent);
						bValue = new Date(b.querySelector('td:nth-child(3)').textContent);
						return bValue - aValue;
				}
			});
			
			// Clear and re-append sorted rows
			rows.forEach(row => tbody.appendChild(row));
		}
	</script>
</body>
</html>