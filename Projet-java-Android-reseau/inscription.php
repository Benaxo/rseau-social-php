<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reseau_social_php";

// Connexion à la base de données
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Traitement de l'inscription
if(isset($_POST['inscription'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $confirm_mdp = $_POST['confirm_mdp'];
    
    $_SESSION['errors'] = array();

    // Vérification des données du formulaire
    if(empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($confirm_mdp)) {
        $_SESSION['errors'][] = "Tous les champs doivent être remplis.";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'][] = "L'adresse email n'est pas valide.";
    }
    elseif(strlen($mdp) < 6) {
        $_SESSION['errors'][] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    elseif($mdp != $confirm_mdp) {
        $_SESSION['errors'][] = "Les deux mots de passe ne sont pas identiques.";
    }
    else {
        // Vérification si l'email est déjà utilisé
        $sql_email = "SELECT * FROM utilisateur WHERE email='$email'";
        $result_email = mysqli_query($conn, $sql_email);

        if($result_email) {
            if(mysqli_num_rows($result_email) > 0) {
                $_SESSION['errors'][] = "L'adresse email est déjà utilisée.";
            }
            else {
            $_SESSION['errors'][] = "Une erreur est survenue lors de la vérification de l'email : " . mysqli_error($conn);
            }
        }
        else {
            // Insertion de l'utilisateur dans la base de données
            $sql_insert = "INSERT INTO utillisateur (nom, prenom, email, mdp) VALUES ('$nom', '$prenom', '$email', '$mdp')";
            if(mysqli_query($conn, $sql_insert)) {

                $id_user = mysqli_insert_id($conn);
                
                $_SESSION['iduser'] = $id_user;
                // Redirection vers la page de connexion
                header("Location: inscription_comp.php");
                exit();
            }
            else {
                $_SESSION['errors'][] = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
    // Redirection vers la page d'inscription avec les erreurs stockées dans la variable de session
    if(!empty($_SESSION['errors'])) {
        header("Location: index.php");
        exit();
    }
}

mysqli_close($conn);
?> 