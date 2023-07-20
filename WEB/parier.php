<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "SUPER_BOWL";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

// Requête pour récupérer tous les matchs
$sql = "SELECT * FROM matchs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tous les matchs</title>
</head>
<body>
    <h1>Tous les matchs</h1>

    <form method="post" action="enregistrer_mise.php">
        <?php
if ($result->num_rows > 0) {

 
    while ($row = $result->fetch_assoc()) {
        $jourMatch = date("Y-m-d", strtotime($row['heur_debut']));
        $heureDebut = date("H:i", strtotime($row['heur_debut']));
        $heureFin = date("H:i", strtotime($row['heur_fin']));
        $statut = $row['statut'];
        $score = $row['score'];
        $matchId = $row['id_match'];
        $equipe1_id = $row["equipe1_id"];
        $equipe2_id = $row["equipe2_id"];
        $lienDetails = "details.php?id=$matchId";
        if ($statut == "a venir" || $statut == "En Cours") {

        
        // Récupérer les noms des équipes
        $sql_equipe1 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe1_id"; // Remplacez "equipe1" par le nom de votre table d'équipes et "id" par le champ correspondant à l'équipe
        $result_equipe1 = $conn->query($sql_equipe1);
        $row_equipe1 = $result_equipe1->fetch_assoc();
        $equipe1_nom = $row_equipe1["nom_equipe"];

        $sql_equipe2 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe2_id"; // Remplacez "equipe2" par le nom de votre table d'équipes et "id" par le champ correspondant à l'équipe
        $result_equipe2 = $conn->query($sql_equipe2);
        $row_equipe2 = $result_equipe2->fetch_assoc();
        $equipe2_nom = $row_equipe2["nom_equipe"];


     

        // Déterminer le statut du match
        $statutMatch = "";
        if ($statut == "Termine") {
            $statutMatch = "Terminé";
        } elseif ($statut == "En Cours") {
            $statutMatch = "En cours";
        } else {
            $statutMatch = "À venir";
        }
        // Récupérer les noms des équipes
        $sql_equipe1 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe1_id";
        $result_equipe1 = $conn->query($sql_equipe1);
        $row_equipe1 = $result_equipe1->fetch_assoc();
        $equipe1_nom = $row_equipe1["nom_equipe"];

        $sql_equipe2 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe2_id";
        $result_equipe2 = $conn->query($sql_equipe2);
        $row_equipe2 = $result_equipe2->fetch_assoc();
        $equipe2_nom = $row_equipe2["nom_equipe"];
        ?>

        <input type="checkbox" name="matchs[]" value="<?php echo $matchId; ?>">
        <strong><?php echo $equipe1_nom; ?> vs <?php echo $equipe2_nom; ?></strong>
        <br>
        Jour du match : <?php echo $jourMatch; ?>
        <br>
        Heure du début : <?php echo $heureDebut; ?>
        <br>
        Heure de fin : <?php echo $heureFin; ?>
        <br>
        Statut du match : <?php echo $statutMatch; ?>
        <?php if ($statut == "Termine" || $statut == "En Cours") {
            echo " - Score : " . $score;
        }
        ?>
        <br>
        <a href="<?php echo $lienDetails; ?>">Détails du match</a>
        <br>
        <br>

        <?php
    }
    echo "</table>";
}
    } else {
        echo "Aucun match trouvé.";
    }
        ?>

        <?php if (isset($_SESSION['utilisateur_id'])) { ?>
            <input type="submit" name="miser" value="Miser sur la sélection">
        <?php } ?>

    </form>

    <br>
    <a href="login.php">Se connecter</a>

</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>