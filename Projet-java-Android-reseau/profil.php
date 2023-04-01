<?php
// Définir la durée de vie du cookie de session à 1 heure
ini_set('session.cookie_lifetime', 60 * 60);

session_start();



// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reseau_social_php";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
  
if(!isset($_SESSION['iduser'])) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: index.php');
    exit();

  }else{

    // Récupérez l'ID de l'utilisateur à partir de la variable de session
    $user_id = $_SESSION['iduser'];
    $sql = "SELECT * FROM utillisateur WHERE iduser='$user_id'";
    $result = mysqli_query($conn, $sql);

  }



if ($result !== false && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    // le reste du code ici   
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil de <?php echo $user['pseudo']; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="profile">
            <h1>Profil de <?php echo $user['pseudo']; ?></h1>
            <div class="avatar">
                <img src="<?php echo $user['photo_p_url']; ?>" alt="Avatar de <?php echo $user['pseudo']; ?>">
            </div>
            <p>Nom : <?php echo $user['Nom']; ?></p>
            <p>Prénom : <?php echo $user['prenom']; ?></p>
            <p>Email : <?php echo $user['email']; ?></p>
            <p>Âge : <?php echo $user['age']; ?></p>
            <p>Ville : <?php echo $user['ville']; ?></p>
            <!-- vous pouvez ajouter d'autres informations à afficher ici -->
        </div>
        <div class="edit-profile">
            <h2>Modifier le profil</h2>
            <form action="update_profile.php" method="post">
                <label for="full_name">Nom :</label>
                <input type="text" name="nom" value="<?php echo $user['Nom']; ?>">

                <label for="email">Email :</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>">

                <label for="age">Âge :</label>
                <input type="number" name="age" value="<?php echo $user['age']; ?>">

                <label for="city">Ville :</label>
                <input type="text" name="ville" value="<?php echo $user['ville']; ?>">

                <label for="photo_p_url">URL de l'avatar :</label>
                <input type="text" name="photo_p_url" value="<?php echo $user['photo_p_url']; ?>">

                <label for="new_password">Nouveau mot de passe :</label>
                <input type="password" name="new_password">

                <label for="confirm_password">Confirmez le nouveau mot de passe :</label>
                <input type="password" name="confirm_password">

                <input type="hidden" name="user_id" value="<?php echo $user['iduser']; ?>">

                <input type="submit" value="Enregistrer les modifications">
            </form>
        </div>
    </div>
</body>
</html>

<?php
} else {
    echo "Aucun utilisateur trouvé avec cet ID.";
}
// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>