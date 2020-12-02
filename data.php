<?php
$opinion = $_POST['opinion'];
$email = $_POST['email'];
$contact = $_POST['contact'];

if (!empty($opinion) || !empty($email) || !empty($contact)) {
 $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "formulier";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
     $SELECT = "SELECT email From register Where email = ? Limit 1";
     $INSERT = "INSERT Into register (opinion, email, contact) values(?, ?, ?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $stmt->store_result();
     $stmt->fetch();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssssii", $opinion, $email, $contact);
      $stmt->execute();
      echo "Bedankt voor je feedback!";
     } else {
      echo "E-mail is al in gebruik";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>