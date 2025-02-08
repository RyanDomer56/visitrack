<?php
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$sex = $_POST['sex'];
$birthdate = $_POST['birth_date'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$conn = new mysqli('localhost', 'root', '', 'visitrack');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed: " . $conn->connect_error);
}
else{
    $stmt = $conn->prepare("insert into registration(last_name, first_name, middle_name, sex, birthdate,
    address, username, password, role) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssdssss", $last_name, $first_name, $middle_name, $sex, $birthdate, $address,
    $username, $password, $role);

    $execval = $stmt->execute();
	echo $execval; 
	header("Location: verification.php");
	echo "Your Registration is Successfully Submitted";
	$stmt->close();
	$conn->close();
}