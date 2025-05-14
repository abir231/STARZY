<?php
// Inclure les fichiers nécessaires
require_once('C:\xampp\htdocs\integration\controller\ressourceC.php');
require_once('C:\xampp\htdocs\integration\model\ressource.php');
$ressource = null;
$ressourceC = new ressourceC();
if (
    isset($_POST["titre"], $_POST["type_ressource"], $_POST["categorie"], $_POST["date_publication"], $_POST["description"], $_POST["fichier_ou_lien"], $_POST["statut"]) &&
    !empty($_POST["titre"]) &&
    !empty($_POST["type_ressource"]) &&
    !empty($_POST["categorie"]) &&
    !empty($_POST["date_publication"]) &&
    !empty($_POST["description"]) &&
    !empty($_POST["fichier_ou_lien"]) &&
    !empty($_POST["statut"])
) {
    $ressource = new Ressource(
        null,
        $_POST['titre'],
        $_POST['type_ressource'],
        $_POST['categorie'],
        $_POST['date_publication'],
        $_POST['description'],
        $_POST['fichier_ou_lien'],
        $_POST['statut']
    );
    $ressourceC->updateRessource($ressource, $_GET['id']);
    header('Location: liste.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STARZY - Modifier la Ressource</title>
	
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
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.card-body {
			padding: 20px;
		}

		.form-group {
			margin-bottom: 20px;
		}

		.form-label {
			display: block;
			margin-bottom: 8px;
			color: var(--accent-color);
			font-size: 0.9em;
		}

		.form-control {
			width: 100%;
			padding: 8px 12px;
			background: rgba(255, 255, 255, 0.1);
			border: 1px solid rgba(255, 255, 255, 0.2);
			border-radius: 5px;
			color: var(--text-light);
			transition: all 0.3s;
		}

		.form-control:focus {
			background: rgba(255, 255, 255, 0.15);
			border-color: var(--accent-color);
			outline: none;
		}

		select.form-control {
			appearance: none;
			background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
			background-repeat: no-repeat;
			background-position: right 12px center;
			padding-right: 30px;
		}

		.btn {
			padding: 8px 16px;
			border-radius: 5px;
			border: none;
			cursor: pointer;
			transition: all 0.3s;
			text-decoration: none;
			display: inline-block;
		}

		.btn-primary {
			background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
			color: var(--text-light);
		}

		.btn-outline-primary {
			background: transparent;
			border: 1px solid var(--accent-color);
			color: var(--accent-color);
		}

		.btn:hover {
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
					<h4>Modifier la Ressource</h4>
					<a href="liste.php" class="btn btn-outline-primary">
						<i class="fa fa-arrow-left"></i> Retour à la liste
					</a>
				</div>
				<div class="card-body">
					<?php
					if (isset($_GET['id'])) {
						$oldressource = $ressourceC->showRessource($_GET['id']);
					?>
					<form action="" method="POST">
						<div class="form-group">
							<label class="form-label">ID</label>
							<input type="text" class="form-control" name="id" value="<?php echo $_GET['id'] ?>" readonly />
						</div>

						<div class="form-group">
							<label class="form-label">Titre de la ressource</label>
							<input type="text" class="form-control" name="titre" value="<?php echo $oldressource['titre'] ?>" required />
						</div>

						<div class="form-group">
							<label class="form-label">Type</label>
							<select class="form-control" name="type_ressource" required>
								<option value="pdf" <?php if ($oldressource['type_ressource'] == 'pdf') echo 'selected' ?>>PDF</option>
								<option value="article" <?php if ($oldressource['type_ressource'] == 'article') echo 'selected' ?>>Article</option>
								<option value="video" <?php if ($oldressource['type_ressource'] == 'video') echo 'selected' ?>>Vidéo</option>
								<option value="autre" <?php if ($oldressource['type_ressource'] == 'autre') echo 'selected' ?>>Autre</option>
							</select>
						</div>

						<div class="form-group">
							<label class="form-label">Catégorie</label>
							<select class="form-control" name="categorie" required>
								<option value="astronomie_generale" <?php if ($oldressource['categorie'] == 'astronomie_generale') echo 'selected' ?>>Astronomie Générale</option>
								<option value="planetes" <?php if ($oldressource['categorie'] == 'planetes') echo 'selected' ?>>Planètes</option>
								<option value="etoiles" <?php if ($oldressource['categorie'] == 'etoiles') echo 'selected' ?>>Étoiles</option>
								<option value="galaxies" <?php if ($oldressource['categorie'] == 'galaxies') echo 'selected' ?>>Galaxies</option>
								<option value="cosmologie" <?php if ($oldressource['categorie'] == 'cosmologie') echo 'selected' ?>>Cosmologie</option>
							</select>
						</div>

						<div class="form-group">
							<label class="form-label">Date de publication</label>
							<input type="date" class="form-control" name="date_publication" value="<?php echo $oldressource['date_publication'] ?>" required />
						</div>

						<div class="form-group">
							<label class="form-label">Description</label>
							<textarea class="form-control" name="description" rows="4" required><?php echo $oldressource['description'] ?></textarea>
						</div>

						<div class="form-group">
							<label class="form-label">Fichier ou lien</label>
							<input type="text" class="form-control" name="fichier_ou_lien" value="<?php echo $oldressource['fichier_ou_lien'] ?>" required />
						</div>

						<div class="form-group">
							<label class="form-label">Statut</label>
							<select class="form-control" name="statut" required>
								<option value="actif" <?php if ($oldressource['statut'] == 'actif') echo 'selected' ?>>Actif</option>
								<option value="inactif" <?php if ($oldressource['statut'] == 'inactif') echo 'selected' ?>>Inactif</option>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> Enregistrer les modifications
							</button>
						</div>
					</form>
					<?php } ?>
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
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>