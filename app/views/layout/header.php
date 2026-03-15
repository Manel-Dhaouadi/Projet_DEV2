<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LinkedIn - Plateforme d'emploi</title>
    
    <!-- Chemin CSS corrigé -->
    <link rel="stylesheet" href="/Projet_DEV2/public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php
    // Démarrer la session si pas déjà fait
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <a href="/Projet_DEV2/public/?action=home">LinkedIn</a>
        </div>
        
        <div class="nav-links">
            <a href="/Projet_DEV2/public/?action=home">Accueil</a>
            <a href="/Projet_DEV2/public/?action=jobs">Offres</a>
            
            <?php if(isset($_SESSION['user'])): ?>
                <a href="/Projet_DEV2/public/?action=dashboard">Dashboard</a>
                <a href="/Projet_DEV2/public/?action=logout">Déconnexion</a>
            <?php else: ?>
                <a href="/Projet_DEV2/public/?action=login">Connexion</a>
                <a href="/Projet_DEV2/public/?action=register">Inscription</a>
            <?php endif; ?>
        </div>
    </nav>
    
    <main>