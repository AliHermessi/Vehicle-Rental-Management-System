<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $adminEmail = 'admin@yahoo.com';
   $adminmdp = '123'; 

   if ($email === $adminEmail && $password === $adminmdp) {
      $_SESSION['is_admin'] = true; // Set the admin flag in session
      header('location:admin.php'); // Redirect to admin page
      exit(); // Exit to prevent further execution
   }
   
   // Regular user authentication
   $select = mysqli_query($conn, "SELECT * FROM `bank` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      if(password_verify($password, $row['mot_de_passe'])){
         $_SESSION['user_id'] = $row['id'];
         $_SESSION['nom'] = $row['Nom complet'];
         header('location:home.php'); // Redirect to home page for regular users
         exit(); // Exit to prevent further execution
      } else {
         $message[] = 'Adresse email ou mot de passe incorrect !';
      }
   } else {
      $message[] = 'Adresse email ou mot de passe incorrect !';
   }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Connexion</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Se connecter</h3>
      <?php
      if(isset($message)){
         foreach($message as $msg){
            echo '<div class="message">'.$msg.'</div>';
         }
      }
      ?>
      <input type="email" name="email" placeholder="Saisissez votre email" class="box" required>
      <input type="password" name="password" placeholder="Saisissez votre mot de passe" class="box" required>
      <input type="submit" name="submit" value="Se connecter" class="btn">
      <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire maintenant</a></p>
   </form>

</div>

</body>
</html>
