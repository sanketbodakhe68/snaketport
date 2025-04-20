<?php
// Database connection details
$servername = "localhost";
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP has no password
$dbname = "enquiries_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make sure REQUEST_METHOD exists and is POST
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data safely
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Insert into database
    $sql = "INSERT INTO enquiries (name, email, message) VALUES (?, ?, ?)";

    // Prepare statement to prevent SQL Injection
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute statement
        if ($stmt->execute()) {
            echo "Thanks you";
        } else {
            echo "Error submitting enquiry: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Invalid request method.";
}

// Close connection
$conn->close();
?>
