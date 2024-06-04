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
?>
<div class="container">
    <div id="result">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default custom-form">
                    <form method="post" action="ajoutertrajets.php" id="ajoutertrajets">
                        <h3 class="text-info" style="color:#E39C04">Ajouter un trajet</h3>
                        <div class="form-group">
                            <label for="from">Départ:</label><br>
                            <input type="text" name="from" placeholder="---Ville de départ---" class="form-control large-input" required>
                        </div>
                        <div class="form-group">
                                <label for="time">Heure de départ:</label>
                                <input type="time" name="time" id="time" class="form-control large-input" style="text-align: center;" required>
                        </div>
                        <div class="form-group" >
                            <label for="from2">Ville(s) de passage:</label><br>
                            <input type="text" name="from2" placeholder="---Villes de passage---" class="form-control large-input" required>
                        </div>
                        <div class="form-group">
                            <label for="to">Destination:</label>
                            <select class="form-control" name="to" id="to" required style="text-align: center;">
                                <option value="" disabled selected>--- Lieu d'arrivée ---</option>
                                <?php foreach($lieuxAdresses as $lieuAdresse): ?>
                                    <option value="<?php echo $lieuAdresse['lieu']; ?>" data-adresse="<?php echo $lieuAdresse['adresse']; ?>">
                                        <?php echo $lieuAdresse['lieu']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="to2">Adresse:</label>
                            <select class="form-control" name="to2" id="to2" required style="text-align: center;" readonly>
                                <option value="" disabled selected>---L'Adresse s'ajoute toute seule apres selection du lieux d'arrivée---</option>
                            </select>
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
                            <div class="form-group">
                                <label for="time">Heure d'arrivée:</label>
                                <input type="time" name="time2" id="time2" class="form-control large-input" style="text-align: center;" required>
                        </div>
                            <div class="form-group">
                                <label for="places">Nombres de places:</label>
                                <input type="number" name="places" id="places" class="form-control large-input" min="1" max="4" style="text-align: center;" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Téléphone à contacter:</label>
                                <input type="tel" name="contact" id="contact" class="form-control large-input" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email à contacter:</label>
                                <input type="email" name="email" id="email" class="form-control large-input" required>
                            </div>
                            <div class="form-group text-center">
                                <input class="btn btn-success" name="signup" type="submit" value="Valider">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

