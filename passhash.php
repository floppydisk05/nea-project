<form action="passhash.php" method="post" style="border: 2px; width: 400px">
    <label for="pword"><strong>Password:</strong></label>
    <input type="text" id="pword" name="pword">
    <input type="submit" value="Submit">
</form>
<?php
if (isset($_POST['pword'])) {
    echo password_hash($_POST['pword'], PASSWORD_DEFAULT);
}
