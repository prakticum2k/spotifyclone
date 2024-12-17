<?php
include("../../config.php");

if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM songs WHERE id = ?");
    $stmt->bind_param("i", $songId); // Assuming 'id' is an integer column
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $resultArray = $result->fetch_assoc();
        echo json_encode($resultArray);
    } else {
        echo json_encode(["error" => "No song found for the provided ID."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No song ID provided."]);
}
?>
