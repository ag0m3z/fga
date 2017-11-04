<?php
/**
 * Created by PhpStorm.
 * User: alejandro.gomez
 * Date: 10/10/2017
 * Time: 05:08 PM
 */

include "../../../../core/core.class.php";
include "../../../../core/sesiones.class.php";

require_once('../../../../plugins/PhpMail/class.phpmailer.php');
include("../../../../plugins/PhpMail/class.smtp.php");

header("ContentType:application/json");

$email_user = "agomez.barron@gmail.com";
$email_password = "algo#123";
$the_subject = $_POST['Titulo'];

$address_to = $_SESSION['data_home']['correoEmpresa'];
$MensajeCorreo = $_POST['Mensaje'];

$from_name = "Alejandro Gomez";
$phpmailer = new PHPMailer();
// ---------- datos de la cuenta de Gmail -------------------------------
$phpmailer->Username = $email_user;
$phpmailer->Password = $email_password;
//-----------------------------------------------------------------------
// $phpmailer->SMTPDebug = 1;
$phpmailer->SMTPSecure = 'ssl';
$phpmailer->Host = "smtp.gmail.com"; // GMail
$phpmailer->Port = 465;
$phpmailer->IsSMTP(); // use SMTP
$phpmailer->SMTPAuth = true;
$phpmailer->setFrom($phpmailer->Username,$from_name);
$phpmailer->AddAddress($address_to); // recipients email
$phpmailer->Subject = utf8_decode($the_subject);
$phpmailer->Body .=utf8_decode($MensajeCorreo);
$phpmailer->Body .= "<p>Fecha y Hora: ".date("d-m-Y h:i:s")."</p>";
$phpmailer->IsHTML(true);

if (!$phpmailer->Send()) {
    echo json_encode(array("message"=>"Mailer Error: " . $mail->ErrorInfo));
} else {
    echo json_encode(array("message"=>"Message sent!"));;
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}