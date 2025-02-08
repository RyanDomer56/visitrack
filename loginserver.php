<?php
//Establish a connection
$conn = new mysqli('localhost', 'root', '', 'visitrack');
if($conn->connect_error){
    echo "No connection found";
    die("Connection Failed: " . $conn->connect_error);
}
//Server for retrieving data from database
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("select * from login where id = ? ");
    $stmt->bind_param("s", $username);

    $execval = $stmt->execute();
	echo $execval;
    $result = $stmt->get_result();
	header("Location: homepage.php");
	echo "Credentials Verified Successfully...";

    //Conditions and Verifications
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row["password"])) {
            // Login successful
            session_start();
            $_SESSION["username"] = $row["username"];
            header("Location: homepage.php");
            exit;
        } else {
            // Invalid password
            $error_message = "Invalid username or password.";
        }
    } else {
        // Invalid username
        $error_message = "Invalid username or password.";
    }
    $stmt->close();
}
$conn->close();