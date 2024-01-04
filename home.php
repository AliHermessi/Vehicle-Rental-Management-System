<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['logout'])){
   unset($_SESSION['user_id']);
   session_destroy();
   header('location:login.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Accueil</title>

   <!-- Lien vers le fichier CSS personnalisé -->
   <link rel="stylesheet" href="style.css">

   <!-- Ajout d'une classe CSS pour le bouton "Stationnez votre voiture" -->
   <style>
      .station-button {
         background-color: green;
         color: white;
      }
      .station-button-2 {
         background-color: orange;
         color: white;
      }
      .back-to-home {
         position: absolute;
         top: 10px;
         left: 10px;
         font-weight: bold;
         text-decoration: none;
         color: #000;
         font-size:45px;
      }
       
        

        h1 {
            color: #00008b; /* Dark blue color for the title */
            padding: 15px; /* Increased padding for the title */
            text-align: center;
            font-size: 24px; /* Bigger text size for the title */
            font-weight: bold; /* Bold title text */
        }

        table {
            
            border-collapse: collapse;
            margin-top: 10px; /* Slightly higher up */
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 12px; /* Slightly larger padding for table cells */
            text-align: left;
        }
        .table_container{
         display: flex;
    justify-content: center;
    align-items: center;
        }
   </style>
</head>
<body>
<a class="back-to-home" href="login.php">Back to Menu</a>
<div class="container">

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `bank` WHERE `id` = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="images/unknown.jpg">';
         } else {
            echo '<img src="uploaded_img/download.jpg'.$fetch['image'].'">';
         }
         
         // Check the user's Situation and display appropriate message
         if ($fetch['Situation'] === 'Rejected') {
            echo '<p class="rejected-message">You have been Rejected</p>';
         }
         else {
            echo '<h3>' . $fetch['Nom complet'] . '</h3>';
            echo '<a href="update_profile.php" class="btn">Mise à jour votre profil</a>';
            // Lien vers formulaire.php lorsque vous cliquez sur le bouton "Stationnez votre voiture"
            echo '<a href="formulaire.php" class="btn station-button">Stationnez votre voiture</a>';
            echo '<a href="list_voiture_user.php" class="btn station-button-2">List de vos voiture</a>';
         }
      ?>
      <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Se déconnecter</a>
   </div>

</div>


</div>
</body>
</html>
