<?php
// Inclusion des classes nécessaires
require_once('C:\xampp\htdocs\chaima\controller\ressourceC.php');
require_once('C:\xampp\htdocs\chaima\controller\commentaireC.php');

// Création des instances de contrôleurs
$ressourceC = new ressourceC();
$commentaireC = new CommentaireC();

// Récupération des statistiques
$totalResources = $ressourceC->getTotalResources();
$totalComments = $commentaireC->getTotalComments();
$averageRating = $commentaireC->getOverallAverageRating();
$resourcesByCategory = $ressourceC->getResourcesByCategory();
$resourcesByType = $ressourceC->getResourcesByType();
$topRatedResources = $ressourceC->getTopRatedResources(5);
$mostCommentedResources = $ressourceC->getMostCommentedResources(5);
$ratingDistribution = $commentaireC->getRatingDistribution();
$resourcesByMonth = $ressourceC->getResourcesByMonth();
$commentsByMonth = $commentaireC->getCommentsByMonth();

// Préparation des données pour les graphiques
$categoryLabels = [];
$categoryData = [];
foreach ($resourcesByCategory as $category) {
    $categoryLabels[] = $category['categorie'];
    $categoryData[] = $category['total'];
}

$typeLabels = [];
$typeData = [];
foreach ($resourcesByType as $type) {
    $typeLabels[] = $type['type_ressource'];
    $typeData[] = $type['total'];
}

$ratingLabels = [];
$ratingData = [];
foreach ($ratingDistribution as $rating) {
    $ratingLabels[] = $rating['note'] . ' étoiles';
    $ratingData[] = $rating['total'];
}

$resourceMonthLabels = [];
$resourceMonthData = [];
foreach ($resourcesByMonth as $month) {
    $date = new DateTime($month['mois'] . '-01');
    $resourceMonthLabels[] = $date->format('M Y');
    $resourceMonthData[] = $month['total'];
}

$commentMonthLabels = [];
$commentMonthData = [];
foreach ($commentsByMonth as $month) {
    $date = new DateTime($month['mois'] . '-01');
    $commentMonthLabels[] = $date->format('M Y');
    $commentMonthData[] = $month['total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - Starzy</title>
    <link href="back-office/static/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #3b7ddd;
        }
        
        .stat-title {
            font-size: 1rem;
            color: #6c757d;
        }
        
        .chart-container {
            height: 300px;
            margin-bottom: 20px;
        }
        
        .top-list {
            list-style-type: none;
            padding: 0;
        }
        
        .top-list li {
            padding: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .top-list li:last-child {
            border-bottom: none;
        }
        
        .rating {
            font-weight: bold;
            color: #ffc107;
        }
        
        .comment-count {
            font-weight: bold;
            color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.html">
                    <span class="align-middle">Starzy</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header"></li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="liste.php">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Gestion des ressources</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="listeco.php">
                            <i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Gestion des Commentaires</span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="statistiques.php">
                            <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Statistiques</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href=" ">
                            <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Se déconnecter</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Statistiques</strong> Tableau de bord</h1>
                    
                    <!-- Statistiques générales -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-card text-center">
                                <div class="stat-number"><?php echo $totalResources; ?></div>
                                <div class="stat-title">Ressources totales</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-card text-center">
                                <div class="stat-number"><?php echo $totalComments; ?></div>
                                <div class="stat-title">Commentaires totaux</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-card text-center">
                                <div class="stat-number"><?php echo $averageRating; ?></div>
                                <div class="stat-title">Note moyenne globale</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Graphiques -->
                    <div class="row">
                        <!-- Graphique par catégorie -->
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Ressources par catégorie</h5>
                                <div class="chart-container">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Graphique par type -->
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Ressources par type</h5>
                                <div class="chart-container">
                                    <canvas id="typeChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Distribution des notes -->
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Distribution des notes</h5>
                                <div class="chart-container">
                                    <canvas id="ratingChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tendances -->
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Tendances mensuelles</h5>
                                <div class="chart-container">
                                    <canvas id="trendsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top Ressources -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Top 5 des ressources les mieux notées</h5>
                                <ul class="top-list">
                                    <?php foreach ($topRatedResources as $resource): ?>
                                    <li>
                                        <strong><?php echo $resource['titre']; ?></strong>
                                        <span class="float-end rating"><?php echo round($resource['moyenne'], 1); ?> / 5</span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="dashboard-card">
                                <h5>Top 5 des ressources les plus commentées</h5>
                                <ul class="top-list">
                                    <?php foreach ($mostCommentedResources as $resource): ?>
                                    <li>
                                        <strong><?php echo $resource['titre']; ?></strong>
                                        <span class="float-end comment-count"><?php echo $resource['nb_commentaires']; ?> commentaires</span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
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
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Starzy</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="#">Terms</a>
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
        // Initialisation des graphiques
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique par catégorie
            var categoryChart = new Chart(document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($categoryLabels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($categoryData); ?>,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'
                        ],
                        hoverBackgroundColor: [
                            '#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617', '#60616f'
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + ' ressources';
                                }
                            }
                        }
                    }
                }
            });
            
            // Graphique par type
            var typeChart = new Chart(document.getElementById('typeChart'), {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($typeLabels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($typeData); ?>,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                        ],
                        hoverBackgroundColor: [
                            '#2e59d9', '#17a673', '#2c9faf', '#dda20a'
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + ' ressources';
                                }
                            }
                        }
                    }
                }
            });
            
            // Graphique de distribution des notes
            var ratingChart = new Chart(document.getElementById('ratingChart'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($ratingLabels); ?>,
                    datasets: [{
                        label: 'Nombre de notes',
                        data: <?php echo json_encode($ratingData); ?>,
                        backgroundColor: '#ffc107',
                        borderColor: '#e0a800',
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
            
            // Graphique des tendances
            var trendsChart = new Chart(document.getElementById('trendsChart'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($resourceMonthLabels); ?>,
                    datasets: [
                        {
                            label: 'Ressources ajoutées',
                            data: <?php echo json_encode($resourceMonthData); ?>,
                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                            borderColor: 'rgba(78, 115, 223, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                            tension: 0.3
                        },
                        {
                            label: 'Commentaires ajoutés',
                            data: <?php echo json_encode($commentMonthData); ?>,
                            backgroundColor: 'rgba(28, 200, 138, 0.05)',
                            borderColor: 'rgba(28, 200, 138, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(28, 200, 138, 1)',
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html> 