<?php
// Inclure le contrôleur de produit pour récupérer les produits
require_once('../controller/fichiercontroller.php');

// Créer une instance du contrôleur
$produitController = new ProduitController();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Supprimer le produit de la base de données
    $produitController->deleteProduit($id);

    // Rediriger vers la page d'affichage des produits après suppression
    header('Location: indiv.php');
    exit();
}

// Récupérer tous les produits
$produits = $produitController->getProduits();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<style>  /* Style de base pour les liens dans la sidebar */
.sidebar-link {
    color: white !important; /* Texte en blanc */
    padding: 12px 25px; /* Espacement autour du texte */
    display: block; /* Le lien prend toute la largeur disponible */
    text-decoration: none; /* Enlever le soulignement */
    background: linear-gradient(to right, #0f0c29, #1a237e); /* Dégradé similaire à celui des autres éléments */
    border-radius: 8px; /* Coins arrondis */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
}

/* Effet au survol du lien dans la sidebar */
.sidebar-link:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Dégradé inversé au survol */
    color: rgb(226, 146, 189) !important; /* Couleur rose doré au survol */
    transform: scale(1.05); /* Agrandissement léger au survol */
}

/* Pour l'élément actif (si un lien est sélectionné) */
.sidebar-link.active {
    background: linear-gradient(to right,rgb(207, 144, 165), #0f0c29) !important; /* Fond doré pour l'élément actif */
    color: white !important; /* Texte en blanc pour l'élément actif */
}

/* Pour les autres éléments dans la sidebar */
.sidebar-header, .sidebar-div {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important; /* Dégradé pour les autres éléments */
    color: white !important; /* Texte en blanc */
    padding: 10px; /* Optionnel pour l’espacement */
    border-radius: 5px; /* Coins arrondis optionnels */
}
</style>
	<style>  /* Style de base pour le lien de la sidebar */
.sidebar-link {
    color: white !important; /* Texte en blanc */
    padding: 12px 25px; /* Espacement autour du texte */
    display: block; /* Assure que le lien prend toute la largeur */
    text-decoration: none; /* Enlever le soulignement */
    background: linear-gradient(to right, #0f0c29, #1a237e); /* Dégradé cosmique */
    border-radius: 8px; /* Coins arrondis pour un effet plus doux */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
    box-shadow: 0 4px 8px rgb(207, 144, 165); /* Ombre légère pour effet flottant */
}

/* Effet au survol du lien de la sidebar */
.sidebar-link:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Inverser les couleurs au survol */
    transform: scale(1.05); /* Légère augmentation de la taille */
    color:rgb(209, 164, 192) !important; /* Changer la couleur du texte au survol (or) */
}

/* Pour l'état actif, si un lien est sélectionné */
.sidebar-link.active {
    background: linear-gradient(to right,:rgb(209, 164, 192), #0f0c29) !important; /* Fond doré pour l'élément actif */
    color: black !important; /* Texte noir pour mieux contraster */
}
</style>
	<style>  /* Style de base pour le conteneur sidebar-div */
.sidebar-div {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important; /* Dégradé cosmique */
    padding: 20px; /* Ajouter de l'espace à l'intérieur */
    border-radius: 10px; /* Coins arrondis pour un effet plus doux */
    box-shadow: 0 4px 12px rgb(207, 144, 165); /* Ombre pour un effet flottant */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
}

/* Effet au survol du conteneur sidebar-div */
.sidebar-div:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Inverser les couleurs au survol */
    transform: scale(1.03); /* Agrandir légèrement au survol */
}

/* Si tu veux ajouter des bordures pour délimiter la div */
.sidebar-div {
    border: 1px solid rgba(255, 255, 255, 0.1); /* Bordure légère */
}

/* Si tu veux styliser des éléments spécifiques à l'intérieur de .sidebar-div (comme des liens ou des textes) */
.sidebar-div .sidebar-link {
    color: white !important; /* Liens en blanc */
    padding: 10px; /* Espacement autour du texte */
    display: block; /* Prendre toute la largeur */
    text-decoration: none; /* Supprimer le soulignement */
    border-radius: 5px; /* Coins arrondis */
}

/* Effet de survol pour les liens dans .sidebar-div */
.sidebar-div .sidebar-link:hover {
    background::rgb(209, 164, 192) !important; /* Fond doré au survol */
    color: black !important; /* Texte noir au survol */
    transform: scale(1.05); /* Agrandir légèrement au survol */
}
 </style>
	<style>  /* Style de base pour le lien de la sidebar */
.sidebar-link {
    color: white !important; /* Texte en blanc */
    padding: 10px 20px; /* Espacement autour du texte */
    display: block; /* Assurer que le lien prend toute la largeur */
    text-decoration: none; /* Enlever le soulignement */
    background: linear-gradient(to right, #0f0c29, #1a237e); /* Dégradé cosmique bleu-violet */
    border-radius: 8px; /* Coins arrondis pour un effet plus doux */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
    box-shadow: 0 4px 8pxrgb(207, 144, 165); /* Ombre légère pour effet flottant */
}

/* Effet au survol du lien de la sidebar */
.sidebar-link:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Inverser les couleurs au survol */
    transform: scale(1.05); /* Légère augmentation de la taille */
    color::rgb(209, 164, 192) !important; /* Changer la couleur du texte au survol (or) */
}

/* Pour l'état actif, si un lien est sélectionné */
.sidebar-link.active {
    background: linear-gradient(to right,:rgb(209, 164, 192), #0f0c29) !important; /* Fond doré pour l'élément actif */
    color: black !important; /* Texte noir pour mieux contraster */
}
 </style>
	<style>   .simplebar-content-wrapper {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important; /* Dégradé cosmique bleu-violet */
    color: white !important; /* Texte en blanc pour le contraste */
    padding: 15px; /* Ajouter un peu d'espace intérieur */
    border-radius: 10px; /* Coins arrondis pour un effet plus doux */
    box-shadow: 0 4px 8pxrgb(207, 144, 165); /* Ombre légère pour un effet flottant */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
}

/* Effet au survol (hover) */
.simplebar-content-wrapper:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Inverser les couleurs au survol */
    transform: scale(1.05); /* Agrandir légèrement au survol */
}
</style>
	<style>  .product-status-wrap {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important; /* Dégradé cosmique */
    color: white !important; /* Texte en blanc pour un meilleur contraste */
    padding: 20px; /* Ajouter de l'espace à l'intérieur */
    border-radius: 10px; /* Coins arrondis */
    box-shadow: 0 4px 8pxrgb(207, 144, 165); /* Légère ombre pour un effet flottant */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition douce */
}

/* Effet au survol (hover) */
.product-status-wrap:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Inverser les couleurs au survol */
    transform: scale(1.05); /* Légère augmentation de la taille au survol */
}
 </style>
	<style>  /* Style de base pour la table */
