
<?php
include_once("../controller/cmdcontroller.php");
include_once("../controller/fichiercontroller.php");
/*foreach ($produit as $prod) {
    // Utilisez ici $prod en toute sécurité
    echo $prod['nom']; // Exemple d'accès aux données du produit
}

if (isset($prod['nom'])) {
    echo $prod['nom'];
} else {
    echo "Nom du produit non défini";
}*/

$produit = new ProduitController();
$commandeController = new CommandeController();  // Assurez-vous que cette ligne est correcte

$list = $commandeController->getCommandes(); // Utilisation de la bonne variable ici

$id_client = 1; // Exemple temporaire
$date = date('Y-m-d');
$statut = 'en attente';
$adresse = 'adresse fictive';

if (isset($_GET['prod_id'])) {
    $id_produit = $_GET['prod_id'];
    $montant = 100; // À remplacer par le vrai prix du produit (tu peux faire une requête pour ça)
    
    // Préparer les données à insérer
    $nouvelleCommande = [
        'id_client' => $id_client,
        'id_produit' => $id_produit,
        'date' => $date,
        'statut' => $statut,
        'montant' => $montant,
        'adresse' => $adresse
    ];
    
    // Ajouter la commande
    $commandeController->addCommande($nouvelleCommande); } // Utilisation de la variable correcte ici
    if(isset($_GET['suppid']))
    {
        $commandeController->deleteCommande($_GET['suppid']);

        header("Location: panier.php");

    }




