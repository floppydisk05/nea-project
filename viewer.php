<?php require_once('./inc/verifylogin.inc.php');?>
<a href="/">Back</a>
<hr>
<form action="viewer.php" method="post" style="border: 2px; width: 400px">
    <fieldset>
        <legend>Search</legend>
        <label for="title"><strong>Title:</strong></label>&nbsp;
        <input type="text" id="title" name="title"><br>
        <label for="date"><strong>Date:</strong></label>&nbsp;
        <input type="date" id="date" name="date"><br>
        <input type="submit" value="Search">
    </fieldset>
</form>
<?php
// Enable error reporting
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once('./inc/functions.inc.php');

// Create and check connection
require_once('./inc/config.inc.php');
$conn = new mysqli(CONF["dbhost"], CONF["username"], CONF["password"], CONF["dbname"]);
if ($conn->connect_error) {
   $diemsg = '<pre><i>Unable to connect to DB!</i></pre>';
   die($diemsg);
}

$initial_query = 'SELECT bookings.ref, bookings.title, bookings.start, bookings.end, bookings.notes, rooms.alias AS room, clients.first_name AS client_fname, clients.last_name AS client_lname, users.first_name AS user_fname, users.last_name AS user_lname FROM bookings INNER JOIN rooms ON bookings.room_id = rooms.id INNER JOIN users ON bookings.created_by = users.id INNER JOIN clients ON bookings.client_id = clients.id';

if (!isset($_POST['date']) && !isset($_POST['title'])) {
    $initial_query .= ' ORDER BY start';
    $bookings = $conn->query($initial_query);
} else {
    if ($_POST['date'] === '' || !isset($_POST['date'])) {
        if ($_POST['title'] === '') { $bookings = $conn->query($initial_query); }
        else {
            $title = '%'.$_POST['title'].'%';
            $initial_query .= ' WHERE bookings.title LIKE ? ORDER BY start';
            echo $initial_query;
            $stmt = $conn->prepare($initial_query);
            $stmt->bind_param('s', $title);
            $stmt->execute();
            $bookings = $stmt->get_result();
            if (!$bookings) { echo $conn->error; }
            echo $bookings->num_rows.' results for "'.$_POST['title'].'"<br>';
        }
    } elseif ($_POST['title'] === '') {
        $date = strtotime($_POST['date']);
        $date_year = intval(date('Y', $date));
        $date_month = intval(date('m', $date));
        $date_day = intval(date('d', $date));
        $initial_query .= ' WHERE year(bookings.start) = ?  AND month(bookings.start) = ? AND day(bookings.start) = ? ORDER BY start';
        $stmt = $conn->prepare($initial_query);
        $stmt->bind_param('iii', $date_year, $date_month, $date_day);
        $stmt->execute();
        $bookings = $stmt->get_result();
        if (!$bookings) { echo $conn->error; }
        echo $bookings->num_rows.' bookings on '.$date_day.'/'.$date_month.'/'.$date_year.'<br>';
    } else {
        $title = '%'.$_POST['title'].'%';
        $date = strtotime($_POST['date']);
        $date_year = intval(date('Y', $date));
        $date_month = intval(date('m', $date));
        $date_day = intval(date('d', $date));
        $initial_query .= ' WHERE year(bookings.start) = ?  AND month(bookings.start) = ? AND day(bookings.start) = ? AND bookings.title LIKE ? ORDER BY start';
        $stmt = $conn->prepare($initial_query);
        $stmt->bind_param('iiis', $date_year, $date_month, $date_day, $title);
        $stmt->execute();
        $bookings = $stmt->get_result();
    }
}
echo '<hr>';
if ($bookings !== false) {
    list_bookings($bookings);
}

$conn->close();
