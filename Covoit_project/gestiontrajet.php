<?php 
include('include/header.php');
if(!isset($_SESSION['id'])){
    header("location:connexion.php");
    exit; // Arrêter l'exécution du script pour éviter toute exécution supplémentaire
}

$sql="SELECT t.*, u.nom, u.prenom FROM trajets t JOIN utilisateurs u ON t.utilisateurs_id = u.id order by heure_depart ASC";
?>
<div class="container">
<?php if($stmt = $bdd->query($sql)):?>
<?php if($stmt->rowCount() > 0){
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="trip">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                        <span class="text-info">Départ : </span><?php echo $row["lieu_depart"];?> à <?php echo $row["heure_depart"];?>  <span class="text-info"> Destination :</span><?php echo $row["lieu_arrivee"];?><br>
                                <span class="text-info">Adresse de destination :</span><?php echo $row["adresse_arrivee"];?> à <?php echo $row["heure_arrivee"];?><br>
                                <span class="text-info">Ville(s) de passage : </span><?php echo $row["villes_passage"];?><br>
                                <span class="text-success">Conducteur :</span><?php echo $row["prenom"].' '.$row["nom"];?><br>
                                <span class="text-success">Téléphone :</span><?php echo $row["telephone"];?> <span class="text-success">Mail:</span><?php echo $row["email"];?><br>
                                <span class="text-success"><?php echo $row["nombre_places"].' '.'place(s)';?></span><br>
                        </p>
                    </div>
                </div>
                <?php if (isset($_SESSION['login']) && in_array($_SESSION['login'], $admins)): ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button onclick="supprimertrajet(<?php echo $row['id'];?>);" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Supprimer</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
    function supprimertrajet(trajetId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce trajet ?")) {
            // Redirection vers le script PHP de suppression en passant l'identifiant du trajet
            window.location.href = "supprimertrajet.php?id=" + trajetId;
        }
    }
</script>
<?php endwhile; ?>
<?php }
?>
<?php endif; ?> 
