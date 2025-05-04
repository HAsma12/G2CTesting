<?php
// Inclure les classes PHPMailer manuellement
require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=inscription;charset=utf8', 'root', '');

    // Récupération sécurisée des champs
    $nom        = htmlspecialchars($_POST['nom']);
    $prenom     = htmlspecialchars($_POST['prenom']);
    $telephone  = htmlspecialchars($_POST['telephone']);
    $formations = isset($_POST['formations']) ? implode(", ", $_POST['formations']) : '';

    // Insertion en base
    $stmt = $pdo->prepare("INSERT INTO inscriptions (nom, prenom, telephone, formations) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $telephone, $formations]);

    // Préparation de l'e-mail
    $mail = new PHPMailer(true);
    $mail->SMTPDebug   = 2;              // Active le debug SMTP
    $mail->Debugoutput = 'html';

    try {
        // Configuration SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hasniasma742@gmail.com';
        $mail->Password   = 'qoxa xiim xqll jnpf';  // Mot de passe d’app
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Expéditeur & destinataire
        $mail->setFrom('hasniasma742@gmail.com', 'Formulaire G2C');
        $mail->addAddress('hasniasma742@gmail.com');

        // Contenu
        $mail->isHTML(false);
        $mail->Subject = "Nouvelle inscription de $prenom $nom";
        $mail->Body    = "Nom: $nom\nPrénom: $prenom\nTéléphone: $telephone\nFormations: $formations";

        $mail->send();
        echo "<p>Inscription réussie. E‑mail envoyé.</p>";
    } catch (Exception $e) {
        echo "<p>Inscription réussie, mais erreur d’envoi d’e‑mail :</p>";
        echo "<pre>{$mail->ErrorInfo}</pre>";
    }
}
?>
