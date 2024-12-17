<?php
include("../../config.php");

if (isset($_POST['albumId'])) {
    $albumId = intval($_POST['albumId']); // Validate and sanitize input

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM albums WHERE id = ?");
    $stmt->bind_param("i", $albumId); // Assuming 'id' is an integer column
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resultArray = $result->fetch_assoc();
        echo json_encode($resultArray);
    } else {
        echo json_encode(["error" => "No album found for the provided ID."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No album ID provided."]);
}


