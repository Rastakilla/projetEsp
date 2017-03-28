<?php 
if (isset($_POST['vMail']) && isset($_POST['vMessage'])) 
{
$email = htmlentities($_POST['vMail']); 
$message = htmlentities($_POST['vMessage']).' de '.$email; 
mail('info@cegepba.qc.ca','QUestion Reservation Oeuvres', $message); 
header('location:index.php?mail=true'); 
} ?>