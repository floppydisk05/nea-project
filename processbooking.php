<?php
require_once('./inc/verifylogin.inc.php');
echo '<a href="./enterbooking.php">Back</a><hr>';
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

function validate_booking(array $booking) {
	// Empty error messages var
	$errs = '';

	// Check if start is after end or if either isn't provided
	if (!$_POST['start_dt'] || !$_POST['end_dt']) { $errs .= '<li>Both start and end must be provided!</li>'; }
	else {
		if ($booking['start_dt'] >= $booking['end_dt']) { $errs .= '<li>End date cannot be before or equal to start date</li>'; }
		$currentTime = time();
		if ($booking['start_dt'] <= $currentTime || $booking['end_dt'] <= $currentTime) { $errs .= '<li>Both start and end date must not be in the past</li>'; }
	}

	// Check if room or booking title are provided
	if ($booking['room_id'] === 0) { $errs .= '<li>Room not provided!</li>'; }
	if ($booking['title'] === '') { $errs .= '<li>Title not provided!</li>'; }

	// If errors were encountered, die with error messages
	if ($errs !== '') { die('<h2>Errors were encountered!</h2><br>' . $errs); }
}

function display_booking(array $booking) {
	$user = get_user($booking['created_by']);
	$room = get_room($booking['room_id']);
	echo '<strong>Title:</strong> ' . $booking['title'].'<br>';
	echo '<strong>Created By:</strong> ' . $user['first_name'].' '.$user['last_name'].'<br>';
	echo '<strong>Room:</strong> ' . $room['alias'].'<br>';
	echo '<strong>Start:</strong> ' . format_date($booking['start_dt']).'<br>';
	echo '<strong>End:</strong> ' . format_date($booking['end_dt']).'<br>';
	$duration = $booking['end_dt'] - $booking['start_dt'];
	echo '<strong>Duration:</strong> ' . format_time($duration).'<br>';
	echo '<strong>Notes:</strong> ' . $booking['notes'];
}

function enter_booking(array $booking, $conn) {
	$stmt = $conn->prepare('INSERT INTO bookings (title, room_id, client_id, created_by, start, end, notes) VALUES (?, ?, ?, ?, ?, ?, ?)');
	$stmt->bind_param('siiisss', $booking['title'], $booking['room_id'], $booking['client_id'], $booking['created_by'], sqldate($booking['start_dt']), sqldate($booking['end_dt']), $booking['notes']);
	if ($stmt->execute()) { echo 'Successfully added booking!'; }
	else { echo $conn->error; }
}

// Put booking info into an array to make it easier to understand
$booking = array(
	"title" => $_POST['title'],
	"created_by" => $id,
	"room_id" => intval($_POST['room']),
	"client_id" => intval($_POST['client']),
	"start_dt" => strtotime($_POST['start_dt']),
	"end_dt" => strtotime($_POST['end_dt']),
	"notes" => nl2br($_POST['notes'], false)
);

validate_booking($booking);
display_booking($booking);
enter_booking($booking, $conn);
