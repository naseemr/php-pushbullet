<?php
include("./Class/cloudflare.notify.php");

$key = "APIKEY";

$notify = new notify($key);

$notify->notify("Title", "Body");
?>
