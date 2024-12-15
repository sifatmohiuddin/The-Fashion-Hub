<?php
session_start();
include('includes/config.php');
require('path/to/otp/sending/library.php'); // Include your OTP sending library

if(strlen($_SESSION['login'])==0) {
    header('location:login.php');
} else {
    // Generate a random OTP
    $otp = rand(100000, 999999);

    // Save the OTP in the session (or database)
    $_SESSION['otp'] = $otp;

    // Get the user's contact number
    $query = mysqli_query($con, "SELECT contactno FROM users WHERE id='".$_SESSION['id']."'");
    $row = mysqli_fetch_array($query);
    $contactno = $row['contactno'];

    // Send the OTP to the user's contact number
    $message = "Your OTP is $otp";
    send_otp($contactno, $message); // Replace with your OTP sending function

    echo "OTP sent successfully!";
}
?>
