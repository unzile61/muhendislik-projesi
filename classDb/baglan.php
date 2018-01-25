<?php 
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "muhodev";

	$conn = new mysqli($host,$user,$pass,$db);
	if ($conn->connect_error) {
		die("Bağlantı başarısız : ". $conn->connect_error);
	}
 ?>
