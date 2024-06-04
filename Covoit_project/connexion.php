<?php include('include/header.php');?>

<?php
// Vérifier si l'utilisateur est déjà connecté
if(isset($_SESSION['id'])){
    header("location:index.php");
    exit(); // Arrêter le script pour éviter toute exécution supplémentaire
}

// Vérifier si le formulaire a été soumis
if(isset($_POST['login'])){
    // Inclure le fichier de configuration de la base de données
    include('config/COphp.php');

    // Nettoyage et validation des données
    $errors = "";
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $mot_de_passe = filter_input(INPUT_POST, 'mot_de_passe', FILTER_SANITIZE_STRING);

    // Validation des champs obligatoires
    if(empty($email) || empty($mot_de_passe)){
        $errors.= '<div class="alert alert-danger">Veuillez entrer votre email et votre mot de passe</div>';
    }

    // Vérification de l'email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors .= '<div class="alert alert-danger">Email invalide</div>';   
    }

    // Si pas d'erreurs jusqu'à présent, vérifier les informations de connexion dans la base de données
    if(empty($errors)){
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $bdd->prepare($sql);
        $stmt->execute(array(':email' => $email));
        $utilisateurs = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et que le mot de passe est correct
        if($utilisateurs && password_verify($mot_de_passe, $utilisateurs['mot_de_passe'])){
            // Authentification réussie, définir les variables de session
           // Authentification réussie, définir les variables de session
            $_SESSION['id'] = $utilisateurs['id'];
            $_SESSION['email'] = $utilisateurs['email'];
            $_SESSION['nom'] = $utilisateurs['nom']; // Assurez-vous que 'nom' est le bon champ dans votre base de données
            $_SESSION['prenom'] = $utilisateurs['prenom'];
            $_SESSION['login'] = $utilisateurs['login']; // Assurez-vous que 'prenom' est le bon champ dans votre base de données
            $_SESSION['logged'] = true;
            
            // Rediriger l'utilisateur vers la page d'accueil
            header("location:index.php");
            exit();
        } else {
            // Informer l'utilisateur que les informations de connexion sont incorrectes
            $errors.= '<div class="alert alert-danger">Email ou mot de passe incorrect</div>';
        }
    }

    // Afficher les erreurs, le cas échéant
    if(!empty($errors)){
        echo $errors;
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <form method="post" action="connexion.php">
                    <h3 class="text-info">
                        Connexion: 
                    </h3>
                    <hr>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label for="loginpassword" class="sr-only">Mot de passe:</label>
                        <input class="form-control" type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Mot de passe" maxlength="30">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember">
                                Rester connecté
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login" class="btn btn-info">
                            Connexion
                        </button>  
                    </div>
                    <hr>
                    <a href="inscription.php" class="btn btn-link">
                        S'inscire
                    </a>
                </form>
            </div>              
        </div>
    </div>
</div>