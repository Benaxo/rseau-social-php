<?php
session_start();

ini_set("error_log", __DIR__."/error.log");
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


// Vérification de l'envoi du formulaire
if (isset($_POST["finalisation"])) {
    
    $_SESSION['errors'] = array();

    $id_user = $_SESSION['iduser'];

    // Vérification de l'existence du champ "pseudo" et qu'il n'est pas vide
    if (isset($_POST["pseudo"]) && !empty($_POST["pseudo"])) {
        $pseudo = mysqli_real_escape_string($conn, $_POST["pseudo"]);
    } else {
        $_SESSION['errors'][] = "Erreur : le champ pseudo est obligatoire.";
    }
    
    // Vérification de l'existence du champ "bio" et qu'il n'est pas vide
    if (isset($_POST["bio"]) && !empty($_POST["bio"])) {
        $bio = mysqli_real_escape_string($conn, $_POST["bio"]);
    } else {
        $_SESSION['errors'][] = "Erreur : le champ biographie est obligatoire.";
    }

    // Vérification de l'envoi de la photo
    if (isset($_FILES["photo"])) {
        // Récupération du nom du fichier
        $filename = $_FILES["photo"]["name"];
        // Récupération du chemin temporaire du fichier
        $tmpname = $_FILES["photo"]["tmp_name"];
        // Récupération du type de fichier
        $filetype = $_FILES["photo"]["type"];
        // Récupération de la taille du fichier
        $filesize = $_FILES["photo"]["size"];

        // Vérification du type de fichier
        if (($filetype == "image/jpeg" || $filetype == "image/png") && $filesize <= 5242880) { // 5 Mo maximum
            // Ouverture du fichier
            $fp = fopen($tmpname, "r");
            $content = fread($fp, filesize($tmpname));
            $content = addslashes($content);
            fclose($fp);

            // Insertion des données dans la base de données
            $query = "UPDATE utillisateur SET pseudo='$pseudo', biographie='$bio', photo='$content', photo_type='$filetype' WHERE iduser='$id_user'";
            if (mysqli_query($conn, $query)) {
                echo "Enregistrement réussi";
            } else {
                $_SESSION['errors'][] = "Erreur 1: " . mysqli_error($conn);

            }
        } else {
            $_SESSION['errors'][] = "Erreur : le fichier doit être au format JPG, PNG ou GIF et ne doit pas dépasser 5 Mo.";
        }
    } /*else {
        // Insertion des données dans la base de données sans la photo
        $query = "UPDATE utillisateur SET pseudo='$pseudo', biographie='$bio' WHERE iduser='$id_user'";
        if (mysqli_query($conn, $query)) {
            echo "Enregistrement réussi";
        } else {
            $_SESSION['errors'][] = "Erreur 2: " . mysqli_error($conn);
        }
    }*/
}

if(!empty($_SESSION['errors'])) {
    header("Location: inscription_comp.php");
    exit();
} else {
    header("Location: home.php");
    exit();
}

mysqli_close($conn);
?>