<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
   <style>
      body {
         margin: 0;
         padding: 0;
         background-color: #f1f1f1;
         font-family: Arial, sans-serif;
      }

      .container {
         max-width: 800px;
         margin: 0 auto;
         padding: 20px;
      }

      .user-card {
         background-color: #fff;
         padding: 20px;
         margin: 20px;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .user-info {
         flex: 1;
      }

      .user-actions {
         flex: 0;
         display: flex;
         gap: 10px;
      }

      .btn {
         padding: 8px 16px;
         font-size: 14px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
      }

      .accept-btn {
         background-color: green;
         color: white;
         font-weight: bold;
      }

      .reject-btn {
         background-color: red;
         color: white;
         font-weight: bold;
      }

      .pending-btn {
         background-color: orange;
         color: white;
         font-weight: bold;
      }

      .back-btn {
         float: left;
         padding: 40px;
         font-size: 40px;
         font-weight: bold;
         text-decoration: none;
         color: #333;
      }

      .user-image {
         width: 100px;
         height: 100px;
         border-radius: 5px;
         object-fit: cover;
      }

      .status-buttons {
         display: flex;
         margin-left: -20px;
         margin-top: 20px;
      }

      .status-button {
         padding: 8px 16px;
         font-size: 14px;
         border: 1px solid black;
         border-radius: 5px;
         cursor: pointer;
         margin: 0 10px;
         font-weight: bold;
         text-align: center;
         text-transform: uppercase;
         text-decoration: none;
      }

      .confirmed-button {
         background-color: green;
         color: white;
      }

      .rejected-button {
         background-color: red;
         color: white;
      }

      .pending-button {
         background-color: orange;
         color: white;
      }
      .ciel-button {
   background-color: lightblue; /* Couleur bleu ciel */
   color: black; /* Couleur du texte */
   font-weight: bold;
}
   </style>
</head>
<body>
   <a href="login.php" class="back-btn">Retour à l'accueil</a>
   
   <div class="container">
      <div class="status-buttons">
         <a href="list_pending.php" class="status-button pending-button">En attente</a>
         <a href="list_accepted.php" class="status-button confirmed-button">Accepté</a>
         <a href="list_rejected.php" class="status-button rejected-button">Rejeté</a>
         <a href="list_vehicule.php" class="status-button ciel-button">Tous les véhicules stationnés</a>

      </div>

      <?php
      include 'config.php';
      session_start();

      // Check if user is an admin
      if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
          header('location:login.php'); // Redirect non-admin users
          exit();
      }

      // Handle accept and reject actions
      if (isset($_GET['action']) && isset($_GET['user_id'])) {
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

          if ($_GET['action'] === 'reject') {
              // Update user's Situation column to "Rejected"
              mysqli_query($conn, "UPDATE `bank` SET `Situation` = 'Rejected' WHERE `id` = '$user_id'");
          }
          if ($_GET['action'] === 'accept') {
              // Update user's Situation column to "Confirmed"
              mysqli_query($conn, "UPDATE `bank` SET `Situation` = 'Confirmed' WHERE `id` = '$user_id'");
          }
      }

      $query = mysqli_query($conn, "SELECT * FROM `bank`  ");
      while ($row = mysqli_fetch_assoc($query)) {
      ?>
      <div class="user-card" id="userCard_<?php echo $row['id']; ?>">
         <div class="user-info">
            <?php
            if (!empty($row['image'])) {
               echo '<img src="uploaded_img/' . $row['image'] . '" alt="User Image" class="user-image">';
            } else {
               echo '<img src="uploaded_img/download.jpg" alt="User Image" class="user-image">';
            }
            ?>
            <p>Email: <?php echo $row['email']; ?></p>
            <p>CIN: <?php echo $row['cin']; ?></p>
            <p>Profession: <?php echo $row['Profession']; ?></p>
            <p>Situation: <span style="color: <?php echo $row['Situation'] === 'Confirmed' ? 'green' : ($row['Situation'] === 'Rejected' ? 'red' : 'orange'); ?>"><?php echo $row['Situation']; ?></span></p>

         </div>
         <div class="user-actions">
            <button class="btn accept-btn" onclick="handleAction('accept', <?php echo $row['id']; ?>)">Accepte</button>
            <button class="btn reject-btn" onclick="handleAction('reject', <?php echo $row['id']; ?>)">Rejeté</button>
         </div>
      </div>
      <?php
      }
      ?>

   </div>

   <script>
      function handleAction(action, user_id) {
         const xhr = new XMLHttpRequest();
         xhr.open('GET', `admin.php?action=${action}&user_id=${user_id}`, true);
         xhr.onload = function() {
            if (xhr.status === 200) {
               if (action === 'reject') {
                  const userCard = document.getElementById(`userCard_${user_id}`);
                  if (userCard) {
                     userCard.remove();
                  }
               } else {
                  location.reload();
               }
            }
         };
         xhr.send();
      }
   </script>
</body>
</html>


