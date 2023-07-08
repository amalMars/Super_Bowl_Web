<?php
// Connexion à la base de données
$servername = "localhost"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur de la base de données
$password = ""; // Mot de passe de la base de données
$dbname = "super_bowl"; // Nom de la base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer tous les matchs qui ont lieu ce jour
$current_date = Date("Y-m-d"); // Date actuelle
$sql_matchs = "SELECT * FROM matchs WHERE heur_debut LIKE '$current_date%'"; 
$result_matchs = $conn->query($sql_matchs);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil</title>
</head>
<body>
<h1>Evénement en cours</h1>
    <p>a determiner</p>
    
    <h1>Matchs du jour</h1>

    <?php
    if (!empty($result_matchs->num_rows)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Equipe 1</th><th>Equipe 2</th><th>Date de début</th><th>Date de fin</th><th>Statut</th><th>Score</th><th>Météo</th></tr>";

        while ($row_matchs = $result_matchs->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_matchs["id_match"] . "</td>";
            echo "<td>" . $row_matchs["equipe1_id"] . "</td>";
            echo "<td>" . $row_matchs["equipe2_id"] . "</td>";
            echo "<td>" . $row_matchs["heur_debut"] . "</td>";
            echo "<td>" . $row_matchs["heur_fin"] . "</td>";
            echo "<td>" . $row_matchs["statut"] . "</td>";
            echo "<td>" . $row_matchs["score"] . "</td>";
            echo "<td>" . $row_matchs["meteo"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun match prévu aujourd'hui.";
    }
    ?>

<h2>Menu</h2>
    <ul>
        <li><a href="login.php">Se connecter</a></li>
        <li><a href="visual_match.php">Visualiser tous les matchs</a></li>
        <li><a href="parier.php">Parier</a></li>
        <?php if (isset($_GET['utilisateur_id'])) {
          $utilisateurId = $_GET['utilisateur_id'];    
        echo"<li><a href='monEspace.php?utilisateur_id=" .$utilisateurId. "'>Mon Espace</a></li>";}
        ?>
       
    </ul>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>


