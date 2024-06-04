<?php include('include/header.php');?>
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
    <div class="row">
        <div class="col-md-8 col-md-offset-2 header">
            <h1 class="text-center">En voiture !</h1>    
            <p class="text-center lead">Les Papillons blancs Denain lance son application web de covoiturage! <br> 
                Participez vous aussi au covoiturage et contribuons ensemble à l'écologie de notre entreprise !</p>
        </div>    
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="recherche.php" method="post" class="form-horizontal" id="recherhceForm">
                <div class="form-group">
                    <label for="from">Départ:</label><br>
                    <input name="from" id="from" type="text" placeholder="--- Ville de départ ---" class="form-control large-input">
                </div>
                <div class="form-group">
                    <label for="from2">Ville(s) de passage:</label><br>
                    <input name="from2" id="from2" type="text" placeholder="--- Ville(s) de passage ---" class="form-control large-input">
                </div>
                <div class="form-group">
                    <label for="to">Destination</label>
                    <select class="form-control" name="to" id="to" style="text-align: center;">
                        <option value="" disabled selected>--- Lieu d'arrivée ---</option>
                        <!-- Sélection des lieux a partir des lieux enté dans la bdd -->
                        <?php foreach($lieuxAdresses as $lieuAdresse): ?>
                            <option value="<?php echo $lieuAdresse['lieu']; ?>" data-adresse="<?php echo $lieuAdresse['adresse']; ?>">
                                <?php echo $lieuAdresse['lieu']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <select class="form-control" name="adresse" id="adresse" style="text-align: center;" disabled>
                        <option value="" disabled selected>---L'Adresse s'ajoute toute seule apres selection du lieux d'arrivée---</option>
                    </select>
                </div>
                <script>
                    document.getElementById("to").addEventListener("change", function() {
                        var selectedLieu = this.value;
                        var adresseDropdown = document.getElementById("adresse");

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
                <div class="form-group text-center">
                    <button class="btn btn-success" type="submit">Recherche</button>
                </div>
            </form>
        </div>
    </div>
</div>
