<?php
session_start();
include("db.php");
mysqli_report(MYSQLI_REPORT_OFF);

$pagename = "Sign Up Results";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>" . $pagename . "</title>";
echo "<body>";
include("headfile.html");
echo "<h4>" . $pagename . "</h4>";

// Capture form inputs
$fname = trim($_POST['r_firstname']);
$lname = trim($_POST['r_lastname']);
$address = trim($_POST['r_address']);
$postcode = trim($_POST['r_postcode']);
$telno = trim($_POST['r_telno']);
$email = trim($_POST['r_email']);
$password1 = trim($_POST['r_password1']);
$password2 = trim($_POST['r_password2']);

// Email validation regex
$reg = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";

// Validation checks
if (empty($fname) || empty($lname) || empty($address) || empty($postcode) || empty($telno) || empty($email) || empty($password1) || empty($password2)) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<p>Your signup form is incomplete. All fields are mandatory.</p>";
    echo "<p>Go back to <a href='signup.php'>sign up</a></p>";
} elseif ($password1 !== $password2) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<p>The two passwords do not match.</p>";
    echo "<p>Go back to <a href='signup.php'>sign up</a></p>";
} elseif (!preg_match($reg, $email)) {
    echo "<p><b>Sign-up failed!</b></p>";
    echo "<p>Email not valid. Please enter a correct email address.</p>";
    echo "<p>Go back to <a href='signup.php'>sign up</a></p>";
} else {
    // Insert query
    $SQL = "INSERT INTO Users (userType, userFName, userSName, userAdress, userPostCode, userTelNo, userEmail, userPassword)
            VALUES ('C', '$fname', '$lname', '$address', '$postcode', '$telno', '$email', '$password1')";

    if (mysqli_query($conn, $SQL)) {
        echo "<p><b>Sign-up successful!</b></p>";
        echo "<p>To continue, please <a href='login.php'>login</a></p>";
    } else {
        echo "<p><b>Sign-up failed!</b></p>";
        echo "<br><p>SQL Error No: " . mysqli_errno($conn) . "</p>";
        echo "<p>SQL Error Msg: " . mysqli_error($conn) . "</p>";
        if (mysqli_errno($conn) == 1062) {
            echo "<p>Email already in use. Please try another email.</p>";
        } elseif (mysqli_errno($conn) == 1064) {
            echo "<p>Invalid characters entered. Avoid apostrophes [ ' ] and backslashes [ \\ ].</p>";
        }
        echo "<p>Go back to <a href='signup.php'>sign up</a></p>";
    }
}

include("footfile.html");
echo "</body>";
?>
