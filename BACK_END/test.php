<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'super_bowl');

// Vérification de la connexion
if ($conn->connect_error) {
die("Erreur de connexion à la base de données : " . $conn->connect_error);
}


   //requete pour connaitre l'id de l'equipe
   $sql1 = "SELECT COUNT(*) AS total FROM equipe ";
   $resultIDequipe = $conn->query($sql1);
if ($resultIDequipe->num_rows == 1) {
    // Récupérer le nombre d'utilisateurs
    $row = $resultIDequipe->fetch_assoc();
    $nombreidEquipe = $row['total'];
}

  //requete pour connaitre l'id de le joueur
  $sql1 = "SELECT COUNT(*) AS total FROM joueur ";
  $resultIDjoueur = $conn->query($sql1);
if ($resultIDjoueur->num_rows == 1) {
   // Récupérer le nombre d'utilisateurs
   $row = $resultIDjoueur->fetch_assoc();
   $nombreidJoueur = $row['total'];
}

  // Requête pour récupérer les équipes existantes
  //$ $sql2 = "SELECT * FROM equipe";
  //$ $result2 = $conn->query($sql2);
 //$ if (!empty($result2->num_rows)) {
 //$ while ($row = $result2->fetch_assoc()) {
  //$ echo "<option value='" . $row['id_equipe'] . "'>" . $row['nom_equipe'] . "</option>";
 //$    }}else{echo '<option value="">Aucune équipe trouvée</option>';} 

// Vérification du formulaire d'ajout d'équipe
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'creer_equipe') {
        $nomEquipe = $_POST['nom_equipe'];
        $pays = $_POST['pays'];
        $id_equipe=$nombreidEquipe+1;
        creerEquipe($id_equipe,$nomEquipe, $pays);
    }
}
// Fonction pour créer une équipe
function creerEquipe($id_equipe,$nomEquipe, $pays){
    global $conn;
    $sql = "INSERT INTO equipe (id_equipe ,nom_equipe, pays) VALUES ('$id_equipe','$nomEquipe', '$pays')";
    if ($conn->query($sql) === TRUE) {
        echo "Équipe créée avec succès.";
    } else {  echo "Erreur lors de la création de l'équipe : " . $conn->error; }
}

// Vérification du formulaire d'ajout de joueur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action1']) && $_POST['action1'] === 'creer_joueur') {
        $equipeId = $_POST['equipe_id'];
        $nomJoueur = $_POST['nom_joueur'];
        $id_joueur=$nombreidJoueur+1;
$prenomJoueur = $_POST['prenom_joueur'];
        $numeroJoueur = $_POST['numero_joueur'];
        creerJoueur($id_joueur,$equipeId, $nomJoueur, $prenomJoueur, $numeroJoueur);
    }
}
// Fonction pour créer un joueur
function creerJoueur($id_joueur,$equipeId, $nomJoueur, $prenomJoueur, $numeroJoueur) {
    global $conn;
    $sql1 = "INSERT INTO joueur (id_joueur,equipe_id, nom_joeur, prenom_joueur, numero_joeur) VALUES ('$id_joueur','$equipeId', '$nomJoueur', '$prenomJoueur', '$numeroJoueur')";
    if ($conn->query($sql1) === TRUE) {
        echo "Joueur créé avec succès."; } 
   else {    echo "Erreur lors de la création du joueur : " . $conn->error; }
}
             
// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;}

        .form-group {  margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 
           
10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 
           
5px;
            cursor: pointer;
        }
    </style><title>Espace administrateur </title>

<body>
    <class="container">
    <h1>Espace administrateur </h1>
        <h2>Créer une équipe</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="action" value="creer_equipe">
            <div class="form-group">
                <label for="nom_equipe">Nom de l'équipe :</label>
                <input type="text" id="nom_equipe" name="nom_equipe" required>
            </div>
            <div class="form-group">
                <label for="pays">Pays :</label>
                <input type="text" id="pays" name="pays" required>
            </div>
            <div class="form-group">
                <button type="submit">Créer équipe</button>
            </div>
        </form>
    </div>
    <h2>Créer un joueur</h2>
    <div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="action1" value="creer_joueur">
            <label for="equipe_id">Équipe :</label>
            <input type="radio" id="equipe" name="equipe_id" value="TUN" /> TUN
            <input type="radio" id="equipe" name="civilite_id" value="FR" /> FR
            <input type="radio" id="equipe" name="equipe_id" value="ALG" /> ALG
             //   <select name="equipe" id="equipe_id">
              //    <option value='0'>TUN</option>";
              //    <option value='1'>FR</option>";
             //     <option value='2'>ALG</option>";
              //  </select>
            <div class="form-group">
                <label for="nom_joueur">Nom :</label>
                <input type="text" id="nom_joueur" name="nom_joueur" required>
            </div>
            <div class="form-group">
                <label for="prenom_joueur">Prénom :</label>
                <input type="text" id="prenom_joueur" name="prenom_joueur" required>
            </div>
            <div class="form-group">
                <label for="numero_joueur">Numéro :</label>
                <input type="text" id="numero_joueur" name="numero_joueur" required>
            </div>
            <div class="form-group">
                <button type="submit">Créer un joueur</button>
            </div>
        </form>
                </div>
</body>
</html>