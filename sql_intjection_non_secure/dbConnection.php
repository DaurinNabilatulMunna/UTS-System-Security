<?php
$databaseHost = 'localhost:3306';
$databaseName = 'sql_injection';
$databaseUsername = 'root';
$databasePassword = '';

// Open a new connection to the MySQL server
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 