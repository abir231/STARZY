<?php
   require_once('../config.php'); 
   require_once('../controller/fichiercontroller.php');
   
   
   
   $testmodif=false;
   $produitController = new ProduitController();
   
   $product = "";
   if(isset($_GET['id']))
   {
      $product = $produitController->getProduitById($_GET['id']);
      $testmodif=true;
   }
   // Si le formulaire est soumis pour ajouter un produit
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajout']) && $_POST['testmodif']==false) {
       if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
           // Récupération de l'image
           $imageData = file_get_contents($_FILES["img"]["tmp_name"]);
   
           // Création du produit
           $produitController = new ProduitController();
           $pr = new Produit(
               null,
               $imageData,
               $_POST['prix'],
               $_POST['description'],
               $_POST['cat'],
               $_POST['disp'],
               $_POST['nom']
           );
           // Ajouter le produit
           $produitController->addProduit($pr);
           header("Location: indiv.php");
           echo "Produit ajouté avec succès!";
       } else {
           echo "Erreur lors de l'envoi de l'image.";
       }
   }
   
   // Si l'ID du produit est passé pour la modification
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ajout']) && $_POST['testmodif']==true) {
       // Vérifier si l'ID est présent dans le formulaire pour savoir si c'est une modification
       $id = $_POST['id'];
   
       // Récupérer le produit actuel pour s'assurer que l'image actuelle est utilisée si aucune nouvelle image n'est téléchargée
       $produitController = new ProduitController();
       $produit = $produitController->getProduitById($id);
   
       // Si une nouvelle image est envoyée, la récupérer
       if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
           $imageData = file_get_contents($_FILES["img"]["tmp_name"]);
       } else {
           // Garder l'ancienne image si aucune nouvelle image n'est envoyée
           $imageData = $produit['image'];
       }
   
       // Créer une instance du produit à modifier
       $produitUpdated = new Produit(
           $id,
           $imageData,
           $_POST['prix'],
           $_POST['description'],
           $_POST['cat'],
           $_POST['disp'],
           $_POST['nom']
       );
   
       // Appeler la méthode de mise à jour dans le contrôleur
       $produitController->updateProduit($produitUpdated);
   
       // Rediriger ou afficher un message de succès
       echo "Produit mis à jour avec succès!";
       // Redirection vers la liste des produits après la mise à jour
       header("Location: indiv.php");
       exit();
   }
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <style>
         .sidebar-link {
         background: linear-gradient(to right, #0f0c29, #1a237e) !important;
         color: white !important;
         display: block;
         padding: 10px 15px;
         text-decoration: none;
         border-radius: 5px;
         margin-bottom: 5px; /* un petit espace entre les liens */
         transition: background 0.3s ease;
         .sidebar-link i {
         color: white !important;
         margin-right: 8px;
         }
         }
         /* Style au survol */
         .sidebar-link:hover {
         background: linear-gradient(to right, #1a237e, #0f0c29) !important;
         color:rgb(151, 21, 90) !important; /* une touche dorée à la survol ? */
         transform: scale(1.02);
         }
      </style>
      <style> .sidebar-header {
         background: linear-gradient(to right, #0f0c29, #1a237e) !important;
         color: white !important;
         padding: 10px 15px; /* un peu d’espace pour l’esthétique */
         font-weight: bold;
         font-size: 16px;
         border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* ligne légère de séparation */
         }
      </style>
      <style> .sidebar-div {
         background: linear-gradient(to right, #0f0c29, #1a237e) !important;
         color: white !important;
         padding: 10px; /* optionnel pour l’espace intérieur */
         border-radius: 5px; /* optionnel pour adoucir les coins */
         }
         /* Pour les éléments à l’intérieur */
         .sidebar-div a {
         color: white !important;
         }
         .sidebar-div i {
         color: white !important;
         }
         .sidebar-div a:hover {
         background-color: rgba(255, 255, 255, 0.1); /* hover effet doux */
         border-radius: 4px;
         }
      </style>
      <style>
         .simplebar-content-wrapper {
         background: linear-gradient(to right, #0f0c29, #1a237e) !important;
         color: white !important;
         }
         /* Facultatif : rendre le texte/lien lisible */
         .simplebar-content-wrapper a {
         color: white !important;
         }
         .simplebar-content-wrapper i {
         color: white !important;
         }
      </style>
      <style>
         .cosmic-brand {
         display: flex;
         align-items: center;
         height: 60px;
         overflow: hidden;
         }
         .cosmic-logo {
         height: 40px;
         width: auto;
         object-fit: contain;
         }
      </style>
      <style>
         .icon.nalika-like:before {
         content: "\f12e"; /* Code FA pour puzzle-piece */
         font-family: 'Font Awesome 6 Free';
         font-weight: 900;
         color:rgb(240, 240, 240);
         font-size: 14px;
         }
      </style>
      <style>
         .icon.nalika-favorites:before {
         content: "\f03e"; /* Code FA pour image */
         font-family: 'Font Awesome 6 Free';
         font-weight: 900;
         color: #4a5568;
         }
      </style>
      <style>
         .icon.nalika-favorites-button:before {
         content: "\f15c"; /* Code FA pour file-alt */
         font-family: 'Font Awesome 6 Free';
         font-weight: 900;
         color: #5a6268;
         }
      </style>
      <style>
         .icon.nalika-favorites-button:before {
         content: "\f036"; /* Code FA pour align-left */
         font-family: 'Font Awesome 6 Free';
         font-weight: 900;
         color: #6c757d;
         }
      </style>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      <!-- Cosmic Navigation Bar -->
      <div class="cosmic-nav-container ">
         <div class="cosmic-navbar ">
            <!-- Brand Logo with Astronomy Theme -->
            <div class="cosmic-brand">
               <img src="logo.png" alt="Logo STARZY" class="cosmic-logo" style="height: 200px; width: auto;">
               <span class="cosmic-title">STARZY</span>
            </div>
            <!-- Navigation Elements -->
            <div class="cosmic-nav-elements">
               <!-- Search (Telescope) -->
               <div class="cosmic-search-box">
                  <i class="fas fa-telescope cosmic-search-icon"></i>
                  <input type="text" class="cosmic-search-input" placeholder="Search the cosmos...">
               </div>
               <!-- Messages (Satellite) -->
               <div class="cosmic-nav-item">
                  <div class="cosmic-icon-container">
                     <i class="fas fa-satellite-dish cosmic-icon" style="color: #4fc3f7;"></i>
                     <span class="cosmic-notification-badge pulse">3</span>
                  </div>
                  <span class="cosmic-label">Messages</span>
               </div>
               <!-- Notifications (Supernova) -->
               <div class="cosmic-nav-item">
                  <div class="cosmic-icon-container">
                     <i class="fas fa-meteor cosmic-icon" style="color: #ff6d00;"></i>
                     <span class="cosmic-notification-badge blink">5</span>
                  </div>
                  <span class="cosmic-label">Alerts</span>
               </div>
               <!-- User Profile (Astronaut) -->
               <div class="cosmic-nav-item cosmic-profile">
                  <div class="cosmic-icon-container">
                     <i class="fas fa-user-astronaut cosmic-icon" style="color: #b388ff;"></i>
                  </div>
                  <span class="cosmic-label">Mission Control</span>
               </div>
            </div>
         </div>
      </div>
      <style>
         /* Cosmic Navigation Styles */
         .cosmic-nav-container {
          position: fixed; 
         background: linear-gradient(135deg, #0f0c29 0%, #1a237e 100%);
         padding: 0 2rem;
         padding-left: 20%;
         width: 100%;
         z-index: 1000;
         
        
         box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
         }
         .cosmic-navbar {

         display: flex;
         justify-content: space-between;
         align-items: center;
         max-width: 1400px;
         margin: 0 auto;
         padding: 1rem 0;
         }
         .cosmic-brand {
         display: flex;
         align-items: center;
         gap: 12px;
         }
         .cosmic-logo {
         font-size: 2rem;
         filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.6));
         animation: twinkle 3s infinite alternate;
         }
         .cosmic-title {
         color: white;
         font-size: 1.8rem;
         font-weight: 700;
         letter-spacing: 1px;
         text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
         }
         .cosmic-nav-elements {
         display: flex;
         align-items: center;
         gap: 2rem;
         }
         /* Search Box */
         .cosmic-search-box {
         position: relative;
         margin-right: 1rem;
         }
         .cosmic-search-icon {
         position: absolute;
         left: 15px;
         top: 50%;
         transform: translateY(-50%);
         color: rgba(255, 255, 255, 0.7);
         font-size: 1.1rem;
         }
         .cosmic-search-input {
         background: rgba(0, 0, 0, 0.3);
         border: 1px solid rgba(255, 255, 255, 0.1);
         color: white;
         padding: 0.8rem 1rem 0.8rem 3rem;
         border-radius: 30px;
         width: 250px;
         transition: all 0.3s ease;
         font-size: 0.95rem;
         }
         .cosmic-search-input:focus {
         outline: none;
         border-color: #4fc3f7;
         box-shadow: 0 0 0 2px rgba(79, 195, 247, 0.3);
         width: 300px;
         }
         /* Navigation Items */
         .cosmic-nav-item {
         display: flex;
         flex-direction: column;
         align-items: center;
         cursor: pointer;
         position: relative;
         padding: 0.5rem 0;
         }
         .cosmic-icon-container {
         position: relative;
         display: flex;
         align-items: center;
         justify-content: center;
         }
         .cosmic-icon {
         font-size: 1.4rem;
         transition: all 0.3s ease;
         }
         .cosmic-nav-item:hover .cosmic-icon {
         transform: scale(1.2);
         filter: drop-shadow(0 0 8px currentColor);
         }
         .cosmic-label {
         color: rgba(255, 255, 255, 0.8);
         font-size: 0.8rem;
         margin-top: 0.3rem;
         opacity: 0;
         transition: opacity 0.3s ease;
         }
         .cosmic-nav-item:hover .cosmic-label {
         opacity: 1;
         }
         /* Notification Badges */
         .cosmic-notification-badge {
         position: absolute;
         top: -5px;
         right: -5px;
         background: #FFD700;
         color: #0f0c29;
         width: 18px;
         height: 18px;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 0.7rem;
         font-weight: bold;
         }
         /* Animations */
         @keyframes twinkle {
         0% { opacity: 0.8; }
         100% { opacity: 1; }
         }
         @keyframes pulse {
         0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 215, 0, 0.7); }
         70% { transform: scale(1.1); box-shadow: 0 0 0 8px rgba(255, 215, 0, 0); }
         100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 215, 0, 0); }
         }
         @keyframes blink {
         0% { opacity: 1; }
         50% { opacity: 0.5; }
         100% { opacity: 1; }
         }
         /* Responsive Design */
         @media (max-width: 992px) {
         .cosmic-nav-elements {
         gap: 1.5rem;
         }
         .cosmic-search-input {
         width: 200px;
         }
         .cosmic-search-input:focus {
         width: 250px;
         }
         }
         @media (max-width: 768px) {
         .cosmic-navbar {
         flex-direction: column;
         padding: 1rem;
         }
         .cosmic-brand {
         margin-bottom: 1rem;
         }
         .cosmic-search-box {
         margin: 0 0 1rem 0;
         }
         .cosmic-nav-elements {
         flex-wrap: wrap;
         justify-content: center;
         }
         .cosmic-label {
         display: none;
         }
         }
      </style>
      <div class="wrapper">
         <div id="sidebar2" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
               <a class="sidebar-brand" href="index.html">
               <span class="align-middle"></span>
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
      </div>
      <div class="main">
         <main class="content">
            <div class="all-content-wrapper">
               <!-- Mobile Menu end -->
               <div class="breadcome-area">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                           <div class="breadcome-list cosmic-breadcrumb">
                              <div class="row">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="breadcomb-wp">
                                       <div class="breadcomb-icon">
                                          <i class="fas fa-home cosmic-icon"></i>
                                       </div>
                                       <div class="breadcomb-ctn">
                                          <h2 style="color: white;">Product Edit</h2>
                                          <p style="color: rgba(255,255,255,0.8);">Welcome ABIR <span class="bread-ntd"></span></p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="breadcomb-report">
                                       <button data-toggle="tooltip" data-placement="left" title="Download Report" class="btn cosmic-download-btn">
                                       <i class="fas fa-download cosmic-icon"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <style>
                           /* Style du breadcrumb cosmique */
                           .cosmic-breadcrumb {
                           background: linear-gradient(135deg, #0f0c29 0%, #1a237e 100%);
                           padding: 15px 20px;
                           border-radius: 8px;
                           box-shadow: 0 4px 15px rgba(0,0,0,0.3);
                           margin-bottom: 20px;
                           margin-top:70px;
                           }
                           .cosmic-icon {
                           color: #4fc3f7;
                           font-size: 1.2rem;
                           }
                           .cosmic-download-btn {
                           background: rgba(255,255,255,0.1);
                           border: 1px solid rgba(255,255,255,0.2);
                           color: white;
                           padding: 8px 12px;
                           border-radius: 50%;
                           transition: all 0.3s ease;
                           }
                           .cosmic-download-btn:hover {
                           background: rgba(255,255,255,0.2);
                           transform: translateY(-2px);
                           box-shadow: 0 4px 8px rgba(0,0,0,0.2);
                           }
                           .breadcomb-wp {
                           display: flex;
                           align-items: center;
                           gap: 10px;
                           }
                           .breadcomb-icon {
                           padding: 8px;
                           background: rgba(255,255,255,0.1);
                           border-radius: 50%;
                           display: flex;
                           align-items: center;
                           justify-content: center;
                           width: 36px;
                           height: 36px;
                           }
                        </style>
                     </div>
                  </div>
               </div>
               <!-- Single pro tab start-->
               <div class="single-product-tab-area mg-b-30">
                  <!-- Single pro tab review Start-->
                  <div class="single-pro-review-area">
                     <div class="container-fluid">
                        <div class="row">
                           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="review-tab-pro-inner">
                                 <ul id="myTab3" class="tab-review-design">
                                    <li class="active"><a href="#description"><i class="icon nalika-edit" aria-hidden="true"></i> Product Edit</a></li>
                                    <li><a href="#reviews"><i class="icon nalika-picture" aria-hidden="true"></i> Pictures</a></li>
                                    <li><a href="#INFORMATION"><i class="icon nalika-chat" aria-hidden="true"></i> Review</a></li>
                                 </ul>
                                 <form action="edit.php" method="post" enctype="multipart/form-data">
                                    <?php if($testmodif){ ?>
                                    <input type="hidden" name="id" id="id"  value="<?= htmlspecialchars($product['ID']) ?>">
                                    <?php }?> 
                                    <input type="hidden" name="testmodif" id="testmodif" value="<?= $testmodif; ?>">
                                    <div id="myTabContent" class="tab-content custom-product-edit">
                                       <div class="product-tab-list tab-pane fade active in" id="description">
                                          <div class="row">
                                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                   <div class="input-group mg-b-pro-edt">
                                                      <span class="input-group-addon">
                                                      <i class="fas fa-tag" aria-hidden="true"></i> 
                                                      </span>
                                                      <?php if($testmodif){ ?>
                                                      <input type="text" class="form-control" name="nom" value="<?= isset($product['nom']) && !empty($product['nom']) ? htmlspecialchars($product['nom']) : '' ?>">
                                                      <?php }else{?>
                                                      <input type="text" class="form-control" name="nom" placeholder=" nom">
                                                      <?php }?> 
                                                   </div>
                                                   <div class="input-group mg-b-pro-edt">
                                                      <span class="input-group-addon"><i class="fa fa-usd" aria-hidden="true"></i></span>
                                                      <?php if($testmodif){ ?>
                                                      <input type="text" class="form-control" placeholder=" Price" name="prix" value="<?= htmlspecialchars($product['prix']) ?>">
                                                      <?php }else{?>
                                                      <input type="text" class="form-control" name="prix" placeholder=" prix">
                                                      <?php }?>    
                                                   </div>
                                                   <!-- Champ Image -->
                                                   <div class="input-group mg-b-pro-edt" id="img-container">
                                                      <span class="input-group-addon">
                                                      <i class="fas fa-image" aria-hidden="true"></i>
                                                      </span>
                                                      <div class="form-control input-group">
                                                         <input type="file" class="form-control-file" accept="image/*" name="img" id="img-upload">
                                                         <small class="text-muted">Formats acceptés: JPEG, PNG, GIF (Max 2MB)</small>
                                                      </div> 
                                                     
                                                     
                                                   </div>
                                                   <br>
                                                   <div id="imgerror" class="error-message"></div>
                                                </div>
                                             </div>
                                             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="review-content-section">
                                                   <div class="input-group mg-b-pro-edt">
                                                      <span class="input-group-addon">
                                                      <i class="fas fa-align-left" aria-hidden="true"></i>
                                                      </span>
                                                      <?php if($testmodif){ ?>
                                                      <input type="text" class="form-control" placeholder="Product Description" name="description" value="<?= htmlspecialchars($product['description']) ?>">
                                                      <?php }else{?>
                                                      <input type="text" class="form-control" name="description" placeholder=" description">
                                                      <?php }?>    
                                                   </div>
                                                   <div id="descerror" class="error-message"></div>
                                                   <div class="input-group mg-b-pro-edt">
                                                      <span class="input-group-addon">
                                                      <i class="fas fa-file-alt" aria-hidden="true"></i>
                                                      </span>
                                                      <div class="form-control input-group" style="padding: 10px; display: flex; align-items: center;">
                                                         <span style="margin-right: 10px; font-weight: bold;">Disponibilité :</span>
                                                         <!-- Mode édition -->
                                                         <?php if($testmodif): ?>
                                                         <label style="margin-right: 15px;">
                                                         <input type="radio" name="disp" value="oui" <?= ($product['disponibite'] === 'oui') ? 'checked' : '' ?>> Oui
                                                         </label>
                                                         <label>
                                                         <input type="radio" name="disp" value="non" <?= ($product['disponibite'] === 'non') ? 'checked' : '' ?>> Non
                                                         </label>
                                                         <!-- Mode création -->
                                                         <?php else: ?>
                                                         <label style="margin-right: 15px;">
                                                         <input type="radio" name="disp" value="oui" checked> Oui
                                                         </label>
                                                         <label>
                                                         <input type="radio" name="disp" value="non"> Non
                                                         </label>
                                                         <?php endif; ?>
                                                      </div>
                                                   </div>
                                                   <div class="input-group mg-b-pro-edt">
                                                      <span class="input-group-addon">
                                                      <i class="fas fa-puzzle-piece" style="color:rgb(228, 231, 236);"></i>
                                                      </span>    
                                                      <select class="form-control" name="cat" id="cat-select">
                                                         <option value="" disabled selected>-- Sélectionnez une catégorie --</option>
                                                         <option value="enfant" <?= (isset($product['categorie']) && $product['categorie'] === 'enfant') ? 'selected' : '' ?>>Enfant</option>
                                                         <option value="etudiants" <?= (isset($product['categorie']) && $product['categorie'] === 'etudiants') ? 'selected' : '' ?>>Étudiants</option>
                                                         <option value="chercheurs" <?= (isset($product['categorie']) && $product['categorie'] === 'chercheurs') ? 'selected' : '' ?>>Chercheurs</option>
                                                         <option value="universitaire" <?= (isset($product['categorie']) && $product['categorie'] === 'universitaire') ? 'selected' : '' ?>>Universitaires</option>
                                                      </select>
                                                      <div class="invalid-feedback" id="cat-error"></div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                   <div class="text-center custom-pro-edt-ds">
                                                      <button type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" name="ajout">Save
                                                      </button>
                                                      <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Discard
                                                      </button>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                 <div class="product-tab-list tab-pane fade" id="reviews">
                                    <div class="row">
                                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                          <div class="review-content-section">
                                             <div class="row">
                                                <div class="col-lg-4">
                                                   <div class="pro-edt-img">
                                                      <img src="img/new-product/5-small.jpg" alt="" />
                                                   </div>
                                                </div>
                                                <div class="col-lg-8">
                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="product-edt-pix-wrap">
                                                            <div class="input-group">
                                                               <span class="input-group-addon">TT</span>
                                                               <input type="text" class="form-control" placeholder="Label Name">
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-lg-6">
                                                                  <div class="form-radio">
                                                                     <form>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Largest Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Medium Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Small Image
                                                                           </label>
                                                                        </div>
                                                                     </form>
                                                                  </div>
                                                               </div>
                                                               <div class="col-lg-6">
                                                                  <div class="product-edt-remove">
                                                                     <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Remove
                                                                     <i class="fa fa-times" aria-hidden="true"></i>
                                                                     </button>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-lg-4">
                                                   <div class="pro-edt-img">
                                                      <img src="img/new-product/6-small.jpg" alt="" />
                                                   </div>
                                                </div>
                                                <div class="col-lg-8">
                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="product-edt-pix-wrap">
                                                            <div class="input-group">
                                                               <span class="input-group-addon">TT</span>
                                                               <input type="text" class="form-control" placeholder="Label Name">
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-lg-6">
                                                                  <div class="form-radio">
                                                                     <form>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Largest Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Medium Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Small Image
                                                                           </label>
                                                                        </div>
                                                                     </form>
                                                                  </div>
                                                               </div>
                                                               <div class="col-lg-6">
                                                                  <div class="product-edt-remove">
                                                                     <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Remove
                                                                     <i class="fa fa-times" aria-hidden="true"></i>
                                                                     </button>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-lg-4">
                                                   <div class="pro-edt-img mg-b-0">
                                                      <img src="img/new-product/7-small.jpg" alt="" />
                                                   </div>
                                                </div>
                                                <div class="col-lg-8">
                                                   <div class="row">
                                                      <div class="col-lg-12">
                                                         <div class="product-edt-pix-wrap">
                                                            <div class="input-group">
                                                               <span class="input-group-addon">TT</span>
                                                               <input type="text" class="form-control" placeholder="Label Name">
                                                            </div>
                                                            <div class="row">
                                                               <div class="col-lg-6">
                                                                  <div class="form-radio">
                                                                     <form>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Largest Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Medium Image
                                                                           </label>
                                                                        </div>
                                                                        <div class="radio radiofill">
                                                                           <label>
                                                                           <input type="radio" name="radio"><i class="helper"></i>Small Image
                                                                           </label>
                                                                        </div>
                                                                     </form>
                                                                  </div>
                                                               </div>
                                                               <div class="col-lg-6">
                                                                  <div class="product-edt-remove">
                                                                     <button type="button" class="btn btn-ctl-bt waves-effect waves-light">Remove
                                                                     <i class="fa fa-times" aria-hidden="true"></i>
                                                                     </button>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="product-tab-list tab-pane fade" id="INFORMATION">
                                    <div class="row">
                                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                          <div class="review-content-section">
                                             <div class="card-block">
                                                <div class="text-muted f-w-400">
                                                   <p>No reviews yet.</p>
                                                </div>
                                                <div class="m-t-10">
                                                   <div class="txt-primary f-18 f-w-600">
                                                      <p>Your Rating</p>
                                                   </div>
                                                   <div class="stars stars-example-css detail-stars">
                                                      <div class="review-rating">
                                                         <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5">
                                                            <label class="full" for="star5"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half">
                                                            <label class="half" for="star4half"></label>
                                                            <input type="radio" id="star4" name="rating" value="4">
                                                            <label class="full" for="star4"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half">
                                                            <label class="half" for="star3half"></label>
                                                            <input type="radio" id="star3" name="rating" value="3">
                                                            <label class="full" for="star3"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half">
                                                            <label class="half" for="star2half"></label>
                                                            <input type="radio" id="star2" name="rating" value="2">
                                                            <label class="full" for="star2"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half">
                                                            <label class="half" for="star1half"></label>
                                                            <input type="radio" id="star1" name="rating" value="1">
                                                            <label class="full" for="star1"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half">
                                                            <label class="half" for="starhalf"></label>
                                                         </fieldset>
                                                      </div>
                                                      <div class="clear"></div>
                                                   </div>
                                                </div>
                                                <div class="input-group mg-b-15 mg-t-15">
                                                   <span class="input-group-addon"><i class="icon nalika-user" aria-hidden="true"></i></span>
                                                   <input type="text" class="form-control" placeholder="User Name">
                                                </div>
                                                <div class="input-group mg-b-15">
                                                   <span class="input-group-addon"><i class="icon nalika-mail" aria-hidden="true"></i></span>
                                                   <input type="text" class="form-control" placeholder="Email">
                                                </div>
                                                <div class="form-group review-pro-edt mg-b-0-pt">
                                                   <button type="submit" class="btn btn-ctl-bt waves-effect waves-light">Submit
                                                   </button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
      </main>
      </div>
      <footer class="footer">
         <div class="container-fluid">
            <div class="row text-muted">
               <div class="col-6 text-start">
                  <p class="mb-0">
                     <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>STARZY</strong></a> &copy;
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
      <script src="js/app.js"></script>
      <script>
         document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Validation du NOM
                const nomInput = form.querySelector('input[name="nom"]');
                if (nomInput.value.trim() === '') {
                    showError(nomInput, 'Le nom ne peut pas être vide');
                    isValid = false;
                } else if (/\d/.test(nomInput.value)) {
                    showError(nomInput, 'Le nom ne doit pas contenir de chiffres');
                    isValid = false;
                } else {
                    clearError(nomInput);
                }
                
                // Validation du PRIX
                const prixInput = form.querySelector('input[name="prix"]');
                if (prixInput.value.trim() === '') {
                    showError(prixInput, 'Le prix est obligatoire');
                    isValid = false;
                } else if (isNaN(prixInput.value) || parseFloat(prixInput.value) <= 0) {
                    showError(prixInput, 'Le prix doit être un nombre positif');
                    isValid = false;
                } else {
                    clearError(prixInput);
                }
                
                // Validation DESCRIPTION
                const descInput = form.querySelector('input[name="description"]');
               if (descInput.value.trim() === '') {
                    showError(descInput, 'La description est obligatoire');
                    document.getElementById("descerror").innerText = "La description est obligatoire.";
                    isValid = false;
                }  else {
                    clearError(descInput);
                }
         
                
                
                // Validation DISPONIBILITÉ (Oui/Non)
                const dispRadios = form.querySelectorAll('input[name="disp"]');
                const dispContainer = dispRadios[0]?.closest('.input-group');
                let isDispSelected = Array.from(dispRadios).some(radio => radio.checked);
                
                if (!isDispSelected && dispContainer) {
                    showError(dispContainer, 'Veuillez sélectionner une option de disponibilité');
                    isValid = false;
                } else if (dispContainer) {
                    clearError(dispContainer);
                }
                
                // Validation CATÉGORIE
                const catSelect = form.querySelector('select[name="cat"]');
                const catContainer = catSelect?.closest('.input-group');
                if (catSelect && !catSelect.value) {
                    showError(catContainer || catSelect, 'Veuillez sélectionner une catégorie');
                    isValid = false;
                } else if (catContainer) {
                    clearError(catContainer);
                }


               const fileInput = document.getElementById('img-upload');

               if (fileInput.files.length === 0) {
                  document.getElementById("imgerror").innerText = "L image n est pas valide";

                 // console.log("Aucun fichier sélectionné.");
                  // Tu peux afficher une erreur ici :
                  // document.getElementById("imageerror").innerText = "Veuillez sélectionner une image.";
               } else {
                  console.log("Fichier sélectionné :", fileInput.files[0].name);
               }

                
                // Validation IMAGE (uniquement pour nouveaux produits)
               /* const testmodifInput = form.querySelector('input[name="testmodif"]');
                const imgInput = form.querySelector('input[name="img"]');
                const imgContainer = imgInput?.closest('.input-group');
                
                if (testmodifInput?.value === 'false') {
                    if (!imgInput.files || imgInput.files.length === 0) {
                        showError(imgContainer || imgInput, 'Aucun fichier sélectionné');
                        isValid = false;
                    } else {
                        const file = imgInput.files[0];
                        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        
                        if (!validTypes.includes(file.type)) {
                            showError(imgContainer || imgInput, 'Seuls les formats JPEG, PNG et GIF sont acceptés');
                            isValid = false;
                        } else {
                            clearError(imgContainer || imgInput);
                        }
                    }
                }*/
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Faire défiler jusqu'au premier champ invalide
                    const firstError = form.querySelector('.error-message');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
            
            // Fonctions utilitaires
            function showError(element, message) {
                if (!element) return;
                
                clearError(element);
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.style.color = 'red';
                errorDiv.style.fontSize = '0.8em';
                errorDiv.style.marginTop = '5px';
                errorDiv.textContent = message;
                
                if (element.classList.contains('input-group')) {
                    element.appendChild(errorDiv);
                    element.style.border = '1px solid red';
                } else {
                    element.parentNode.insertBefore(errorDiv, element.nextSibling);
                    element.style.borderColor = 'red';
                }
            }
            
            function clearError(element) {
                if (!element) return;
                
                const errorDiv = element.querySelector('.error-message') || 
                                element.parentNode.querySelector('.error-message');
                if (errorDiv) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
                
                if (element.classList.contains('input-group')) {
                    element.style.border = '';
                } else {
                    element.style.borderColor = '';
                }
            }
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