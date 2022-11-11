<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Client</title>
</head>
<body>
    <a href="/">Back</a>
    <form action="processclient.php" method="post" style="border: 2px; width: 400px">
        <fieldset>
            <legend>Add Client</legend>
            <label for="fname"><strong>First Name:</strong></label><br>
            <input type="text" id="fname" name="fname"><br>
            <label for="lname"><strong>Last Name:</strong></label><br>
            <input type="text" id="lname" name="lname"><br>
            <label for="email"><strong>Email:</strong></label><br>
            <input type="email" id="email" name="email"><br>
            <label for="phone"><strong>Phone (In the format xxxxx xxxxxx):</strong></label><br>
            <input type="tel" id="phone" name="phone" pattern="[0-9]{5} [0-9]{6}"><br>
            <input type="submit" value="Save">
        </fieldset>
    </form>
</body>
</html>
