<?php
include("../../config.php");

if (isset($_POST['songId'])) { // Check for 'songId' as sent by the frontend
    $songId = intval($_POST['songId']); // Sanitize input

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("UPDATE songs SET plays = plays + 1 WHERE id = ?");
    $stmt->bind_param("i", $songId); // Assuming 'id' is an integer column

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Play count updated."]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to update play count."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "No song ID provided."]);
}
