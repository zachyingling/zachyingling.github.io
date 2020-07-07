<?php 

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  
  $mailTo = "zpyingling9559@protonmail.com"
  $headers = "From: ".$email;
  $txt = "You have received an e-mail from ".$name." ".$surname.".\n\n".$message;

  mail($mailTo, "No Subject", $txt, $headers);
  header("Location: index.html?mailsend");
}

?>