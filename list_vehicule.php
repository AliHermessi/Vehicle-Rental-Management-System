<?php
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $config_file = 'config.php';
   include $config_file;

    if (isset($_POST['save'])) {
        // Handle the save action here
        $id = $_POST['id'];
        $nom_proprietaire = $_POST['nom_proprietaire'];
        $nom_vehicule = $_POST['nom_vehicule'];
        $numero_vehicule = $_POST['numero_vehicule'];
        $date_entree = $_POST['date_entree'];
        $date_sortie = $_POST['date_sortie'];

        // Update the database with the new values
        $update_query = mysqli_prepare($conn, "UPDATE vehicule SET nom_proprietaire=?, nom_vehicule=?, numero_vehicule=?, date_entree=?, date_sortie=? WHERE id=?");
        mysqli_stmt_bind_param($update_query, "sssssi", $nom_proprietaire, $nom_vehicule, $numero_vehicule, $date_entree, $date_sortie, $id);
        if (mysqli_stmt_execute($update_query)) {
            // Successfully updated
            header("Location: list_vehicule.php"); // Redirect to the page
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['delete'])) {
        // Handle the delete action here
        $id = $_POST['id'];

        // Delete the record from the database
        $delete_query = mysqli_prepare($conn, "DELETE FROM vehicule WHERE id=?");
        mysqli_stmt_bind_param($delete_query, "i", $id);
        if (mysqli_stmt_execute($delete_query)) {
            // Successfully deleted
            header("Location: list_vehicule.php"); // Redirect to the page
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['add'])) {
      // Handle the add action here
      $nom_proprietaire = $_POST['new_nom_proprietaire'];
      $nom_vehicule = $_POST['new_nom_vehicule'];
      $numero_vehicule = $_POST['new_numero_vehicule'];
      $date_entree = $_POST['new_date_entree'];
      $date_sortie = $_POST['new_date_sortie'];

      // Insert the new record into the database
      $insert_query = mysqli_prepare($conn, "INSERT INTO vehicule (nom_proprietaire, nom_vehicule, numero_vehicule, date_entree, date_sortie) VALUES (?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($insert_query, "sssss", $nom_proprietaire, $nom_vehicule, $numero_vehicule, $date_entree, $date_sortie);
      if (mysqli_stmt_execute($insert_query)) {
          // Successfully inserted
          header("Location: list_vehicule.php"); // Redirect to the page
          exit();
      } else {
          echo "Error inserting record: " . mysqli_error($conn);
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
    <title>Liste des Véhicules Stationnés</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            
            background-color: #fff; /* White background for the container */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Add a slight shadow */
            padding: 20px;
            overflow-x: auto;
        }

        h1 {
            color: #00008b; /* Dark blue color for the title */
            padding: 15px; /* Increased padding for the title */
            text-align: center;
            font-size: 24px; /* Bigger text size for the title */
            font-weight: bold; /* Bold title text */
        }

        table {
            width: 100%;
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

        /* Style for buttons */
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        .save-button {
            background-color: green;
            color: white;
        }

        .delete-button {
            background-color: red;
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
    </style>
</head>
<body>
<div class="container">
<a class="back-to-home" href="admin.php">Back to Admin home page</a>
    <h1>Liste des Véhicules Stationnés</h1>

    <?php
     $config_file = 'config.php';
     include $config_file;
    $query = mysqli_query($conn, "SELECT * FROM vehicule");

    if (mysqli_num_rows($query) > 0) {
        echo '<table>';
        echo '<tr><th>Nom du Propriétaire</th><th>Nom du Véhicule</th><th>Numéro du Véhicule</th><th>Date d\'Entrée</th><th>Date de Sortie</th><th>Actions</th></tr>';
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<form method="POST">'; // Start form
            echo '<tr>';
            echo '<td><input type="text" name="nom_proprietaire" value="' . $row['nom_proprietaire'] . '"></td>';
            echo '<td><input type="text" name="nom_vehicule" value="' . $row['nom_vehicule'] . '"></td>';
            echo '<td><input type="text" name="numero_vehicule" value="' . $row['numero_vehicule'] . '"></td>';
            echo '<td><input type="datetime-local" name="date_entree" value="' . date('Y-m-d\TH:i', strtotime($row['date_entree'])) . '"></td>';
            echo '<td><input type="datetime-local" name="date_sortie" value="' . date('Y-m-d\TH:i', strtotime($row['date_sortie'])) . '"></td>';
            echo '<td>';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">'; // Hidden input for ID
            echo '<div class="button-container">';
            echo '<button type="submit" name="save" class="button save-button">Save</button>';
            echo '<button type="submit" name="delete" class="button delete-button">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</form>'; // End form
        }
        echo '</table>';
    } else {
        echo '<p>Aucun véhicule stationné pour le moment.</p>';
    }
    ?>
    <!-- Form for adding new data -->
    <form method="POST">
        <table>
            <tr>
                <td><input type="text" name="new_nom_proprietaire" placeholder="Nom du Propriétaire"></td>
                <td><input type="text" name="new_nom_vehicule" placeholder="Nom du Véhicule"></td>
                <td><input type="text" name="new_numero_vehicule" placeholder="Numéro du Véhicule"></td>
                <td><input type="datetime-local" name="new_date_entree" placeholder="Date d'Entrée"></td>
                <td><input type="datetime-local" name="new_date_sortie" placeholder="Date de Sortie"></td>
                <td><button type="submit" name="add" class="button add-button">Add</button></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
