<?php
if(session_status() === PHP_SESSION_NONE){
    session_start(); 
}
// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['id'])) {
    header("Location: index.php"); // Redirection vers la page d'accueil
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Inclure le fichier de configuration de la base de données
    include('config/COphp.php');

    // Nettoyage et validation des données
    $errors = array();
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $mot_de_passe = filter_input(INPUT_POST, 'mot_de_passe', FILTER_SANITIZE_STRING);
    $confirmation = filter_input(INPUT_POST, 'mot_de_passe2', FILTER_SANITIZE_STRING);
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);

    // Génération du login (nom.prenom en minuscules)
    $login = strtolower($prenom) . '.' . strtolower($nom);

    // Validation des champs obligatoires
    if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe) || empty($telephone)) {
        $errors[] = "Veuillez remplir tous les champs.";
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }

    // Validation de la correspondance des mots de passe
    if ($mot_de_passe !== $confirmation) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérification de l'existence de l'email dans la base de données
    $sql = "SELECT COUNT(*) AS count FROM utilisateurs WHERE email = :email";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(array(':email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $errors[] = "Adresse email déjà utilisée. Veuillez vous connecter.";
    }

    // S'il y a des erreurs, afficher les messages d'erreur
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger">' . $error . '</div>';
        }
    } else {
        // Hasher le mot de passe
        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO utilisateurs (email, mot_de_passe, nom, prenom, telephone, login) VALUES (:email, :mot_de_passe, :nom, :prenom, :telephone, :login)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(array(':email' => $email, ':mot_de_passe' => $hashed_password, ':nom' => $nom, ':prenom' => $prenom, ':telephone' => $telephone, ':login' => $login));

        echo '<div class="alert alert-success">Compte créé avec succès !</div>';
        echo '<script>
        setTimeout(function(){
            window.location.href = "connexion.php";
        }, 2000); // 2 secondes de délai avant la redirection
        </script>';
        exit();
    }
}
?>

<?php include('include/header.php'); ?>

<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <form method="post">
                <h3 class="texte-info">Inscription</h3>
                <hr>
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input class="form-control" type="text" name="nom" id="nom" placeholder="Nom" maxlength="30">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" maxlength="30">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" name="email" id="email" placeholder="Email" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="telephone">Téléphone:</label>
                    <input class="form-control" type="tel" name="telephone" id="telephone" placeholder="Téléphone" maxlength="10">
                </div>
                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe:</label>
                    <input class="form-control" type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Mot de passe" maxlength="30">
                </div>
                <div class="form-group">
                    <label for="mot_de_passe2">Confirmez le mot de passe:</label>
                    <input class="form-control" type="password" name="mot_de_passe2" id="mot_de_passe2" placeholder="Confirmation" maxlength="30">
                </div>
                <div class="form-group">
                    <input class="btn btn-success" name="signup" type="submit" value="S'inscrire">
                </div>
            </form>
        </div>
    </div>
</div>


