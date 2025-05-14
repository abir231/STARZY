<?php
// Inclusion des classes nécessaires
require_once('C:\xampp\htdocs\integration\controller\ressourceC.php');
require_once('C:\xampp\htdocs\integration\controller\commentaireC.php');

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
    <title>STARZY - Statistiques</title>
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #0f0c29;
            --secondary-color: #1a237e;
            --accent-color: rgb(207, 144, 165);
            --text-light: #ffffff;
            --card-bg: rgba(15, 12, 41, 0.95);
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
            background: var(--card-bg);
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

        .dashboard-card {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--accent-color);
        }

        .stat-title {
            font-size: 1rem;
            color: var(--text-light);
            opacity: 0.8;
        }

        .chart-container {
            height: 300px;
            margin-bottom: 20px;
            position: relative;
        }

        .top-list {
            list-style-type: none;
            padding: 0;
        }

        .top-list li {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            color: var(--accent-color);
        }

        h5 {
            color: var(--text-light);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Footer Styles */
        .footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .footer a {
            color: var(--text-light);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .footer a:hover {
            opacity: 1;
        }

        /* Chart Customization */
        canvas {
            background: transparent !important;
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
                <a href="listeco.php" class="sidebar-link">
                    <i class="fa fa-comments"></i> Commentaires
                </a>
                <a href="statistiques.php" class="sidebar-link active">
                    <i class="fa fa-bar-chart"></i> Statistiques
                </a>
            </div>
        </nav>

        <div class="main">
            <div class="container-fluid p-0">
                <h1 class="h3 mb-3">Tableau de bord statistiques</h1>
                
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
                            <div class="stat-number"><?php echo number_format($averageRating, 1); ?></div>
                            <div class="stat-title">Note moyenne globale</div>
                        </div>
                    </div>
                </div>
                
                <!-- Graphiques -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <h5>Ressources par catégorie</h5>
                            <div class="chart-container">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <h5>Ressources par type</h5>
                            <div class="chart-container">
                                <canvas id="typeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="dashboard-card">
                            <h5>Distribution des notes</h5>
                            <div class="chart-container">
                                <canvas id="ratingChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
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
                                    <strong><?php echo htmlspecialchars($resource['titre']); ?></strong>
                                    <span class="rating"><?php echo number_format($resource['moyenne'], 1); ?> <i class="fa fa-star"></i></span>
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
                                    <strong><?php echo htmlspecialchars($resource['titre']); ?></strong>
                                    <span class="comment-count"><?php echo $resource['nb_commentaires']; ?> <i class="fa fa-comments"></i></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
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
                                    <a href="#">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">Centre d'aide</a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#">Confidentialité</a>
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
        // Configuration des couleurs pour les graphiques
        const chartColors = {
            background: [
                'rgba(207, 144, 165, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
            ],
            border: [
                'rgba(207, 144, 165, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ]
        };

        // Configuration globale de Chart.js
        Chart.defaults.color = '#ffffff';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';

        document.addEventListener('DOMContentLoaded', function() {
            // Graphique par catégorie
            new Chart(document.getElementById('categoryChart'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($categoryLabels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($categoryData); ?>,
                        backgroundColor: chartColors.background,
                        borderColor: chartColors.border,
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
            
            // Graphique par type
            new Chart(document.getElementById('typeChart'), {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($typeLabels); ?>,
                    datasets: [{
                        data: <?php echo json_encode($typeData); ?>,
                        backgroundColor: chartColors.background,
                        borderColor: chartColors.border,
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
            
            // Graphique de distribution des notes
            new Chart(document.getElementById('ratingChart'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($ratingLabels); ?>,
                    datasets: [{
                        label: 'Nombre de notes',
                        data: <?php echo json_encode($ratingData); ?>,
                        backgroundColor: 'rgba(207, 144, 165, 0.8)',
                        borderColor: 'rgba(207, 144, 165, 1)',
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
                                color: '#ffffff',
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                color: '#ffffff'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
            
            // Graphique des tendances
            new Chart(document.getElementById('trendsChart'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($resourceMonthLabels); ?>,
                    datasets: [
                        {
                            label: 'Ressources ajoutées',
                            data: <?php echo json_encode($resourceMonthData); ?>,
                            borderColor: 'rgba(207, 144, 165, 1)',
                            backgroundColor: 'rgba(207, 144, 165, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Commentaires ajoutés',
                            data: <?php echo json_encode($commentMonthData); ?>,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
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
                                color: '#ffffff',
                                precision: 0
                            }
                        },
                        x: {
                            ticks: {
                                color: '#ffffff'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html> 