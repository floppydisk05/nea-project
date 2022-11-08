<?php
/*
- get_user
- get_room
- get_booking
-
*/

function get_user($userID) {
    if (!isset($userID)) return;

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
    if ($result->num_rows < 1) return;
    $user = $result->fetch_all(MYSQLI_ASSOC)[0];
    return array (
        "first_name" => $user['first_name'],
        "last_name" => $user['last_name']
    );
}

function get_room($roomID) {
    if (!isset($roomID)) return;

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
    if ($result->num_rows < 1) return;
    $user = $result->fetch_all(MYSQLI_ASSOC)[0];
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
    if ($days > 0) $date .= $days.'d ';
    if ($hours > 0) $date .= $hours.'h ';
    if ($minutes > 0) $date .= $minutes.'m';
    return $date;
}