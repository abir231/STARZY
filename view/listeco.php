<?php



// Include the necessary userC.php file
require_once('C:\xampp\htdocs\chaima\controller\commentaireC.php');

// Create an instance of UserC class
$commentaire = new commentaireC();

// Fetch the list of users
$tab = $commentaire->listCommentaires();
$id  = isset($_GET['id']) ? intval($_GET['id']) : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords"
		content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Starzy</title>

	<link href="back-office/static/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<style>
	.container-fluid.custom-big {
    padding: 0rem; /* au lieu de p-0 */
}
.full-width {
    width: 100vw;          /* Prend toute la largeur de la fenêtre */
    max-width: 100vw;
    margin: 0;
    padding: 0;
    overflow-x: hidden;    /* Évite les scrolls horizontaux */
}

/* Style for active sort button */
.sort-btn.active {
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    font-weight: bold;
}

	</style>
<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
					<span class="align-middle">Starzy</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">

					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="liste.php">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Gestion des ressources </span>
						</a>
					</li>
					<li class="sidebar-item active">
						<a class="sidebar-link" href="listeco.php">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Gestion des Commentaires </span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="statistiques.php">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Statistiques</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href=" ">
							<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Se
								deconnecter</span>
						</a>
					</li>






			</div>
		</nav>

		<div class="main">


			<main class="content">
			<div class="container-fluid p-0 full-width">

					<h1 class="h3 mb-3"><strong>Les Commentaire :  </strong> </h1>
					<div class="row">
						<div class="col-12 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0"> Liste des commentaires à gérer </h5>
									
									<!-- Boutons de tri -->
									<div class="sort-controls mt-3">
										<button class="btn btn-sm btn-primary sort-btn" onclick="sortTable('default')">Par défaut</button>
										<button class="btn btn-sm btn-success sort-btn" onclick="sortTable('rating-high')">Notes élevées</button>
										<button class="btn btn-sm btn-warning sort-btn" onclick="sortTable('rating-low')">Notes basses</button>
										<button class="btn btn-sm btn-info sort-btn" onclick="sortTable('date')">Date récente</button>
									</div>
								</div>
								<table class="table table-hover my-0">
									<div class="card-body px-0 pb-2">
										<div class="table-responsive p-0">
											<table class="table align-items-center mb-0">
												<thead>
													<tr>
														<th
															class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															ID  commentaire</th>
														<th
															class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
															Contenu  </th>
														<th
															class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															Date creation </th>
														<th
															class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															Evaluation  </th>
														<th
															class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															ID ressource </th>
												 
                                              


														<th
															class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															delete </th>
														<th
															class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
															Detail </th>
											 
 

													</tr>
												</thead>
												<?php
												foreach ($tab as $commentaire) {
 
													?>
													<tbody>
														<tr>
															<td>
																<div class="d-flex px-2 py-1">
																	<div class="d-flex flex-column justify-content-center">
																		<h6 class="mb-0 text-sm">
																			<?= $commentaire['idc']; ?>
																			<!-- Utilisez les clés de tableau -->
																		</h6>
																	</div>
																</div>
															</td>
															<td>
																<p class="text-xs font-weight-bold mb-0">
                                                                <?= $commentaire['contenu']; ?>
                                                                <!-- Utilisez les clés de tableau -->
																</p>
															</td>
															<td class="align-middle text-center">
																<span class="text-secondary text-xs font-weight-bold">
                                                                <?= $commentaire['datec']; ?>
                                                                <!-- Utilisez les clés de tableau -->
																</span>
															</td>
															<td class="align-middle text-center">
																<span class="text-secondary text-xs font-weight-bold">
                                                                <?= $commentaire['note']; ?>
                                                                <!-- Utilisez les clés de tableau -->
																</span>
															</td>
												 
														 
                                                    
                                                            <td class="align-middle text-center">
																<span class="text-secondary text-xs font-weight-bold">
                                                                <?= $commentaire['id']; ?>
                                                                <!-- Utilisez les clés de tableau -->
																</span>
															</td>
															<td class="align-middle text-center text-sm">
																<span class="badge bg-danger">
																	<a
																		href="deletec.php?idc=<?= $commentaire['idc']; ?> &id=<?= $commentaire['id']; ?>"  >ici</a>
																</span>
															</td>
															<td class="align-middle text-center text-sm">
																<span class="badge bg-success">
																	<a
																		href="showc.php?idc=<?= $commentaire['idc']; ?> &id=<?= $commentaire['id']; ?>">ici</a>
																</span>
															</td>
														 
														</tr>
													</tbody>
													<?php
												}
                                            
												?>


												</tbody>
											</table>
										</div>
									</div>


							</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/"
									target="_blank"><strong>CultuRevive</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href=" " target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href=" " target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="  " target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href=" " target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="back-office/static/js/app.js"></script>

	<script>
		// Fonction simplifiée pour trier le tableau des commentaires
		function sortTable(sortType) {
			// Récupérer toutes les lignes du tableau dans un array (sélection plus précise)
			const tableRows = document.querySelectorAll('table.align-items-center tbody tr');
			const rowsArray = Array.from(tableRows);
			
			// Si aucune ligne n'est trouvée, sortir
			if (rowsArray.length === 0) {
				alert("Aucune donnée à trier");
				return;
			}
			
			// Mettre en surbrillance le bouton actif
			document.querySelectorAll('.sort-btn').forEach(btn => {
				btn.classList.remove('active');
			});
			event.target.classList.add('active');
			
			// Tri par défaut - recharger la page
			if (sortType === 'default') {
				window.location.reload();
				return;
			}
			
			// Trier les lignes selon le critère
			rowsArray.sort((rowA, rowB) => {
				let valueA, valueB;
				
				// Colonne de l'évaluation (index 3)
				if (sortType === 'rating-high' || sortType === 'rating-low') {
					// Trouver la cellule de l'évaluation (4ème colonne)
					const cellA = rowA.querySelector('td:nth-child(4)')?.textContent.trim() || "0";
					const cellB = rowB.querySelector('td:nth-child(4)')?.textContent.trim() || "0";
					
					// Convertir en nombre
					valueA = parseFloat(cellA) || 0;
					valueB = parseFloat(cellB) || 0;
					
					// Ordre croissant ou décroissant
					return sortType === 'rating-high' ? valueB - valueA : valueA - valueB;
				}
				
				// Colonne de date (index 2)
				if (sortType === 'date') {
					// Trouver la cellule de date (3ème colonne)
					const cellA = rowA.querySelector('td:nth-child(3)')?.textContent.trim() || "";
					const cellB = rowB.querySelector('td:nth-child(3)')?.textContent.trim() || "";
					
					// Comparer les dates (plus récent en premier)
					const dateA = new Date(cellA);
					const dateB = new Date(cellB);
					
					return dateB - dateA;
				}
				
				return 0;
			});
			
			// Récupérer le parent (tbody)
			const tbody = tableRows[0].parentNode;
			
			// Détacher les lignes du DOM
			const detachedRows = rowsArray.map(row => row.parentNode.removeChild(row));
			
			// Réinsérer les lignes triées
			detachedRows.forEach(row => {
				tbody.appendChild(row);
			});
		}
	</script>

</body>

</html>