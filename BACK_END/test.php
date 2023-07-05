<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "nom_utilisateur";
$password = "mot_de_passe";
$dbname = "nom_base_de_donnees";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Récupérer la date actuelle
$currentDate = date("Y-m-d");

// Requête pour récupérer tous les matchs de la journée
$sql = "SELECT * FROM matchs WHERE date_debut >= '$currentDate' AND date_fin <= '$currentDate'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
</head>
<body>
    <h1>Accueil</h1>

    <h2>Tous les matchs</h2>

    <form method="post" action="enregistrer_mise.php">
        <?php
        while ($row = $result->fetch_assoc()) {
            $matchId = $row['id_match'];
            $equipe1Id = $row['equipe1_id'];
            $equipe2Id = $row['equipe2_id'];
            $dateDebut = $row['date_debut'];
            $dateFin = $row['date_fin'];
            $statut = $row['statut'];
            $score = $row['score'];
            $meteo = $row['meteo'];

            // Récupérer les noms des équipes à partir de leur ID
            $sql_equipe1 = "SELECT nom FROM equipe WHERE id = $equipe1Id";
            $result_equipe1 = $conn->query($sql_equipe1);
            $equipe1 = $result_equipe1->fetch_assoc()['nom'];

            $sql_equipe2 = "SELECT nom FROM equipe WHERE id = $equipe2Id";
            $result_equipe2 = $conn->query($sql_equipe2);
            $equipe2 = $result_equipe2->fetch_assoc()['nom'];
        ?>

        <input type="checkbox" name="matchs[]" value="<?php echo $matchId; ?>">
        <strong><?php echo $equipe1; ?> vs <?php echo $equipe2; ?></strong>
        <br>
        Jour du match : <?php echo $dateDebut; ?>
        <br>
        Heure du début : <?php echo $dateDebut; ?>
        <br>
        Heure de fin : <?php echo $dateFin; ?>
        <br>
        Statut : <?php echo $statut; ?>
        <?php if ($statut == "Termine" || $statut == "En Cours") {
            echo " - Score : " . $score;
        }
        ?>
        <br>
        Météo : <?php echo $meteo; ?>
        <br>
        <br>

        <?php
        }
        ?>

        <input type="submit" name="miser" value="Miser sur la sélection">
    </form>

    <br>
    <a href="visualiser_matchs.php">Visualiser tous les matchs</a>
    <br>
    <a href="connexion.php">Se connecter</a>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>


/////us5