table {
    width: 100%;
    border-collapse: collapse; /* Fusionner les bordures des cellules */
    background: linear-gradient(to right, #0f0c29, #1a237e); /* Dégradé bleu-violet */
    color: white; /* Texte en blanc pour un meilleur contraste */
    border-radius: 10px; /* Coins arrondis */
    box-shadow: 0 4px 8pxrgb(207, 144, 165); /* Ombre légère pour effet flottant */
}

/* Style des cellules de la table */
th, td {
    padding: 12px 20px; /* Espacement intérieur des cellules */
    text-align: left; /* Aligner le texte à gauche */
    border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Bordure entre les lignes */
}

/* Bordure et fond alterné pour les lignes */
tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.1); /* Lignes paires légèrement plus claires */
}

tr:hover {
    background: rgba(255, 255, 255, 0.2); /* Effet au survol des lignes */
    transform: scale(1.02); /* Légère agrandissement de la ligne */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition fluide */
}

/* Style pour les en-têtes de colonnes */
th {
    background-color: #1a237e; /* Fond violet pour l'en-tête */
    font-weight: bold; /* Gras pour les titres */
    text-transform: uppercase; /* Textes en majuscules */
}

/* Optionnel : ajouter des bordures au tableau */
table, th, td {
    border: 1px solid #fff; /* Bordure blanche autour du tableau et des cellules */
}
</style>
	<style>  /* Dégradé cosmique pour toutes les colonnes */
.col-lg-12, .col-md-12, .col-sm-12, .col-xs-12 {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important;
    color: white !important; /* Texte en blanc pour plus de contraste */
    padding: 20px; /* Ajouter de l'espace à l'intérieur */
    border-radius: 8px; /* Coins arrondis */
    box-shadow: 0 4px 8pxrgb(207, 144, 165); /* Légère ombre pour un effet flottant */
    transition: background 0.3s ease, transform 0.3s ease; /* Transition douce */
}

/* Effet au survol (hover) */
.col-lg-12:hover, .col-md-12:hover, .col-sm-12:hover, .col-xs-12:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important; /* Changer les couleurs au survol */
    transform: scale(1.05); /* Légère augmentation de la taille au survol */
}
</style>
	<style>
