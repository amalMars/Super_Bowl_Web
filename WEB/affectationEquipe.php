<?php
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "root";
$nomBaseDeDonnees = "super_bowl";

$conn = mysqli_connect($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

// Récupérer les matchs à affecter
$requeteMatchs = "SELECT * FROM matchs WHERE statut = 'a venir'";
$resultatMatchs = mysqli_query($conn, $requeteMatchs);

if (mysqli_num_rows($resultatMatchs) > 0) {
    while ($match = mysqli_fetch_assoc($resultatMatchs)) {
        $requeteCotes = "SELECT * FROM cote WHERE match_id = " . $match['id_match'];
        $resultatCotes = mysqli_query($conn, $requeteCotes);

        // Vérifier s'il y a des cotes pour ce match
        if (mysqli_num_rows($resultatCotes) > 0) {
            while ($cote = mysqli_fetch_assoc($resultatCotes)) {
                // Affecter l'équipe à la cote
                $equipeId = $cote['equipe_id'];
                $coteId = $cote['id_cote'];

                // Mettre à jour la cote avec l'équipe affectée
                $requeteAffectation = "UPDATE cote SET equipe_id = " . $equipeId . " WHERE id_cote = " . $coteId;
                mysqli_query($conn, $requeteAffectation);
            }
        }

        // Mettre à jour le statut du match pour indiquer qu'il est affecté
        $requeteMiseAJour = "UPDATE matchs SET statut = 'affecté' WHERE id_match = " . $match['id_match'];
        mysqli_query($conn, $requeteMiseAJour);
    }

    echo "Affectation des équipes effectuée avec succès.";
} else {
    echo "Aucun match à affecter.";
}

mysqli_close($conn);
?>