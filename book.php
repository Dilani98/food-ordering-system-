<?php

$fname = $_POST['fname'];
$lname  = $_POST['lname'];
$email = $_POST['email'];
$table_type = $_POST['table_type'];
$guest = $_POST['guest'];
$placement = $_POST['placement'];
$date = $_POST['dat'];
$time = $_POST['tim'];
$note = $_POST['note'];



if (!empty($fname) || !empty($lname) ||!empty($email) || !empty($table_type) || !empty($guest)|| !empty($placement)|| !empty($dat) || !empty($tim)|| !empty($note))
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "form";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From book Where email = ? Limit 1";
  $INSERT = "INSERT Into book (fname , lname,email ,table_type, guest,placement,dat,tim,note)values(?,?,?,?,?,?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s",$email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssssissss", $fname,$lname,$email,$table_type,$guest,$placement,$dat,$tim,$note);
      $stmt->execute();
      echo "New record inserted sucessfully";

     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>