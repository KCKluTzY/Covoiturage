<?php
include('config/COphp.php');

// Vérifier si le formulaire de modification a été soumis
if(isset($_POST['update'])) {
    // Récupérer les données du formulaire
    $trip_id = $_POST['trip_id'];
    $from = $_POST['from'];
    $from2 = $_POST['from2'];
    $to = $_POST['to'];
    $to2 = $_POST['to2'];
    $places = $_POST['places'];
    $time = $_POST['time'];
    $time2 = $_POST['time2'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Mettre à jour les informations du trajet dans la base de données
    $sql = "UPDATE trajets 
            SET lieu_depart = :from, villes_passage = :from2, lieu_arrivee = :to, adresse_arrivee = :to2, 
                nombre_places = :places, heure_depart = :time, heure_arrivee = :time2, telephone = :contact, email = :email 
            WHERE id = :trip_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':from', $from);
    $stmt->bindParam(':from2', $from2);
    $stmt->bindParam(':to', html_entity_decode($to));
    $stmt->bindParam(':to2', html_entity_decode($to2));
    $stmt->bindParam(':places', $places);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':time2', $time2);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':trip_id', $trip_id);

    // Exécuter la requête
    if($stmt->execute()) {
        // Rediriger vers une page de confirmation ou une autre page appropriée
        header("location: mestrajets.php");
        exit;
    } else {
        // Gérer les erreurs, par exemple afficher un message d'erreur ou rediriger vers une page d'erreur
        echo "Une erreur s'est produite lors de la mise à jour du trajet.";
    }
} else {
    // Rediriger vers une page d'erreur ou une autre page appropriée si le formulaire n'a pas été soumis correctement
    header("location: erreur.php");
    exit;
}
?>

