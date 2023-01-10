<?php
require_once('./inc/verifylogin.inc.php');
echo '<a href="./addclient.php">Back</a><hr>';
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('inc/functions.inc.php');


// Create and check connection
require_once('./inc/config.inc.php');
$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
if ($conn->connect_error) {
   $diemsg = '<pre><i>Unable to connect to DB!</i></pre>';
   die($diemsg);
}

function validate_client(array $client) {
	// Empty error messages var
	$errs = '';

	if ($client['first_name'] === '') { $errs .= '<li>First name not provided</li>'; }
	if ($client['last_name'] === '') { $errs .= '<li>Last name not provided</li>'; }
	if ($client['email'] === '' && $client['phone'] === '') { $errs .= '<li>Either e-mail, phone or both must be provided</li>'; }

	// If errors were encountered, die with error messages
	if ($errs !== '') { die('<h2>Errors were encountered!</h2><br>' . $errs); }
}

function display_client(array $client) {
	echo '<strong>First Name:</strong> ' . $client['first_name'].'<br>';
	echo '<strong>Last Name:</strong> ' . $client['last_name'].'<br>';
	echo '<strong>Phone Number:</strong> ' . $client['phone'].'<br>';
	echo '<strong>E-mail Address:</strong> ' . $client['email'];
}

function enter_booking(array $client, $conn) {
	$stmt = $conn->prepare('INSERT INTO clients (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)');
	$stmt->bind_param('ssss', $client['first_name'], $client['last_name'], $client['email'], $client['phone']);
	if ($stmt->execute()) { echo 'Successfully added client!'; }
	else { echo $conn->error; }
}

// Put booking info into an array to make it easier to understand
$client = array(
	"first_name" => $_POST['fname'],
	"last_name" => $_POST['lname'],
	"email" => $_POST['email'],
	"phone" => $_POST['phone']
);
validate_client($client);
display_client($client);
enter_booking($client, $conn);
$conn->close();
