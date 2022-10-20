<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="processbooking.php" method="post" style="border: 2px">
        <fieldset>
            <legend>Enter booking</legend>
            <label for="title"><b>Title:</b></label><br>
            <input type="text" id="title" name="title"><br>
            <label for="room"><b>Room:</b></label><br>
            <select id="room">
                <option disabled selected value> -- select an option -- </option>
                <option value="meetingroom">Meeting Room</option>
                <option value="trainingroom">Training Room</option>
                <option value="office1">Office 1</option>
                <option value="hall">Hall</option>
                <option value="kitchen">Kitchen</option>
            </select><br>
            <label for="startdt"><b>Start:</b></label><br>
            <input type="datetime-local" id="startdt" name="startdt"><br>
            <label for="enddt"><b>Start:</b></label><br>
            <input type="datetime-local" id="enddt" name="enddt"><br>
            <label for="notes"><b>Notes:</b></label><br>
            <textarea id="notes" name="notes"></textarea><br>
            <input type="submit" value="Save">
        </fieldset>
    </form>
</body>
</html>
