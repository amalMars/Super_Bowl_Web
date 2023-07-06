<?php
$servername = "localhost"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur de la base de données
$password = ""; // Mot de passe de la base de données
$dbname = "super_bowl"; // Nom de la base de données

$conn = new mysqli($servername, $username, $password, $dbname);
// Vérifier si le formulaire d'inscription est soumis
if (isset($_POST['submit'])) {
    // Connexion à la base de données


    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // Générer un code de validation
    $code_validation = md5(uniqid(rand(), true));

    // Insérer l'utilisateur dans la base de données
    // Assurez-vous de configurer la connexion à la base de données avant d'exécuter cette requête
    $sql = "INSERT INTO utilisateur (nom, prenom, email,mot_passe, email_val) VALUES ('$nom', '$prenom', '$email','$motdepasse', '$code_validation')";

    // Exécuter la requête
    // Assurez-vous de configurer la connexion à la base de données avant d'exécuter cette requête
    if ($conn->query($sql) === TRUE) {
        // Envoyer un e-mail de validation
     //$   $sujet = "Validation d'inscription";
      //$  $message = "Bienvenue sur notre site !";
      //$  $headers = "From: no-reply@example.com" . "\r\n" . "Reply-To: admin@example.com" . "\r\n" . "X-Mailer: PHP/" . phpversion();
       //$ ini_set("SMTP", $email);
       //$ ini_set("smtp_port", "587");
       //$ ini_set("sendmail_from", $email);
        // Utilisez la fonction mail() pour envoyer l'e-mail
        //mail($email, $sujet, $message, $headers);

        // Rediriger vers une page de succès
        header("Location: menu.php");
        echo "inscription avec succes";
       exit;
    } else {
        // Gérer les erreurs d'insertion dans la base de données
        echo "Erreur lors de l'inscription : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <input type="submit" name="submit" value="S'inscrire">
        </form>
    </div>
    <div class="container">
        <h2>Se connecter</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="motdepasse" placeholder="Mot de passe" required>
            <input type="submit" name="submit1" value="Se connecter">
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

h2 {
    text-align: center;
}

input[type="text"],
input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}
</style>