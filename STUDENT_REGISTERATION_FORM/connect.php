<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'student_management_system');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $firstName = sanitize_input($_POST['firstName']);
    $lastName = sanitize_input($_POST['lastName']);
    $gender = sanitize_input($_POST['gender']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']); // Assuming you have a password field in your form
    $number = sanitize_input($_POST['phone']); // 'phone' field from HTML form

    // Prepare SQL statement to insert data into students table
    $stmt = $conn->prepare("INSERT INTO students (firstName, lastName, gender, email, password, number) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssss", $firstName, $lastName, $gender, $email, $password, $number);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Registration successful");</script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '");</script>';
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();

// Function to sanitize input
function sanitize_input($data) {
    // Remove whitespace from the beginning and end of the string
    $data = trim($data);
    // Convert special characters to HTML entities to prevent XSS attacks
    $data = htmlspecialchars($data);
    // Return sanitized data
    return $data;
}
?>
