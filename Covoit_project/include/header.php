<?php 
include('./config/COphp.php'); 
if(session_status() === PHP_SESSION_NONE){
  session_start(); 
}

$admins = array("eddy.haye","quentin.molin");

// Récupérer le nom de la page actuelle
$page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <nav role="navigation" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="index.php" class="navbar-brand" style="background:#fff"><img src="./img/apei-logo.gif" style="width: 90%; margin-top:-7%;"></a>
                <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="nav navbar-nav">
                    <li <?php if($page == 'index.php') echo 'class="active"'; ?>><a href="index.php">Rechercher</a></li>
                    <li <?php if($page == 'trajets.php') echo 'class="active"'; ?>><a href="trajets.php">Covoiturages disponibles</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(isset($_SESSION['logged']) && isset($_SESSION['id'])):?>
                        <li <?php if($page == 'profile.php') echo 'class="active"'; ?>><a href="profile.php" title="profile"><?php echo isset($_SESSION['nom']) && isset($_SESSION['prenom']) ? $_SESSION['nom'] . ' ' . $_SESSION['prenom'] : "" ?></a></li>
                        <li <?php if($page == 'ajouter.php') echo 'class="active"'; ?>><a href="ajouter.php">Ajouter</a></li>
                        <?php if(isset($_SESSION['login']) && in_array($_SESSION['login'], $admins)): ?>
                            <li <?php if($page == 'getiontrajet.php') echo 'class="active"'; ?>><a href="gestiontrajet.php">Gestion des Trajets</a></li>
                        <?php endif; ?>
                        <li <?php if($page == 'mestrajets.php') echo 'class="active"'; ?>><a href="mestrajets.php">Mes trajets</a></li>
                        <li><a href="deconnexion.php">Déconnexion</a></li>
                    <?php else: ?>
                        <!-- Si l'utilisateur n'est pas connecté, affichez les liens de connexion et d'inscription -->
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    </nav>
