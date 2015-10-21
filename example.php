<?php
include("./Class/class.notify.php");

$key = "APIKEY";

$notify = new notify($key);

$notify->notify("Title", "Body");
?>
