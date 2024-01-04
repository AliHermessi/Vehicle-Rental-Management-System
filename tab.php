<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Liste des Véhicules Stationnés</title>
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

      table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
      }

      table, th, td {
         border: 1px solid #ddd;
      }

      th, td {
         padding: 10px;
         text-align: left;
      }

      th {
         background-color: #f2f2f2;
      }

      tr:hover {
         background-color: #f5f5f5;
      }

      .back-btn {
         float: left;
         padding: 10px;
         font-size: 18px;
         font-weight: bold;
         text-decoration: none;
         color: #333;
      }
   </style>
</head>
<body>
    <a href="admin.php" class="back-btn">Retour à la page Admin</a>
   
   <div class="container">
      <h1>Liste des Véhicules Stationnés</h1>
      <table>
         <tr>
            <th>Nom du Propriétaire du Véhicule</th>
            <th>Nom du Véhicule</th>
            <th>Numéro du Véhicule</th>
            <th>Date d’Entrée (Date et Heure)</th>
            <th>Date de Sortie (Date et Heure)</th>
            <th>Numéro de Jeton</th>
         </tr>

         <?php
         include 'config.php';

         $query = mysqli_query($conn, "SELECT * FROM `vehicule`");
         while ($row = mysqli_fetch_assoc($query)) {
            echo '<tr>';
            echo '<td>' . $row['nom_proprietaire'] . '</td>';
            echo '<td>' . $row['nom_vehicule'] . '</td>';
            echo '<td>' . $row['numero_vehicule'] . '</td>';
            echo '<td>' . $row['date_entree'] . '</td>';
            echo '<td>' . $row['date_sortie'] . '</td>';
            echo '<td>' . $row['numero_jeton'] . '</td>';
            echo '</tr>';
         }
         ?>
      </table>
   </div>
</body>
</html>
