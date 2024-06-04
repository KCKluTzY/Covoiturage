<?php
include('config/COphp.php');

// Vérifier si l'identifiant du trajet à supprimer est passé dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $trip_id = $_GET['id'];

    // Requête SQL pour supprimer le trajet de la base de données
    $sql = "DELETE FROM trajets WHERE id = :trip_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':trip_id', $trip_id);

    // Exécuter la requête
    if($stmt->execute()) {
        // Rediriger vers une page de confirmation ou une autre page appropriée
        header("location: mestrajets.php");
        exit;
    } else {
        // Gérer les erreurs, par exemple afficher un message d'erreur ou rediriger vers une page d'erreur
        echo "Une erreur s'est produite lors de la suppression du trajet.";
    }
} else {
    // Rediriger vers une page d'erreur ou une autre page appropriée si l'identifiant du trajet n'est pas spécifié dans l'URL
    header("location: erreur.php");
    exit;
}
?>
