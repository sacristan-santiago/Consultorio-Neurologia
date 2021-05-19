<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
  $nombre = $_POST['nombreInput'];
  $apellido = $_POST['apellidoInput'];
  $telefono = $_POST['telefonoInput'];
  $cobertura = $_POST['coberturaInput'];
  $razon = $_POST['razonInput'];
  $visitor_email = $_POST['correoInput'];

//Validate first
if(empty($nombre)||empty($visitor_email)) 
{
    echo "Nombre y mail son requeridos!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'sacristan.santiago@gmail.com';//<== update the email address
$email_subject = "Nueva solcitud de turno";
$email_body = 
    "El paciente $nombre $apellido solicita  turno por las siguientes razones: \r\n\r\n".
    "$razon \r\n\r\n".
    "A continuación sus datos personales:\r\n".
    "Nombre: $nombre \r\n".
    "Apellido: $apellido \r\n".
    "Telefono: $telefono \r\n".
    "Cobertura medica: $cobertura \r\n\r\n";    
$to = "sacristan.santiago@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: ../Secciones/turnos-form-submitted.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 