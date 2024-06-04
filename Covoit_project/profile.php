<?php
include('include/header.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("location:connexion.php");
    exit; // Arrêter l'exécution du script pour éviter toute exécution supplémentaire
}

// Inclure le fichier de configuration de la base de données
include('config/COphp.php');

// Récupérer les informations de l'utilisateur depuis la base de données
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM utilisateurs WHERE id = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="margin-top:20vh;">
            <div class="panel panel-default custom-form">
                <div class="panel-heading" style="text-align: center;">
                    <h3 class="panel-title"><strong>Profil de <?php echo $user['nom'] . ' ' . $user['prenom']; ?></strong></h3>
                </div>
                <div class="panel-body" style="text-align: center;">
                    <p><strong>Nom: <?php echo $user['nom']; ?></strong></p>
                    <p><strong>Prénom: <?php echo $user['prenom']; ?></strong></p>
                    <p><strong>Email: <?php echo $user['email']; ?></strong></p>
                    <p><strong>Téléphone: <?php echo $user['telephone']; ?></strong></p>
                    <!-- Ajoutez d'autres informations de profil que vous souhaitez afficher -->
                    <!--<div style="margin-top: 20px;">
                        <a href="modifier_profile.php" class="btn btn-primary">Modifier mon profil</a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>
