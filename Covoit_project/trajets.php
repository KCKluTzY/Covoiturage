<?php 
include('include/header.php');
if(!isset($_SESSION['id'])){
    header("location:connexion.php");
    exit; // Arrêter l'exécution du script pour éviter toute exécution supplémentaire
}

$sql="SELECT t.*, u.nom, u.prenom 
      FROM trajets t 
      JOIN utilisateurs u ON t.utilisateurs_id = u.id 
      WHERE t.utilisateurs_id != :user_id
      AND t.nombre_places !=0
      ORDER BY t.heure_depart ASC";

?>

<div class="container">
    <?php 
    if($stmt = $bdd->prepare($sql)){
        $stmt->execute([':user_id' => $_SESSION['id']]);
        if($stmt->rowCount() > 0){
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="trip">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <span class="text-info">Départ : </span><?php echo $row["lieu_depart"];?> à <?php echo $row["heure_depart"];?>  <span class="text-info">    Destination :</span><?php echo $row["lieu_arrivee"];?><br>
                            <span class="text-info">Adresse de destination :</span><?php echo $row["adresse_arrivee"];?> à <?php echo $row["heure_arrivee"];?><br>
                            <span class="text-info">Ville(s) de passage : </span><?php echo $row["villes_passage"];?><br>
                            <span class="text-success">Conducteur :</span><?php echo $row["prenom"].' '.$row["nom"];?><br>
                            <span class="text-success">Téléphone :</span><?php echo $row["telephone"];?> <span class="text-success">Mail:</span><?php echo $row["email"];?><br>
                        </p>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <?php 
            endwhile;
        } else {
            echo '<div class="row"><div class="col-md-8 col-md-offset-2"><div class="alert alert-info">Aucun trajet disponible pour le moment.</div></div></div>';
        }
    }
    ?>
</div>

