<!DOCTYPE html>
<html>
<head>
    <title>Planification de match</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="submit"] {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Planification de match</h2>
    <?php
    
    $conn = mysqli_connect("localhost", "root", "root", "super_bowl");

   
    if (!$conn) {
        die("La connexion a échoué : " . mysqli_connect_error());
    }
 //requete pour connaitre l'id du match
 $sql1 = "SELECT COUNT(*) AS total FROM matchs ";
 $resultIDmatch = $conn->query($sql1);
if ($resultIDmatch->num_rows == 1) {
  // Récupérer le nombre d'utilisateurs
  $row = $resultIDmatch->fetch_assoc();
  $nombreidmatch = $row['total'];
}
 
    if (isset($_POST['equipe1']) && isset($_POST['equipe2']) && isset($_POST['date']) && isset($_POST['heure'])) {
        
        $id_match=$nombreidmatch+1;
        $equipe1Id = $_POST['equipe1'];
        $equipe2Id = $_POST['equipe2'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];

        // Calculer l'heure de fin 
        $heureDebut = $date . ' ' . $heure;
        $heureFin = date('Y-m-d H:i:s', strtotime($heureDebut . ' +1 hour'));

        // Insérer les données dans la table des matchs
        $sql = "INSERT INTO matchs (id_match,equipe1_id, equipe2_id, heur_debut, heur_fin) VALUES ('$id_match','$equipe1Id', '$equipe2Id', '$heureDebut', '$heureFin')";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Le match a été planifié avec succès.</p>";
        } else {
            echo "<p>Erreur lors de la planification du match : " . mysqli_error($conn) . "</p>";
        }
    }

    // Récupérer la liste des équipes 
    $sql = "SELECT * FROM equipe";
    $result = mysqli_query($conn, $sql);

    // Vérifier s'il y a des équipes 
    if (mysqli_num_rows($result) > 0) {
        // Afficher le formulaire pour la planification du match
        echo '<form method="post" action="">';
        echo '<label for="equipe1">Équipe 1 :</label>';
        echo '<select name="equipe1" id="equipe1">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id_equipe'] . '">' . $row['nom_equipe'] . '</option>';
        }
        echo '</select>';
        echo '<label for="equipe2">Équipe 2 :</label>';
        echo '<select name="equipe2" id="equipe2">';
        mysqli_data_seek($result, 0); // Réinitialiser le pointeur du résultat
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id_equipe'] . '">' . $row['nom_equipe'] . '</option>';
        }
        echo '</select>';
        echo '<label for="date">Date :</label>';
        echo '<input type="date" name="date" id="date">';
        echo '<label for="heure">Heure :</label>';
        echo '<input type="time" name="heure" id="heure">';
        echo '<input type="submit" value="Planifier le match">';
        echo '</form>';
    } else {
        echo '<p>Aucune équipe trouvée dans la base de données.</p>';
    }

    mysqli_close($conn);
    ?>
</body>
</html>