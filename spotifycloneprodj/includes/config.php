<?php 

    ob_start();

    // Configure session cookies with SameSite and Secure attributes
    session_set_cookie_params([
        'samesite' => 'None',
        'secure' => true // Only set to true if you're using HTTPS
    ]);
    
    session_start(); 

    $timezone = date_default_timezone_set("Europe/Helsinki");

    $con = mysqli_connect("localhost", "root", "", "spotifycloneprodj");

    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }
?>
