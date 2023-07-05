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

// Récupérer l'ID du match à partir de l'URL
if (isset($_GET['id'])) {
    $match_id = $_GET['id'];

    // Récupérer les détails du match
    $sql_match = "SELECT * FROM matchs WHERE id_match = $match_id";
    $result_match = $conn->query($sql_match);

    // Récupérer les compositions des équipes
    $sql_compositions = "SELECT * FROM composition WHERE match_id = $match_id";
    $result_compositions = $conn->query($sql_compositions);

    // Récupérer les cotes des équipes
    $sql_cotes = "SELECT * FROM cote WHERE match_id = $match_id";
    $result_cotes = $conn->query($sql_cotes);

    // Récupérer les commentaires du match
    $sql_commentaires = "SELECT * FROM commentaire WHERE match_id = $match_id";
    $result_commentaires = $conn->query($sql_commentaires);

    if ($result_match->num_rows > 0) {
        $row_match = $result_match->fetch_assoc();
        $equipe1_id = $row_match["equipe1_id"];
        $equipe2_id = $row_match["equipe2_id"];
        $heur_debut = $row_match["heur_debut"];
        $heur_fin = $row_match["heur_fin"];
        $statut = $row_match["statut"];
        $score = $row_match["score"];
        $meteo = $row_match["meteo"];

        // Récupérer les noms des équipes
        $sql_equipe1 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe1_id";
        $result_equipe1 = $conn->query($sql_equipe1);
        $row_equipe1 = $result_equipe1->fetch_assoc();
        $equipe1_nom = $row_equipe1["nom_equipe"];

        $sql_equipe2 = "SELECT nom_equipe FROM equipe WHERE id_equipe = $equipe2_id";
        $result_equipe2 = $conn->query($sql_equipe2);
        $row_equipe2 = $result_equipe2->fetch_assoc();
        $equipe2_nom = $row_equipe2["nom_equipe"];

        echo "<h1>Détails du match</h1>";
        echo "<h2>$equipe1_nom vs $equipe2_nom</h2>";
        echo "<p> Heure de début : $heur_debut</p>";
        echo "<p> Heure de fin : $heur_fin</p>";
        


        // Afficher les compositions des équipes
        if (!empty($result_compositions->num_rows )) {
            echo "<h3>Compositions des équipes</h3>";
            while ($row_composition = $result_compositions->fetch_assoc()) {
                $equipe_id = $row_composition["equipe_id"];
                $nombre_joueurs = $row_composition["numero_joueurs"];

                // Récupérer les noms des joueurs de l'équipe
                $sql_joueurs = "SELECT nom_joueur, prenom_joueur FROM joueur WHERE equipe_id = $equipe_id";
                $result_joueurs = $conn->query($sql_joueurs);

                echo "<p>$nombre_joueurs joueurs dans l'équipe $equipe_id :</p>";
                echo "<ul>";
                while ($row_joueur = $result_joueurs->fetch_assoc()) {
                    $nom_joueur = $row_joueur["nom_joueur"];
                    $prenom_joueur = $row_joueur["prenom_joueur"];
                    echo "<li>$nom_joueur $prenom_joueur</li>";
                }
                echo "</ul>";
            }
        }else{echo "il y a pas des joueurs ";}



        // Afficher les cotes des équipes
        if ($result_cotes->num_rows > 0) {
            echo "<h3>Cotes des équipes</h3>";
            while ($row_cote = $result_cotes->fetch_assoc()) {
                $equipe_id= $row_cote["equipe_id"];
                $valeur_cote = $row_cote["valeur"];

                echo "<p>Cote de l'équipe $equipe_id : $valeur_cote</p>";
            }
        }

        echo "<p>Statut du match : $statut</p>";
        echo "<p>Score : $score</p>";
        echo "<p>Météo : $meteo</p>";

        // Afficher les commentaires du match
        if (!empty($result_commentaires->num_rows)) {
            echo "<h3>Commentaires</h3>";
            while ($row_commentaire = $result_commentaires->fetch_assoc()) {
                $utilisateur_id = $row_commentaire["utilisateur_id"];
                $commentaire = $row_commentaire["commentaire"];

                echo "<p>Commentaire de l'utilisateur $utilisateur_id : $commentaire</p>";
            }
        }

        // Afficher le bouton de mise uniquement si le match n'est pas commencé ou terminé
        if ($statut != "Termine" && $statut != "En Cours") {
            echo "<button onclick='miser()'>Miser</button>";
        }

    } else {
        echo "Aucun match trouvé.";
    }
} else {
    echo "ID de match non spécifié.";
}
?>

<script>
// Fonction pour l'action du bouton de mise
function miser() {
    session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    // Rediriger vers la page d'authentification si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}
    // Votre code pour l'action de mise ici
  //  alert("Vous avez cliqué sur le bouton Miser !");
}
</script>