<?php
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

$bookings = $conn->query('SELECT bookings.ref, bookings.title, bookings.`start`, bookings.`end`, rooms.alias, clients.first_name AS client_fname, clients.last_name AS client_lname, users.first_name AS user_fname, users.last_name AS user_lname FROM bookings INNER JOIN rooms ON bookings.room_id = rooms.id INNER JOIN users ON bookings.created_by = users.id INNER JOIN clients ON bookings.client_id = clients.id');
$count = implode($conn->query('SELECT COUNT(0) FROM bookings')->fetch_assoc());
echo '<h2>Bookings <small>('.$count.' total)</small></h2><hr>';

if ($bookings !== false) {
    while ($booking = $bookings->fetch_assoc()) {
        echo '<strong>'.$booking['client_fname'].' '.$booking['client_lname'].'</strong><br>';
        echo '<small>'.$booking['title'].'</small>';
        echo '<hr>';
    }
}

$conn->close();
