
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'contact@richinc.org'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Your email
        $mail->Password = 'your-email-password'; // Use App Passwords for security
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($_POST["yemail"], $_POST["yname"]);
        $mail->addAddress("your-email@example.com");

        $mail->Subject = "New Contact Form Submission";
        $mail->Body = "Name: " . $_POST["yname"] . "\n" .
                      "Email: " . $_POST["yemail"] . "\n" .
                      "Area of Interest: " . $_POST["aoi"] . "\n\n" .
                      "Skills and Talents:\n" . $_POST["skillstalents"];

        $mail->send();
        echo "Email sent successfully.";
    } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
?>
