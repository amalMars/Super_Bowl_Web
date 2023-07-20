<?php

$servername = "localhost"; 
$username = "root";
$password = "root"; 
$dbname = "super_bowl"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}


$sql_matchs = "SELECT * FROM matchs"; 
$result_matchs = $conn->query($sql_matchs);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des matchs</title>
</head>
<body>
    <h1>Liste des matchs</h1>

    <?php
    if ($result_matchs->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Equipe 1</th><th>Equipe 2</th><th>Date et heure de début</th><th>Date et heure de fin</th><th>Statut</th><th>Score</th><th>Détails</th></tr>";

        while ($row_matchs = $result_matchs->fetch_assoc()) {
            $equipe1_id = $row_matchs["equipe1_id"];
            $equipe2_id = $row_matchs["equipe2_id"];
            $heur_debut = $row_matchs["heur_debut"];
            $heur_fin = $row_matchs["heur_fin"];
            $statut = $row_matchs["statut"];
            $score = $row_matchs["score"];

            // Récupérer les noms des équipes
            $sql_equipe1 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe1_id"; // Remplacez "equipe" par le nom de votre table d'équipes et "id" par le champ correspondant à l'équipe
            $result_equipe1 = $conn->query($sql_equipe1);
            $row_equipe1 = $result_equipe1->fetch_assoc();
            $equipe1_nom = $row_equipe1["nom_equipe"];

            $sql_equipe2 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe2_id"; // Remplacez "equipe" par le nom de votre table d'équipes et "id" par le champ correspondant à l'équipe
            $result_equipe2 = $conn->query($sql_equipe2);
            $row_equipe2 = $result_equipe2->fetch_assoc();
            $equipe2_nom = $row_equipe2["nom_equipe"];

            echo "<tr>";
            echo "<td>" . $equipe1_nom . "</td>";
            echo "<td>" . $equipe2_nom . "</td>";
            echo "<td>" . $heur_debut . "</td>";
            echo "<td>" . $heur_fin . "</td>";
            echo "<td>" . $statut . "</td>";
            
            if ($statut == "Termine" || $statut == "En Cours") {
                echo "<td>" . $score . "</td>";
            } else {
                echo "<td></td>";
            }
            
            echo "<td><a href='details.php?id=" . $row_matchs['id_match'] . "'>Détails</a></td>"; // Remplacez "details_match.php" par le nom de la page de détails du match
            
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Aucun match trouvé.";
    }
    ?>

</body>
</html>

<?php

$conn->close();
?>