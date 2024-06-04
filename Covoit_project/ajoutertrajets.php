<?php 
error_reporting(E_ERROR | E_PARSE);
include('./config/COphp.php'); 
if(session_status() === PHP_SESSION_NONE){
    session_start(); 
}

$errors = "";
$from = filter_input(INPUT_POST, 'from', FILTER_SANITIZE_STRING);
$from2 = filter_input(INPUT_POST, 'from2', FILTER_SANITIZE_STRING);   
$to = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_STRING);
$to2 = filter_input(INPUT_POST, 'to2', FILTER_SANITIZE_STRING);
$places = filter_input(INPUT_POST, 'places', FILTER_SANITIZE_NUMBER_INT);
$time = isset($_POST["time"]) ? $_POST['time'] : "";
$time2 = isset($_POST["time2"]) ? $_POST['time2'] : "";
$contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

if(empty($from)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer le départ</div>';
}

if(empty($from2)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer les villes de passages</div>';
}

if(empty($to)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer la destination</div>';
}


if(empty($places)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer le nombre de places</div>';
}

if(empty($time)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer l\'heure de départ</div>';
}

if(empty($time2)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer l\'heure d\'arrivée</div>';
}

if(empty($contact)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer votre numéro de téléphone</div>';
}

if(empty($email)){
    $errors.= '<div class="alert alert-danger">Veuillez entrer votre email</div>';
}

if($errors){
    echo '<div class="row"><div class="col-md-4 col-md-offset-4">'.$errors.'</div></div>';
} else {
    $sql = "INSERT INTO trajets (lieu_depart, villes_passage, lieu_arrivee, adresse_arrivee, nombre_places, heure_depart, heure_arrivee, telephone, email, utilisateurs_id) 
            VALUES (:from, :from2, :to, :to2, :places, :time, :time2, :contact, :email, :utilisateurs_id)";
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
    $stmt->bindParam(':utilisateurs_id', $_SESSION['id']);
    
    if($stmt->execute()){
        echo '<div class="row"><div class="col-md-4 col-md-offset-4"><div class="alert alert-success">Trajet ajouté avec succès!</div></div></div>';
        echo '<script>
            setTimeout(function(){
                window.location.href = "index.php";
            }, 2000); // 2 secondes de délai avant la redirection
          </script>';
    } else {
        echo '<div class="row"><div class="col-md-4 col-md-offset-4"><div class="alert alert-danger">Erreur lors de l\'ajout du trajet!</div></div></div>'; 
    }
}
?>
