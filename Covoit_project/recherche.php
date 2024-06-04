<?php
include('include/header.php');
if(!isset($_SESSION['id'])){
    header("location:connexion.php");
    exit; // Arrêter l'exécution du script pour éviter toute exécution supplémentaire
}
// Construire la requête SQL de base en excluant les trajets de l'utilisateur connecté
$sql="SELECT t.*, u.nom, u.prenom 
      FROM trajets t 
      JOIN utilisateurs u ON t.utilisateurs_id = u.id 
      WHERE t.utilisateurs_id != :user_id
      AND t.nombre_places !=0 
      ORDER BY t.heure_depart ASC";

// Tableau pour stocker les conditions de recherche
$conditions = [];

// Vérifier si le champ "Départ" est rempli
if (!empty($_POST['from'])) {
    $conditions[] = "lieu_depart LIKE :from";
}



// Vérifier si le champ "Destination" est rempli
if (!empty($_POST['to'])) {
    $conditions[] = "lieu_arrivee LIKE :to";
}

// Vérifier si le champ "Adresse" est rempli
if (!empty($_POST['adresse'])) {
    $conditions[] = "adresse_arrivee LIKE :adresse";
}

// Concaténer les conditions avec des "AND"
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

// Préparer la requête SQL
$stmt = $bdd->prepare($sql);

// Lier les valeurs des paramètres
$stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
if (!empty($_POST['from'])) {
    $stmt->bindValue(':from', '%' . $_POST['from'] . '%', PDO::PARAM_STR);
}
if (!empty($_POST['to'])) {
    $stmt->bindValue(':to', '%' . $_POST['to'] . '%', PDO::PARAM_STR);
}
if (!empty($_POST['adresse'])) {
    $stmt->bindValue(':adresse', '%' . $_POST['adresse'] . '%', PDO::PARAM_STR);
}

// Exécuter la requête
$stmt->execute();

?>
<div class="container">
<?php if($stmt->rowCount() > 0){
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>
    <div class="row" align="center">
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
                            </p>
                        </div>
                    </a>
                </div>
            </div>  
        </div>
    </div>
<?php 
endwhile;
}
else { ?>
   <div class="row" align="center">
        <div class="col-md-8 col-md-offset-2">
            <div class="trip">
                <br><br>
                <b>Nous sommes navrés ! Aucun utilisateur n'a proposé ce trajet.</b>
            </div>  
        </div>
    </div>
<?php } ?>

