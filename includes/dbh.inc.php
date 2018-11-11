<?php

$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "eldererajinMenji99";
$dBName = "loginsystem";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, 3307);

if (!$conn)
{
    die("Connection failed: ". mysqli_connect_error());
}