?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Votre Boutique</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color:, #8a3871;
            --primary-dark:, #8a3871;
            --dark-bg: #0f0e13;
            --card-bg: #1a1a24;
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            background-image: radial-gradient(circle at 10% 20%, rgba(138, 43, 226, 0.1) 0%, rgba(138, 43, 226, 0) 90%);
            min-height: 100vh;
        }
        
        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            background: linear-gradient(90deg, #8a2be2, #8a3871);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 4px 15px rgba(138, 43, 226, 0.3);
        }
        
        .cart-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s;
        }
        
        .cart-card:hover {
            transform: translateY(-5px);
        }
        
        .table-cart {
            color: var(--text-light);
            margin-bottom: 0;
        }
        
        .table-cart thead th {
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            background-color: rgba(138, 43, 226, 0.1);
        }
        
        .table-cart tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .table-cart tbody tr:last-child {
            border-bottom: none;
        }
        
        .table-cart tbody tr:hover {
            background-color: rgba(138, 43, 226, 0.05);
        }
        
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid rgba(138, 43, 226, 0.3);
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .quantity-btn:hover {
            background-color: var(--primary-dark);
            transform: scale(1.1);
        }
        
        .quantity-input {
            width: 50px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 5px;
        }
        
        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            margin: 0 3px;
        }
        
        .edit-btn {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        
        .edit-btn:hover {
            background-color: rgba(40, 167, 69, 0.4);
            color: white;
        }
        
        .delete-btn {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .delete-btn:hover {
            background-color: rgba(220, 53, 69, 0.4);
            color: white;
        }
        
        .summary-card {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.1), rgba(138, 43, 226, 0.05));
            border: 1px solid rgba(138, 43, 226, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
        }
        
        .checkout-btn {
            background: linear-gradient(135deg, var(--primary-color),#8a3871);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4);
        }
        
        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 43, 226, 0.6);
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 0;
        }
        
        .empty-cart-icon {
            font-size: 5rem;
            background: linear-gradient(135deg, var(--primary-color),#8a3871);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        
        .floating-cart-icon {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color),#8a3871);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(138, 43, 226, 0.6);
            z-index: 1000;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .floating-cart-icon:hover {
            transform: scale(1.1) rotate(15deg);
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        @media (max-width: 768px) {
            .product-img {
                width: 60px;
                height: 60px;
            }
            
            .table-cart td, .table-cart th {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(15, 14, 19, 0.9); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#" style="color: var(--primary-color);">
                <i class="fas fa-store me-2"></i>Boutique
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home me-1"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-box-open me-1"></i> Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-shopping-cart me-1"></i> Panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user me-1"></i> Compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="hero-title display-4 mb-3">
                    <i class="fas fa-shopping-basket me-3"></i>VOTRE PANIER
                </h1>
                <p class="text-muted">Revisez vos articles avant de finaliser votre commande</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="cart-card p-4 h-100">
                    <div class="table-responsive">
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 100px;">Image</th>
                                    <th scope="col">Produit</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
            foreach($list as $cmd)
            {   
                $prod=$produit->getProduitById($cmd['id_produit']);
                $imageBase64=base64_encode($prod['image']);
            ?>
                                <tr>
                                    <td>
                                        <img src="data:image/jpeg;base64,<?php echo $imageBase64; ?>" alt="Produit 1" class="product-img">
                                    </td>
                                    <td>
                                        <h6 class="mb-1"><?=$prod['nom']; ?></h6>
                                        <small class="text-muted">Réf: PROD-001</small>
                                    </td>
                                    <td>149,99 €</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <button class="quantity-btn decrease"><i class="fas fa-minus"></i></button>
                                            <input type="number" class="quantity-input mx-2" value="1" min="1">
                                            <button class="quantity-btn increase"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>149,99 €</td>
                                    <td>
                                        <button class="action-btn edit-btn" title="Modifier">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <a href="panier.php?suppid=<?=$cmd['id_commande']; ?>" class="action-btn delete-btn" name="supp" id="supp">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
            }
            ?>
                                
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="summary-card p-4 h-100">
                    <h5 class="mb-4 text-uppercase fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-receipt me-2"></i>Résumé de la commande
                    </h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total</span>
                        <span>389,96 €</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livraison</span>
                        <span>Gratuite</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Remise</span>
                        <span>-10,00 €</span>
                    </div>
                    
                    <hr class="my-3" style="border-color: rgba(138, 43, 226, 0.3);">
                    
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total TTC</strong>
                        <strong style="color: var(--primary-color); font-size: 1.2rem;">379,96 €</strong>
                    </div>
                    
                    <button class="checkout-btn btn w-100 mb-3">
                        <i class="fas fa-credit-card me-2"></i>Payer maintenant
                    </button>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">Ou continuer vos achats</small>
                        <a href="#" class="d-block mt-2" style="color: var(--primary-color);">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la boutique
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Cart Icon -->
    <div class="floating-cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <div class="cart-badge">3</div>
    </div>

    <!-- Footer -->
    <footer class="py-4 mt-5" style="background-color: rgba(15, 14, 19, 0.9);">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">© 2023 Votre Boutique. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Fonctionnalités du panier
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des quantités
            document.querySelectorAll('.quantity-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    let value = parseInt(input.value);
                    
                    if (this.classList.contains('decrease') && value > 1) {
                        input.value = value - 1;
                    } else if (this.classList.contains('increase')) {
                        input.value = value + 1;
                    }
                    
                    updateCart();
                });
            });
            
            // Gestion de la suppression
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    row.style.transition = 'all 0.3s';
                    row.style.opacity = '0';
                    
                    setTimeout(() => {
                        row.remove();
                        updateCart();
                        showToast('Produit supprimé du panier', 'danger');
                    }, 300);
                });
            });
            
            // Gestion de la modification
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const productName = row.querySelector('h6').textContent;
                    showToast(`Modification de ${productName}`, 'info');
                });
            });
            
            // Bouton de paiement
            document.querySelector('.checkout-btn').addEventListener('click', function() {
                showToast('Redirection vers le paiement', 'success');
                // Ici vous pourriez rediriger vers la page de paiement
            });
            
            // Fonction pour mettre à jour le panier
            function updateCart() {
                // Calculer le nouveau total, etc.
                console.log('Panier mis à jour');
                // Ici vous pourriez ajouter une requête AJAX pour mettre à jour le panier côté serveur
            }
            
            // Fonction pour afficher des notifications
            function showToast(message, type) {
                // Créer un toast Bootstrap (vous pourriez implémenter cela)
                console.log(`${type.toUpperCase()}: ${message}`);
            }
        });
    </script>
</body>
</html>