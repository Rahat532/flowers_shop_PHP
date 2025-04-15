<?php
$conn = mysqli_connect('localhost', 'root', '', 'flower');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
