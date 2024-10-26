<?php
session_start();
include '../connection.php'; // Ensure the correct path to your database connection

// Get the report ID from the URL
if (isset($_GET['id'])) {
    $repId = $_GET['id'];

    // Prepare and execute the SQL query to fetch the file path
    $sql = "SELECT filePath FROM tblresponse WHERE repId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $repId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = $row['filePath'];

        // Check if the file exists
        if (file_exists($filePath)) {
            // Display or download the file
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Set the appropriate headers based on file type
            switch (strtolower($fileExtension)) {
                case 'pdf':
                    header('Content-Type: application/pdf');
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                    header('Content-Type: image/' . $fileExtension);
                    break;
                default:
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                    break;
            }

            // Output the file
            readfile($filePath);
            exit;
        } else {
            echo "<p>File not found.</p>";
        }
    } else {
        echo "<p>No report file associated with this ID.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
