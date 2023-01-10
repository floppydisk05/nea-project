<?php
require_once('exceptions.inc.php');

function get_user($userID) {
	// Create connection
	$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	   die('Connection failed: ' . $conn->connect_error);
	}

	$stmt = $conn->prepare('SELECT first_name, last_name FROM users WHERE id = ?');
	$stmt->bind_param('s', $userID);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows < 1) { throw new NoResultsException('No results for user id '.$userID.'!'); }
	$user = $result->fetch_all(MYSQLI_ASSOC)[0];
	$conn->close();

	return array (
		"first_name" => $user['first_name'],
		"last_name" => $user['last_name']
	);
}

function get_room($roomID) {
	// Create connection
	$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	   die('Connection failed: ' . $conn->connect_error);
	}

	$stmt = $conn->prepare('SELECT alias, capacity FROM rooms WHERE id = ?');
	$stmt->bind_param('s', $roomID);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($result->num_rows < 1) { throw new NoResultsException('No results for room id '.$roomID.'!'); }
	$user = $result->fetch_all(MYSQLI_ASSOC)[0];
	$conn->close();

	return array (
		"alias" => $user['alias']
	);
}

function format_date($timestamp) {
	return gmdate('d/m/Y H:i:s', $timestamp);
}

function format_time($seconds) {
	$days = intval(gmdate('d', $seconds));
	$hours = intval(gmdate('H', $seconds));
	$minutes = intval(gmdate('i', $seconds));
	$date = '';
	if ($days > 0) { $date .= $days.'d '; }
	if ($hours > 0) { $date .= $hours.'h '; }
	if ($minutes > 0) { $date .= $minutes.'m'; }
	return $date;
}

function sqldate($epoch) {
	$date = new DateTime("@$epoch");
	return $date->format('Y-m-d H:i:s');
}

function list_bookings($bookings) {
	if ($bookings->num_rows < 1) {
		echo 'No bookings found.';
		return;
	}
	while ($booking = $bookings->fetch_assoc()) {
		echo '<strong>'.$booking['ref'].': '.$booking['client_fname'].' '.$booking['client_lname'].'</strong><br>';
		echo '<small><b>Title:</b> '.$booking['title'].'</small><br>';
		if ($booking['notes'] !== "") { echo '<small><b>Notes:</b> '.$booking['notes'].'</small><br>'; }
		echo '<small><b>Created by:</b> '.$booking['user_fname'].' '.$booking['user_lname'].'</small><br>';
		echo '<small><b>Start - end:</b> '.$booking['start'].' - '.$booking['end'].'</small><br>';
		echo '<small><b>Room:</b> '.$booking['room'].'</small><br>';
		echo '<a href="/deletebooking.php?ref='.$booking['ref'].'" onclick="return confirm(\'Are you sure you want to delete this booking?\')"><button>Delete booking</button></a>';
		echo '<hr>';
	}
}

function validate_login($username, $password) {
	// Create connection
	$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	   die('Connection failed: ' . $conn->connect_error);
	}

	$stmt = $conn->prepare('SELECT username, password FROM users WHERE username = ?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$users = $stmt->get_result();
	$user = $users->fetch_assoc();
	$conn->close();

	return password_verify($password, $user['password']);
}

function get_user_id($username) {
	// Create connection
	$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	   die('Connection failed: ' . $conn->connect_error);
	}

	$stmt = $conn->prepare('SELECT id FROM users WHERE username = ?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$users = $stmt->get_result();
	$user = $users->fetch_assoc();
	$conn->close();

	return $user['id'];
}

function delete_booking($id) {
	// Create connection
	$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
	// Check connection
	if ($conn->connect_error) {
	   die('Connection failed: ' . $conn->connect_error);
	}

	$stmt = $conn->prepare('DELETE FROM bookings WHERE ref = ?');
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$conn->close();

	header("Location: /viewer.php");
	die();
}
