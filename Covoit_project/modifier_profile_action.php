<?php
include('config/COphp.php');

// Vérifier si le formulaire de modification a été soumis
if(isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['telephone'])) {
    // Récupérer les données du formulaire
    $user_id = $_SESSION['id'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    // Mettre à jour les informations de l'utilisateur dans la base de données
    $sql = "UPDATE utilisateurs 
            SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone
            WHERE id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':user_id', $user_id);

    // Exécuter la requête
    if($stmt->execute()) {
        // Rediriger vers la page de profil avec un message de succès
        header("location: profile.php?success=1");
        exit;
    } else {
        // Gérer les erreurs, par exemple afficher un message d'erreur ou rediriger vers une page d'erreur
        header("location: modifier_profile.php?error=1");
        exit;
    }
} else {
    // Rediriger vers une page d'erreur si le formulaire n'a pas été soumis correctement
    header("location: modifier_profile.php?error=1");
    exit;
}
?>

