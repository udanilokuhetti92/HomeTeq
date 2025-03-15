<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'w2081921_0';

    // Create a database connection
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Check if the connection was successful
    if (!$conn) {
        die('Could not connect: ' . mysqli_connect_error());
    }

    echo "Connected successfully!";
?>
