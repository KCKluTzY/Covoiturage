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
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align: center;">
                    <h3 class="panel-title">Modifier mon profil</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="modifier_profile_action.php">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $user['nom']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $user['prenom']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone:</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo $user['telephone']; ?>" required>
                        </div>
                        <!-- Ajoutez d'autres champs de formulaire pour d'autres informations de profil si nécessaire -->
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
