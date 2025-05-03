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
                                                    if ($commentaire['id'] == $id) {

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