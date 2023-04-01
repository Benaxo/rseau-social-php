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

// Traitement de la connexion
if(isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $mdp_co = $_POST['mdp_co'];
    
    $sql = "SELECT * FROM Utillisateur WHERE email='$email' AND mdp='$mdp_co'";

    $result = mysqli_query($conn, $sql);
    
    if($result === false) {
        die("Erreur d'exécution de la requête SQL: " . mysqli_error($conn));
    }

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $id_user = $row['iduser'];
        $_SESSION['iduser'] = $id_user;
        $_SESSION['pseudo'] = $row['pseudo'];
        $_SESSION['nom'] = $row['nom'];
        $_SESSION['prenom'] = $row['prenom'];
    // ajoutez les autres informations de l'utilisateur ici
        header("Location: profil.php");
        exit();
    }
    else {
        $_SESSION['erreur_connexion'] = "Nom d'utilisateur ou mot de passe incorrect";
        header("Location: index.php");
        exit();
    }

}
mysqli_close($conn);
?>