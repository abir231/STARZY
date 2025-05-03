<?php
// Inclure les fichiers nécessaires
    require_once('C:\xampp\htdocs\chaima\controller\ressourceC.php');
    require_once('C:\xampp\htdocs\chaima\model\ressource.php');
$ressource=null;
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
        // Création de l'objet ressource avec les données du formulaire
        $ressource = new Ressource(
            null,   // id non passé car auto-incrémenté
            $_POST['titre'],
            $_POST['type_ressource'],
            $_POST['categorie'],
            $_POST['date_publication'],
            $_POST['description'],
            $_POST['fichier_ou_lien'],
            $_POST['statut']
        );
    $ressourceC->updateRessource($ressource,$_GET['id']);
    header('Location: liste.php');

    }

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
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-6 d-flex align-items-center">
                                <h6 class="mb-0">Mise a jour du ressource </h6>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-outline-primary btn-sm mb-0"> <a href="liste.php">
                                        Retour
                                        à la liste </a></button>
                                <?php
                                if (isset($_GET['id'])) {
                                    $oldressource = $ressourceC->showRessource($_GET['id']);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="card-body p-3 pb-0">
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td><label for="id_zone">ID :</label></td>
                                                </h6>
                                                <span class="text-xs">
                                                    <td>
                                                        <input type="text" id="id" name="id"
                                                            value="<?php echo $_GET['id'] ?>" readonly />
                                                    </td>
                                                </span>
                                            </tr>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td><label for="titre">Titre du ressource :</label></td>
                                                </h6>
                                                <span class="text-xs">
                                                    <td>
                                                        <input type="text" id="titre" name="titre"
                                                            value="<?php echo $oldressource['titre'] ?>" />
                                                    </td>
                                                </span>
                                            </tr>
                                        </div>
                                    </li>
                                </ul>
                        
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td>
                                                        <label for="type_ressource">Type :</label>
                                                        <select id="type_ressource" name="type_ressource">
                                                            <option value="pdf" <?php if ($oldressource['type_ressource'] == 'pdf')
                                                                echo 'selected' ?>>PDF</option>
                                                                <option value="article" <?php if ($oldressource['type_ressource'] == 'article')
                                                                echo 'selected' ?>>Article</option>

                                                                <option value="video" <?php if ($oldressource['type_ressource'] == 'video')
                                                                echo 'selected' ?>>Vidéo</option>
                                                                <option value="autre" <?php if ($oldressource['type_ressource'] == 'autre')
                                                                echo 'selected' ?>>AUTRE</option>

                                                            </select>
                                                        </td>
                                                    </h6>
                                                </tr>
                                            </div>
                                        </li>
                                    </ul>
                            
                        
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td>
                                                        <label for="categorie">Nom categorie :</label>
                                                        <select id="categorie" name="categorie">
                                                            <option value="astronomie_generale" <?php if ($oldressource['categorie'] == 'astronomie_generale')
                                                                echo 'selected' ?>>Astronomie Générale</option>
                                                                <option value="planetes" <?php if ($oldressource['categorie'] == 'planetes')
                                                                echo 'selected' ?>>Planètes</option>

                                                                <option value="etoiles" <?php if ($oldressource['categorie'] == 'etoiles')
                                                                echo 'selected' ?>>Étoiles</option>
                                                                <option value="galaxies" <?php if ($oldressource['categorie'] == 'galaxies')
                                                                echo 'selected' ?>>Galaxies</option>
                                       <option value="cosmologie" <?php if ($oldressource['categorie'] == 'cosmologie')
                                                                echo 'selected' ?>>Cosmologie</option>
                                                            </select>
                                                        </td>
                                                    </h6>
                                                </tr>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td><label for="date_publication">Date de publication :</label></td>
                                                </h6>
                                                <span class="text-xs">
                                                    <td>
                                                        <input type="date" id="date_publication" name="date_publication"
                                                            value="<?php echo $oldressource['date_publication'] ?>" />
                                                    </td>
                                                </span>
                                            </tr>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <tr>
                                                <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                    <td><label for="description">Description :</label></td>
                                                </h6>
                                                <span class="text-xs">
                                                    <td>
                                                        <input type="text" id="description" name="description"
                                                            value="<?php echo $oldressource['description'] ?>" />
                                                    </td>
                                                </span>
                                            </tr>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-group">
    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
            <h6 class="mb-1 text-dark font-weight-bold text-sm">
                <label for="fichier_ou_lien">Fichier disponible  :</label>
            </h6>
            <span class="text-xs">
                <?php if (!empty($oldressource['fichier_ou_lien'])) : ?>
                    <p>Fichier actuel : 
                        <a href="uploads/<?php echo htmlspecialchars($oldressource['fichier_ou_lien']); ?>" target="_blank">
                            <?php echo htmlspecialchars($oldressource['fichier_ou_lien']); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <input type="file" id="fichier_ou_lien" name="fichier_ou_lien">
            </span>
        </div>
    </li>
</ul>
 
                                    <ul class="list-group">
                                        <li
                                            class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <tr>
                                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">
                                                        <td>
                                                            <label for="statut">Statut :</label>
                                                            <select id="statut" name="statut">
                                                                <option value="publie" <?php if ($oldressource['statut'] == 'publie')
                                                                echo 'selected' ?>>Publié
                                                                </option>
                                                                <option value="brouillon" <?php if ($oldressource['statut'] == 'brouillon')
                                                                echo 'selected' ?>>Brouillon</option>
                                                                <option value="archive" <?php if ($oldressource['statut'] == 'archive')
                                                                echo 'selected' ?>> Archivé</option>



                                                            </select>
                                                        </td>
                                                    </h6>
                                                </tr>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <ul>
                                    <input class="btn btn-outline-primary btn-sm mb-0" type="submit" value="Update">
                                    <input class="btn btn-outline-primary btn-sm mb-0" type="reset" value="Reset">

                                </ul>

                            </form>
                    <?php }
                                ?>
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
                    <a class="text-muted" href="https://adminkit.io/"
                        target="_blank"><strong>Starzy</strong></a> &copy;
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
document.addEventListener("DOMContentLoaded", function () {
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
document.addEventListener("DOMContentLoaded", function () {
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
document.addEventListener("DOMContentLoaded", function () {
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
document.addEventListener("DOMContentLoaded", function () {
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
document.addEventListener("DOMContentLoaded", function () {
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

</body>

</html>