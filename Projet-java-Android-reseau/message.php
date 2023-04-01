<?php
// Connexion à la base de données
$servername = "localhost";
$username = "yourusername";
$password = "yourpassword";
$dbname = "yourdbname";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Récupération de l'utilisateur connecté à partir de la session en cours
session_start();
$user_id = $_SESSION['user_id'];

// Récupération de tous les messages envoyés et reçus par l'utilisateur
$sql = "SELECT * FROM messages WHERE sender_id = '$user_id' OR receiver_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$messages = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Récupération de tous les amis de l'utilisateur
$sql = "SELECT * FROM friends WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$friends = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fonction pour afficher les messages dans la liste des messages
function displayMessage($message) {
    echo "<div class='message'>";
    echo "<p>De : " . $message['sender_name'] . "</p>";
    echo "<p>À : " . $message['receiver_name'] . "</p>";
    echo "<p>Message : " . $message['content'] . "</p>";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="messages">
            <h1>Mes messages</h1>
            <?php
            if (count($messages) > 0) {
                foreach ($messages as $message) {
                    displayMessage($message);
                }
            } else {
                echo "Aucun message à afficher.";
            }
            ?>
        </div>
        <div class="friends">
            <h1>Mes amis</h1>
            <?php
            if (count($friends) > 0) {
                echo "<ul>";
                foreach ($friends as $friend) {
                    echo "<li>" . $friend['friend_name'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Vous n'avez pas encore d'amis.";
            }
            ?>
            <form action="send_message.php" method="post">
                <label for="friend_name">Envoyer un message à :</label>
                <select name="friend_name">
                    <?php
                    foreach ($friends as $friend) {
                        echo "<option value='" . $friend['friend_name'] . "'>" . $friend['friend_name'] . "</option>";
                    }
                    ?>
                </select>
                <label for="message_content">Message :</label>
                <input type="text" name="message_content">
                <input type="hidden" name="sender_id" value="<?php echo $user_id; ?>">
                <input type="submit" value="Envoyer">
            </form>
        </div>
    </div>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
mysqli_close($conn);
?>