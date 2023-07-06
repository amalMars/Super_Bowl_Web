<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'super_bowl');

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}


// Vérification de la soumission du formulaire de connexion
if (isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];
    
// Initialisation de la session
session_start();

    // Requête pour récupérer les informations de l'utilisateur en fonction de l'e-mail
    $sql = "SELECT * FROM utilisateur WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // L'utilisateur existe, vérification du mot de passe
        $row = $result->fetch_assoc();
       //$ if (password_verify($motdepasse, $row['mot_passe'])) {
            // Mot de passe correct, création de la session utilisateur
            $_SESSION['utilisateur_id'] = $row['id_utilisateur'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];

            // Redirection vers la page d'accueil
            header("Location: menu.php?utilisateur_id=" .$row['id_utilisateur']. "");
            exit();
       //$ } else {
            // Mot de passe incorrect
         //$   $erreurConnexion = "Mot de passe incorrect";
        //$ }
    } else {
        // Utilisateur non trouvé
        $erreurConnexion = "Utilisateur non trouvé";
    }
}else{echo"error";}



// Vérification de la soumission du formulaire d'inscription
if (isset($_POST['inscription'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Hachage du mot de passe
    //$ $motdepasseHash = password_hash($motdepasse, PASSWORD_DEFAULT);

    // Requête d'insertion de l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateur (nom, prenom, email, mot_passe) VALUES ('$nom', '$prenom', '$email', '$motdepasse')";

    if ($conn->query($sql) === TRUE) {
        // Utilisateur inscrit avec succès
        $inscriptionReussie = true;
    } else {
        // Erreur lors de l'inscription
        $erreurInscription = "Erreur lors de l'inscription : " . $conn->error;
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authentification et Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <input type="submit" name="connexion" value="Se connecter">
        </form>

        <h2>Inscription</h2>
        <?php if (isset($inscriptionReussie)) { ?>
            <div class="succes">Inscription réussie !</div>
        <?php } elseif (isset($erreurInscription)) { ?>
            <div 
           
class="erreur"><?php echo $erreurInscription; ?></div>
        <?php } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <input type="submit" name="inscription" value="S'inscrire">
        </form>
    </div>
</body>
</html>

<style>
.container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
}

h2 {  text-align: center;}

input[type="text"],
h2 {text-align: center;}


input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

input[type="submit"] {
    width:100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

.erreur {
    color: red;
}

.succes {
    color: white;
    border: none;
    cursor: pointer;
}

.erreur {
    color: white;
    border: none;
    cursor: pointer;
}
    </style>