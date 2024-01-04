<?php
include 'config.php';
session_start();
$nom_proprietaire = $_SESSION['nom'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save'])) {
        // Handle the save action here
        $id = $_POST['id'];
        $date_sortie = $_POST['date_sortie'];

        // Update the database with the new date de sortie
        $update_query = mysqli_prepare($conn, "UPDATE vehicule SET date_sortie=? WHERE id=?");
        mysqli_stmt_bind_param($update_query, "si", $date_sortie, $id);
        if (mysqli_stmt_execute($update_query)) {
            // Successfully updated
            header("Location: list_voiture_user.php"); // Redirect to the page
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
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
    <title>Liste des Véhicules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 12px;
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

        /* Style for date input */
        .date-input {
            width: 100%;
            padding: 5px;
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
<a class="back-to-home" href="home.php">Back to Home</a>
    <h1>Liste des Véhicules</h1>
    <?php
    
    $query = mysqli_query($conn, "SELECT * FROM vehicule WHERE nom_proprietaire = '$nom_proprietaire'");
    

    if (mysqli_num_rows($query) > 0) {
        echo '<table>';
        echo '<tr><th>Nom du Propriétaire</th><th>Nom du Véhicule</th><th>Numéro du Véhicule</th><th>Date d\'Entrée</th><th>Date de Sortie</th><th>Actions</th></tr>';
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<form method="POST">'; // Start form
            echo '<tr>';
            echo '<td>' . $row['nom_proprietaire'] . '</td>';
            echo '<td>' . $row['nom_vehicule'] . '</td>';
            echo '<td>' . $row['numero_vehicule'] . '</td>';
            echo '<td>' . date('Y-m-d H:i', strtotime($row['date_entree'])) . '</td>';
            echo '<td>';
            echo '<input type="datetime-local" class="date-input" name="date_sortie" value="' . date('Y-m-d\TH:i', strtotime($row['date_sortie'])) . '">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">'; // Hidden input for ID
            echo '</td>';
            echo '<td>';
            echo '<div class="button-container">';
            echo '<button type="submit" name="save" class="button save-button">Save</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            echo '</form>'; // End form
        }
        echo '</table>';
    } else {
        echo '<p>Aucun véhicule enregistré.</p>';
    }
    ?>
</div>
</body>
</html>
