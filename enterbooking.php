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
