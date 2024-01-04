<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

if (!isset($_SESSION['decision_data'])) {
    header('location: home.php');
    exit();
}

$decision_data = $_SESSION['decision_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Décision</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<div class="decision-container">
   <h3>Informations de l'utilisateur</h3>
   <ul>
      <li><strong>Nom Complet:</strong> <?php echo $decision_data['full_name']; ?></li>
      <li><strong>Date de Naissance:</strong> <?php echo $decision_data['date_of_birth']; ?></li>
      <li><strong>Lieu de Naissance:</strong> <?php echo $decision_data['place_of_birth']; ?></li>
      <!-- Ajoutez les autres informations ici -->
   </ul>

   <form action="process_decision.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <button type="submit" name="decision" value="accept">Accepter</button>
      <button type="submit" name="decision" value="reject">Refuser</button>
   </form>
</div>

</body>
</html>
