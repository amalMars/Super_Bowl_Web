<?php
$conn = new mysqli('localhost', 'root', 'root', 'super_bowl');
function creerEquipe($id_equipe,$nomEquipe, $pays){
    global $conn;
    $sql = "INSERT INTO equipe (id_equipe ,nom_equipe, pays) VALUES ('$id_equipe','$nomEquipe', '$pays')";
    if ($conn->query($sql) === TRUE) {
        echo "Équipe créée avec succès.";
    } else {  echo "Erreur lors de la création de l'équipe : " . $conn->error; }
}

?>