/* Appliquer le dégradé à toutes les colonnes */
.col-lg-12, .col-md-12, .col-sm-12, .col-xs-12 {
    background: linear-gradient(to right, #0f0c29, #1a237e) !important;
    color: white !important; /* Texte blanc pour un bon contraste */
    padding: 20px; /* Optionnel : espacement interne */
    border-radius: 8px; /* Optionnel : adoucir les bords */
}

/* Si tu veux un effet au survol des colonnes */
.col-lg-12:hover, .col-md-12:hover, .col-sm-12:hover, .col-xs-12:hover {
    background: linear-gradient(to right, #1a237e, #0f0c29) !important;
    transform: scale(1.05); /* Légère augmentation de la taille au survol */
    transition: background 0.3s, transform 0.3s;
}
</style>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>STARZY</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- nalika Icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/nalika-icon.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- meanmenu icon CSS
		============================================ -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="css/main.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="css/calendar/fullcalendar.print.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="css/responsive.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
	<div class="wrapper">
		<div id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">STARZY</span>
        </a>

				<ul class="sidebar-div">
					<li class="sidebar-header">
						
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Tableau de bord</span>
            </a>
					</li>
				</li>
				<a class="sidebar-link" href=" ">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Gestion des activités de patrimoine</span>
                  </a>
             
                </li>
                <a class="sidebar-link" href="index.html">
					<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Gestion des patrimoines</span>
				  </a>
			 
				</li>
			</li>
			
			
					<li class="sidebar-item">
						<a class="sidebar-link" href="">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Gestion des comptes</span>
            </a>
				
				</li>
				<a class="sidebar-link" href=" ">
					<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Gestion des evenements</span>
				  </a>
			 
				</li>
			</li>
			<a href="/crudweb/view/products.php" class="sidebar-link">
    <i class="align-middle" data-feather="check-square"></i>
    <span class="align-middle">Users</span>
</a>
		 
			</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href=" ">
              <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Se deconnecter</span>
            </a>
					</li>

					 

					 

				 
			</div>
		</div>

		<div class="main">
			 

			<main class="content">
				<div class="container-fluid p-0">

					
				 

					 
					 
				 

					
                <div class="all-content-wrapper">
                <div class="product-status mg-b-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-status-wrap">
                            <h4>Products List</h4>
                            <div class="add-product">
                                <a href="edit.php">Add Product</a>
                            </div>
                            <table>
    <tr>
        <th>Image</th>
        <th>Product Title</th>
       
        <th>description</th>
		<th>disponibilite</th>
        <th>categorie</th>
        <th>price</th>
        <th>seeting</th>
		

    </tr>
    
    <?php foreach ($produits as $product): ?>
    <tr>
	<td>
    <?php if (!empty($product['image'])): ?>
        <img src="data:image/jpeg;base64,<?= base64_encode($product['image']) ?>" alt="Image du produit" width="100" height="100" />
    <?php else: ?>
        <span>Aucune image</span>
    <?php endif; ?>
</td>
		
        <td><?= htmlspecialchars($product['nom']) ?></td>
       
		<td><?= $product['description'] ?></td>
<td>
    <?= htmlspecialchars($product['disponibite']) ?> <!-- Affiche directement le texte dans 'disponibite' -->
</td>


        <td><?= $product['categorie'] ?></td>
        <td>$<?= number_format($product['prix'], 2) ?></td>
       <td>
	   <a href="edit.php?id=<?= $product['ID'] ?>" class="btn btn-primary" title="Éditer">
    <i class="fa fa-pencil" aria-hidden="true"></i>
</a>


			<a href="indiv.php?delete=<?= $product['ID'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
    <button data-toggle="tooltip" title="Trash" class="pd-setting-ed">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
    </button>
</a>

</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
                            <div class="custom-pagination">
								<ul class="pagination">
									<li class="page-item"><a class="page-link" href="#">Previous</a></li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item"><a class="page-link" href="#">Next</a></li>
								</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>CultuRevive</strong></a> &copy;
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

	<script src="js/app.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Sales ($)",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [
							2115,
							1562,
							1584,
							1892,
							1587,
							1923,
							2566,
							2448,
							2805,
							3438,
							2917,
							3327
						]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: ["Chrome", "Firefox", "IE"],
					datasets: [{
						data: [4306, 3801, 1689],
						backgroundColor: [
							window.theme.primary,
							window.theme.warning,
							window.theme.danger
						],
						borderWidth: 5
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "This year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var markers = [{
					coords: [31.230391, 121.473701],
					name: "Shanghai"
				},
				{
					coords: [28.704060, 77.102493],
					name: "Delhi"
				},
				{
					coords: [6.524379, 3.379206],
					name: "Lagos"
				},
				{
					coords: [35.689487, 139.691711],
					name: "Tokyo"
				},
				{
					coords: [23.129110, 113.264381],
					name: "Guangzhou"
				},
				{
					coords: [40.7127837, -74.0059413],
					name: "New York"
				},
				{
					coords: [34.052235, -118.243683],
					name: "Los Angeles"
				},
				{
					coords: [41.878113, -87.629799],
					name: "Chicago"
				},
				{
					coords: [51.507351, -0.127758],
					name: "London"
				},
				{
					coords: [40.416775, -3.703790],
					name: "Madrid "
				}
			];
			var map = new jsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				markers: markers,
				markerStyle: {
					initial: {
						r: 9,
						strokeWidth: 7,
						stokeOpacity: .4,
						fill: window.theme.primary
					},
					hover: {
						fill: window.theme.primary,
						stroke: window.theme.primary
					}
				},
				zoomOnScroll: false
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
			var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span title=\"Previous month\">&laquo;</span>",
				nextArrow: "<span title=\"Next month\">&raquo;</span>",
				defaultDate: defaultDate
			});
		});
	</script>
 <!-- jquery
		============================================ -->
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="js/metisMenu/metisMenu.min.js"></script>
    <script src="js/metisMenu/metisMenu-active.js"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="js/calendar/moment.min.js"></script>
    <script src="js/calendar/fullcalendar.min.js"></script>
    <script src="js/calendar/fullcalendar-active.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="js/main.js"></script>
</body>

</body>

</html>