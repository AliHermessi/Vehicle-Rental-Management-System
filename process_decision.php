<?php
session_start();

if (!isset($_POST['decision']) || !isset($_POST['user_id'])) {
    header('location: decision.php');
    exit();
}

$user_id = $_POST['user_id'];
$decision = $_POST['decision'];

// Vous pouvez mettre en place la logique de traitement en fonction de la décision ici

// Par exemple, vous pouvez mettre à jour une colonne "decision" dans la base de données pour cet utilisateur

// Après le traitement, vous pouvez rediriger l'utilisateur vers une page appropriée
if ($decision === 'accept') {
    // Traitement pour accepter les informations
    // Redirection vers une page de succès, par exemple
    header('location: success.php');
} elseif ($decision === 'reject') {
    // Traitement pour refuser les informations
    // Redirection vers une page de refus, par exemple
    header('location: reject.php');
} else {
    // Redirection en cas de décision inconnue
    header('location: decision.php');
}
?>
