<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    mysqli_query($conn, "UPDATE `bank` SET `Nom complet` = '$update_name', `email` = '$update_email' WHERE `id` = '$user_id'") or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = isset($_POST['update_pass']) ? mysqli_real_escape_string($conn, $_POST['update_pass']) : '';
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_pass']);

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        $select_pass = mysqli_query($conn, "SELECT `mot_de_passe` FROM `bank` WHERE `id` = '$user_id'") or die('query failed');
        $row = mysqli_fetch_assoc($select_pass);
        $hashed_old_pass = $row['mot_de_passe'];

        if (password_verify($old_pass, $hashed_old_pass)) {
            if ($new_pass != $confirm_pass) {
                $message[] = 'Confirm password not matched!';
            } else {
                $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE `bank` SET `mot_de_passe` = '$hashed_new_pass' WHERE `id` = '$user_id'") or die('query failed');
                $message[] = 'Password updated successfully!';
            }
        } else {
            $message[] = 'Old password incorrect!';
        }
    }

    $update_image_name = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image_name;

    if (!empty($update_image_name)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large';
        } else {
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
            mysqli_query($conn, "UPDATE `bank` SET `image` = '$update_image_name' WHERE `id` = '$user_id'") or die('query failed');
            $message[] = 'Image updated successfully!';
        }
    }
}

$select_user = mysqli_query($conn, "SELECT * FROM `bank` WHERE `id` = '$user_id'") or die('query failed');
$fetch_user = mysqli_fetch_assoc($select_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="style.css">
</head>
<body>
   
<div class="update-profile">
   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if ($fetch_user['image'] == '') {
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="uploaded_img/' . $fetch_user['image'] . '">';
         }
         if (isset($message)) {
            foreach ($message as $msg) {
               echo '<div class="message">' . $msg . '</div>';
            }
         }
         $situation = $fetch_user['Situation'];
         $situationColor = ($situation == 'Not Confirmed') ? 'red' : 'green';
         echo '<span style="color: ' . $situationColor . ';">Situation: ' . $situation . '</span>';
      ?>
      
      <div class="flex">
         <div class="inputBox">
            <span>Nom Complet:</span>
            <input type="text" name="update_name" value="<?php echo $fetch_user['Nom complet']; ?>" class="box">
            <span>Ton Email:</span>
            <input type="email" name="update_email" value="<?php echo $fetch_user['email']; ?>" class="box">
            <span>Mise à jour ta photo:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="">
            <span>Ancien Mot de Passe:</span>
            <input type="password" name="old_pass" placeholder="Entrez l'ancien mot de passe" class="box">
            <span>Nouveau Mot de Passe:</span>
            <input type="password" name="new_pass" placeholder="Entrez votre nouveau mot de passe" class="box">
            <span>Confirmer Votre Mot de Passe:</span>
            <input type="password" name="confirm_pass" placeholder="Confirmer votre mot de passe" class="box">
         </div>
      </div>
      <input type="submit" value="Mettre à jour le profil" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">Retour</a>
   </form>
</div>

</body>
</html>

