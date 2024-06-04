<?php include('include/header.php'); ?>

<?php 
if(!isset($_SESSION['id'])){
    header("location:connexion.php");
    exit; // Arrêter l'exécution du script pour éviter toute exécution supplémentaire
}
?>

<?php
    // Inclure le fichier de configuration de la base de données
    include('config/COphp.php');

    // Récupérer les lieux et leurs adresses depuis la base de données
    $sql = "SELECT lieu, adresse FROM LieuxAdresse";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $lieuxAdresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si l'identifiant du trajet à modifier est passé dans l'URL
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $trip_id = $_GET['id'];

        // Récupérer les détails du trajet à modifier depuis la base de données
        $sql = "SELECT * FROM trajets WHERE id = :id";
        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':id', $trip_id);
        $stmt->execute();
        $trip = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le trajet existe
        if(!$trip) {
            // Rediriger vers une page d'erreur ou une autre page appropriée
            header("location: erreur.php");
            exit;
        }
    } else {
        // Rediriger vers une page d'erreur ou une autre page appropriée
        header("location: erreur.php");
        exit;
    }
?>

<div class="container">
    <div id="result">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <form method="post" action="modifiertrajets_action.php" id="modifiertrajets">
                        <h3 class="text-info">Modifier un trajet</h3>
                        <div class="form-group">
                            <label for="from">Départ:</label><br>
                            <input type="text" name="from" placeholder="---Ville ou adresse de départ---" class="form-control large-input" value="<?php echo $trip['lieu_depart']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="time">Heure de départ:</label>
                            <input type="time" name="time" class="form-control large-input" style="text-align: center;" value="<?php echo $trip['heure_depart']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="from2">Villes de passage:</label><br>
                            <input type="text" name="from2" placeholder="---Villes de passage---" class="form-control large-input" value="<?php echo $trip['villes_passage']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="to">Destination:</label>
                            <select class="form-control" name="to" id="to" required style="text-align: center;">
                                <?php foreach($lieuxAdresses as $lieuAdresse): ?>
                                    <option value="<?php echo $lieuAdresse['lieu']; ?>" data-adresse="<?php echo $lieuAdresse['adresse']; ?>" <?php if($lieuAdresse['lieu'] == $trip['lieu_arrivee']) echo 'selected'; ?>>
                                        <?php echo $lieuAdresse['lieu']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to2">Adresse (celle-ci se modifie automatiquement lors de la modification de la destination):</label>
                            <select class="form-control" name="to2" id="to2" style="text-align: center;" readonly>
                                    <option value="<?php echo $trip['adresse_arrivee'];?>">
                                    <?php echo $trip['adresse_arrivee'];?>
                                    </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="time2">Heure de d'arrivée:</label>
                            <input type="time2" name="time2" class="form-control large-input" style="text-align: center;" value="<?php echo $trip['heure_arrivee']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="places">Nombres de places:</label>
                            <input type="number" name="places" class="form-control large-input" min="0" max="4" style="text-align: center;" value="<?php echo $trip['nombre_places']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Téléphone à contacter:</label>
                            <input type="tel" name="contact" class="form-control large-input" value="<?php echo $trip['telephone']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email à contacter:</label>
                            <input type="email" name="email" class="form-control large-input" value="<?php echo $trip['email']; ?>">
                        </div>
                        <div class="form-group">
                            <!-- Champ caché pour l'identifiant du trajet à modifier -->
                            <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>">
                            <input class="btn btn-success" name="update" type="submit" value="Modifier">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById("to").addEventListener("change", function() {
    var selectedLieu = this.value;
    var adresseDropdown = document.getElementById("to2");

    // Récupérer l'adresse associée au lieu sélectionné
    var adresse = this.options[this.selectedIndex].getAttribute("data-adresse");

    // Mettre à jour la liste déroulante des adresses
    adresseDropdown.innerHTML = ""; // Efface toutes les options précédentes
    if (adresse) {
        var option = document.createElement("option");
        option.text = adresse;
        option.value = adresse;
        adresseDropdown.add(option);
    } else {
        var option = document.createElement("option");
        option.text = "--- Adresse ---";
        option.value = "";
        adresseDropdown.add(option);
    }
});
</script>
</body>
</html>

