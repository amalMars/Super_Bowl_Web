<?php



if (isset($_SESSION['utilisateur_id'])) {
   $utilisateurId = $_SESSION['utilisateur_id'];
   $matchId = $_POST['match_id'];

    // Vérifier si une mise existe déjà pour ce match
    $sql_mise_existante = "SELECT * FROM mise WHERE utilisateur_id = $utilisateurId AND match_id = $matchId";
   $result_mise_existante = $conn->query($sql_mise_existante);

    if ($result_mise_existante->num_rows > 0) {
       
        $row_mise = $result_mise_existante->fetch_assoc();
        $miseId = $row_mise['id_mise'];
        $miseEquipeId = $row_mise['equipe_id'];
        $miseMontant = $row_mise['montant'];
        ?>
        <h2>Mise existante pour ce match :</h2>
        <form method="post" action="mise_actualiser.php">
            <input type="hidden" name="mise_id" value="<?php echo $miseId; ?>">
            <input type="hidden" name="match_id" value="<?php echo $matchId; ?>">
            Montant de la mise : <input type="number" name="montant" value="<?php echo $miseMontant; ?>"><br>
            <input type="submit" name="actualiser" value="Actualiser la mise">
        </form>
        <?php
    } else {
        // afficher le formulaire de nouvelle mise
        $sql_cotes = "SELECT * FROM cote WHERE match_id = $matchId";
        $result_cotes = $conn->query($sql_cotes);
        ?>

        <h2>Nouvelle mise pour ce match :</h2>
        <form method="post" action="mise_enregistrer.php">
            <input type="hidden" name="match_id" value="<?php echo $matchId; ?>">

            <?php while ($row_cote = $result_cotes->fetch_assoc()) {
                $coteEquipeId = $row_cote['equipe_id'];
                $coteValeur = $row_cote['valeur'];

                // Récupérer le nom de l'équipe à partir de son ID
                $sql_equipe = "SELECT nom FROM equipe WHERE id = $coteEquipeId";
                $result_equipe = $conn->query($sql_equipe);
                $row_equipe = $result_equipe->fetch_assoc();
                $equipeNom = $row_equipe['nom'];
                ?>

                <input type="radio" name="equipe_id" value="<?php echo $coteEquipeId; ?>"> <?php echo $equipeNom; ?> (Cote <?php echo $coteValeur; ?>)<br>

            <?php } ?>

            Montant de la mise : <input type="number" name="montant"><br>
            <input type="submit" name="valider" value="Valider la mise">
        </form>

    <?php }
} else {
   echo "Vous devez être connecté pour pouvoir effectuer une mise.";
}


?>