<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pending Users</title>

   <style>
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

      .back-btn {
         float: left;
         padding:40px;
        
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
   margin-left:-730px;
   margin-top:90px;
}

.status-button {
         /* Updated styles for the status buttons */
         padding: 8px 16px;
         font-size: 14px;
         border: 0px solid black; /* Black border */
         border-radius: 5px;
         cursor: pointer;
         margin: 0 10px;
         font-weight: bold;
         text-align: center;
         font-size: 18px; /* Increased font size */
         text-transform: uppercase;
         text-decoration: none; /* Remove underline */
      }

      /* Styling for specific statuses */
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

      body {
         margin: 0;
         padding: 0;
         background-color: #f1f1f1;
         font-family: Arial, sans-serif;
      }
   
   </style>
</head>
<body>
<a href="admin.php" class="back-btn">Retour à la page Admin</a>
   <div class="container">
      <div class="status-buttons">
         <a href="list_accepted.php" class="status-button confirmed-button">Confirmé</a>
         <a href="list_rejected.php" class="status-button rejected-button">Rejeté</a>
         <a href="list_pending.php" class="status-button pending-button">En attente</a>
      </div>

      <?php
      include 'config.php';

      $query = mysqli_query($conn, "SELECT * FROM `bank` WHERE `Situation` = 'Not confirmed'");
      if (mysqli_num_rows($query) === 0) {
         echo '<p style="font-size: 24px; font-weight: bold; text-align: center; margin-top: 20px;">Nothing</p>';
      } else {
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
            <p>Situation: <span style="color: orange; font-weight: bold; font-size: 18px;">En Attente</span></p>
         </div>
      </div>
      <?php
         }
      }
      ?>
   </div>

   <!-- ... Your JavaScript ... -->

</body>
</html>
