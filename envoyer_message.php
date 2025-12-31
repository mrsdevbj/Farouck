<?php
// Activation de l'affichage des erreurs (à désactiver en production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Vérifier que c'est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer et nettoyer les données du formulaire
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
    $sujet = htmlspecialchars(trim($_POST['sujet'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Valider les champs obligatoires
    if (empty($nom) || empty($email) || empty($message)) {
        die('Erreur : Veuillez remplir tous les champs obligatoires.');
    }
    
    // Valider l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Erreur : Adresse email invalide.');
    }
    
    // Email du destinataire (votre email)
    $destinataire = 'faroucktundeadekambi@gmail.com';
    
    // Sujet de l'email
    $sujet_email = 'Nouveau message de contact de ' . $nom;
    
    // Corps du message
    $corps_email = "
    <html>
    <head>
        <title>Nouveau message de contact</title>
    </head>
    <body>
        <h2>Nouveau message de contact</h2>
        <p><strong>Nom :</strong> $nom</p>
        <p><strong>Email :</strong> $email</p>
        <p><strong>Téléphone :</strong> " . (!empty($telephone) ? $telephone : 'Non fourni') . "</p>
        <p><strong>Sujet :</strong> $sujet</p>
        <hr>
        <p><strong>Message :</strong></p>
        <p>" . nl2br($message) . "</p>
    </body>
    </html>
    ";
    
    // Entêtes de l'email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n";
    
    // Envoyer l'email
    if (mail($destinataire, $sujet_email, $corps_email, $headers)) {
        // Email envoyé avec succès
        header('Location: confirmation.html');
        exit();
    } else {
        // Erreur lors de l'envoi
        die('Erreur : Le message n\'a pas pu être envoyé. Veuillez réessayer plus tard.');
    }
} else {
    // Si ce n'est pas une requête POST, rediriger vers la page de contact
    header('Location: contact.html');
    exit();
}
?>
