<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', 'root', 'super_bowl');


if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}


if (isset($_GET['utilisateur_id'])) {
    echo 'succes';

    
    $utilisateurId = $_GET['utilisateur_id'];

    // Récupérer les informations de l'utilisateur
    $sql_info_utilisateur = "SELECT nom, prenom, email FROM utilisateur WHERE id_utilisateur = $utilisateurId";
    $result_info_utilisateur = $conn->query($sql_info_utilisateur);
    $row_info_utilisateur = $result_info_utilisateur->fetch_assoc();

    $nom = $row_info_utilisateur['nom'];
    $prenom = $row_info_utilisateur['prenom'];
    $email = $row_info_utilisateur['email'];

    // Afficher les informations de l'utilisateur
    echo "<h2>Bienvenue, $prenom $nom</h2>";
    echo "<p>Email : $email</p>";

    // Afficher le menu des onglets
    echo "<ul class='tabs'>
            <li class='tab'><a href='#dashboard'>Dashboard</a></li>
            <li class='tab'><a href='#historique'>Historique des mises</a></li>
          </ul>";

    echo "<div id='dashboard' class='tab-content'>";
    
    echo "<h3>Graphique des montants gagnés ou perdus</h3>";
    
    echo "</div>";

    echo "<div id='historique' class='tab-content'>";
    
    echo "<h3>Historique des mises</h3>";
    
    echo "</div>";

} else {
   
    echo "Vous devez être connecté pour accéder à votre espace utilisateur.";
}
// ...
?>