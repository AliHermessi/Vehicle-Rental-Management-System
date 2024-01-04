<?php
include 'config.php';

// Initialiser des variables pour stocker les messages d'erreur ou de succès
$message = '';

if (isset($_POST['submit'])) {
    $nom_proprietaire = mysqli_real_escape_string($conn, $_POST['nom_proprietaire']);
    $nom_vehicule = mysqli_real_escape_string($conn, $_POST['nom_vehicule']);
    $numero_vehicule = mysqli_real_escape_string($conn, $_POST['numero_vehicule']);
    $date_entree = mysqli_real_escape_string($conn, $_POST['date_entree']);
    $date_sortie = mysqli_real_escape_string($conn, $_POST['date_sortie']);
    $numero_jeton = mysqli_real_escape_string($conn, $_POST['numero_jeton']);

    // Vérification si le numéro de jeton est strictement positif
    if ($numero_jeton <= 0) {
        $message = '<p style="color: red;">Le numéro de jeton doit être strictement positif.</p>';
    } else {
        // Vérification si le numéro de jeton n'a pas déjà été utilisé
        $check_jeton = mysqli_query($conn, "SELECT * FROM vehicule WHERE numero_jeton = '$numero_jeton'");
        if (mysqli_num_rows($check_jeton) > 0) {
            $message = '<p style="color: red;">Ce numéro de jeton a déjà été utilisé.</p>';
        } else {
            // Vérifications supplémentaires sur les champs "Nom du Propriétaire du Véhicule," "Nom du Véhicule," et "Numéro du Véhicule"
            if (!preg_match("/^[a-zA-Z ]*$/", $nom_proprietaire) || !preg_match("/^[a-zA-Z ]*$/", $nom_vehicule) || !preg_match("/^[a-zA-Z0-9 ]*$/", $numero_vehicule)) {
                $message = '<p style="color: red;">Les champs "Nom du Propriétaire du Véhicule," "Nom du Véhicule," et "Numéro du Véhicule" doivent être des chaînes de caractères.</p>';
            } else {
                // Insertion des données dans la base de données
                $insert = mysqli_query($conn, "INSERT INTO vehicule (nom_proprietaire, nom_vehicule, numero_vehicule, date_entree, date_sortie, numero_jeton)
                VALUES ('$nom_proprietaire', '$nom_vehicule', '$numero_vehicule', '$date_entree', '$date_sortie', '$numero_jeton')");

                if ($insert) {
                    $message = '<p style="color: green;">Données insérées avec succès !</p>';
                } else {
                    $message = '<p style="color: red;">Erreur lors de l\'insertion des données : ' . mysqli_error($conn) . '</p>';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Formulaire de Stationnement</title>
   <link rel="stylesheet" href="style.css">
   <style>
        .back-to-home {
         position: absolute;
         top: 10px;
         left: 10px;
         font-weight: bold;
         text-decoration: none;
         color: #000;
         font-size:45px;
      }
       </style>
</head>
<body>
<a class="back-to-home" href="home.php">Back to Home</a>
<div class="form-container">
   <form action="formulaire.php" method="post" enctype="multipart/form-data">
      <h3>Formulaire de Stationnement</h3>
      <?php echo $message; ?>
      <label for="nom_proprietaire">Nom du Propriétaire du Véhicule</label>
      <input type="text" name="nom_proprietaire" class="box" required>
      
      <label for="nom_vehicule">Nom du Véhicule</label>
      <input type="text" name="nom_vehicule" class="box" required>
      
      <label for="numero_vehicule">Numéro du Véhicule</label>
      <input type="text" name="numero_vehicule" class="box" required>
      
      <label for="date_entree">Date d'Entrée (Date et Heure)</label>
      <input type="datetime-local" name="date_entree" class="box" required>

      <!-- Nouveau champ pour la Date de Sortie -->
      <label for="date_sortie">Date de Sortie (Date et Heure)</label>
      <input type="datetime-local" name="date_sortie" class="box" required>
      
      <label for="numero_jeton">Numéro de Jeton</label>
      <input type="number" name="numero_jeton" class="box" required>
      
      <input type="submit" name="submit" value="Soumettre" class="btn">
   </form>
</div>

</body>
</html>
