<?php
include 'config.php';

if(isset($_POST['submit'])){
   $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
   $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
   $place_of_birth = mysqli_real_escape_string($conn, $_POST['place_of_birth']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $cin = mysqli_real_escape_string($conn, $_POST['cin']);
   $cin_date = mysqli_real_escape_string($conn, $_POST['cin_date']);
   $profession = mysqli_real_escape_string($conn, $_POST['profession']);
   $birth_country = mysqli_real_escape_string($conn, $_POST['birth_country']);
   $residence_country = mysqli_real_escape_string($conn, $_POST['residence_country']);
   $password = $_POST['password'];
   $cpassword = $_POST['cpassword'];

   $select = mysqli_query($conn, "SELECT * FROM `bank` WHERE email = '$email'") or die('Query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'Utilisateur existe déjà'; 
   } else {
      if($password != $cpassword){
         $message[] = 'Mot de passe de confirmation ne correspond pas !';
      } else {
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);

         $insert = mysqli_query($conn, "INSERT INTO `bank` (`Nom complet`, `date de naissance`, `lieu de naissance`, `email`, `cin`, `dateCin`, `Profession`, `pays de naissance`, `pays de residence`, `mot_de_passe`)
                                       VALUES ('$full_name', '$date_of_birth', '$place_of_birth', '$email', '$cin', '$cin_date', '$profession', '$birth_country', '$residence_country', '$hashed_password')")
                                       or die('Query failed');

         if($insert){
            $message[] = 'Inscription réussie !';
            header('location: login.php');
         } else {
            $message[] = 'Échec de l\'inscription !';
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
   <title>Inscription</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>S'inscrire maintenant</h3>
      <?php
      if(isset($message)){
         foreach($message as $msg){
            echo '<div class="message">'.$msg.'</div>';
         }
      }
      ?>
      <input type="text" name="full_name" placeholder="Nom et Prénom" class="box" required>
      <label for="date_of_birth">Date de Naissance</label>
      <input type="date" name="date_of_birth" class="box" required>
      <input type="text" name="place_of_birth" placeholder="Lieu de Naissance" class="box" required>
      <input type="email" name="email" placeholder="Email" class="box" required>
      <input type="text" name="cin" placeholder="CIN" class="box" required>
      <label for="cin_date">Date de CIN</label>
      <input type="date" name="cin_date" class="box" required>
      <input type="text" name="profession" placeholder="Profession" class="box" required>
      <input type="text" name="birth_country" placeholder="Pays de Naissance" class="box" required>
      <input type="text" name="residence_country" placeholder="Pays de Résidence" class="box" required>
      <input type="password" name="password" placeholder="Mot de Passe" class="box" required>
      <input type="password" name="cpassword" placeholder="Confirmez votre mot de passe" class="box" required>
      <input type="submit" name="submit" value="S'inscrire maintenant" class="btn">
      <p>Vous avez déjà un compte? <a href="login.php">Se connecter maintenant</a></p>
   </form>
</div>

</body>
</html>



