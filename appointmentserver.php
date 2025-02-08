<?php
$visit_date = $_POST['visit_date'];
$visit_time = $_POST['visit_time'];

$conn = new mysqli('localhost', 'root', '', 'visitrack');

if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
}
else{
    $stmt = $conn->prepare("insert into visit(visit_date, visit_time) values (?, ?)");

    $stmt->bind_param("dt", $visit_date, $visit_time);

    $execval = $stmt->execute();
	echo $execval; 
	header("Location: .php");
	echo "Your Registration is Successfully Submitted";
	$stmt->close();
	$conn->close();
}