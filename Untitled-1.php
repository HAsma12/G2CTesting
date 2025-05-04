<?php
// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Charger PHPMailer
require 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier que les données ont bien été envoyées
    if (isset($_POST['formations']) && isset($_POST['message'])) {
        // Récupérer les formations et le message
        $formations = implode(", ", $_POST['formations']);
        $message = htmlspecialchars($_POST['message']);
        
        // Configuration de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hasniasma742@gmail.com'; // Remplace par ton adresse Gmail
            $mail->Password = 'tonmotdepasse'; // Remplace par ton mot de passe Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Expéditeur et destinataire
            $mail->setFrom('tonemail@gmail.com', 'g2c');
            $mail->addAddress('hasniasma742@gmail.com', 'Destinataire'); // Le destinataire

            // Sujet et message
            $mail->isHTML(true);
            $mail->Subject = 'Nouvelle inscription à une formation';
            $mail->Body    = "Formations : $formations<br>Message : $message";
            $mail->AltBody = "Formations : $formations\nMessage : $message";

            // Envoi de l'email
            $mail->send();
            echo 'Message envoyé avec succès';
        } catch (Exception $e) {
            echo "Le message n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
        }
    } else {
        echo "Données manquantes.";
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
