<a href="./enterbooking.php">Back</a><hr>
<?php
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Create and check connection
require('config.inc.php');
$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
if ($conn->connect_error) {
   $diemsg = '<pre><i>Unable to connect to DB!</i></pre>';
   die($diemsg);
}

function validate_booking(array $BOOKING) {
    // Empty error messages var
    $errs = '';

    // Check if start is after end or if either isn't provided
    if (!$_POST['start_dt'] || !$_POST['end_dt']) $errs .= '<li>Both start and end must be provided!</li>';
    elseif ($BOOKING['start_dt'] >= $BOOKING['end_dt']) $errs .= '<li>End date cannot be before or equal to start date</li>';
    
    // Check if room or booking title are provided
    if ($BOOKING['room_id'] === 0) $errs .= '<li>Room not provided!</li>';
    if ($BOOKING['title'] === '') $errs .= '<li>Title not provided!</li>';
    
    // If errors were encountered, die with error messages
    if ($errs === '') echo 'No errors!';
    else die('<h2>Errors were encountered!</h2>' . $errs);
}

// Put booking info into an array to make it easier to understand
$BOOKING = array(
    "user_id" => 1,
    "title" => $_POST['title'],
    "room_id" => intval($_POST['room']),
    "start_dt" => strtotime($_POST['start_dt']),
    "end_dt" => strtotime($_POST['end_dt']),
    "notes" => $_POST['notes']
);

validate_booking($BOOKING);
?>
