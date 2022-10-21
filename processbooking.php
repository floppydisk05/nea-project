<table border="1">
<tr><th>key</th><th>value</th></tr>
<?php 
foreach ($_POST as $key => $value) {
    echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
}
?>
</table>