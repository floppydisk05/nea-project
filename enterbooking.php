<?php
require_once('./inc/verifylogin.inc.php');
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
$clients = $conn->query('SELECT id, first_name, last_name FROM clients');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Booking</title>
</head>
<body>
    <a href="/">Back</a>
    <hr>
    <form action="processbooking.php" method="post" style="border: 2px; width: 400px">
        <fieldset>
            <legend>Enter booking</legend>
            <label for="title"><strong>Title:</strong></label><br>
            <input type="text" id="title" name="title"><br>
            <label for="room"><strong>Room:</strong></label><br>
            <select name="room">
                <option disabled selected value> -- select an option -- </option>
                <option value="1">Meeting Room</option>
                <option value="2">Training Room</option>
                <option value="3">Office 1</option>
                <option value="4">Hall &amp; Kitchen</option>
            </select><br>
            <label for="client"><strong>Client:</strong></label><br>
            <select name="client">
                <option disabled selected value> -- select an option -- </option>
<?php
while ($client = $clients->fetch_assoc()) {
    echo '                <option value="'.$client['id'].'">'.$client['first_name'].' '.$client['last_name'].'</option>'.PHP_EOL;
}
?>
            </select><br>
            <label for="start_dt"><strong>Start:</strong></label><br>
            <input type="datetime-local" id="start_dt" name="start_dt"><br>
            <label for="end_dt"><strong>Start:</strong></label><br>
            <input type="datetime-local" id="end_dt" name="end_dt"><br>
            <label for="notes"><strong>Notes:</strong></label><br>
            <textarea id="notes" name="notes"></textarea><br>
            <input type="submit" value="Save">
        </fieldset>
    </form>
</body>
</html>
