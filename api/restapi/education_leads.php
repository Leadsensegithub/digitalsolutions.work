<?php

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: POST");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type");

// Include the database configuration file
include '../canfig.php';

// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Validate and sanitize the incoming data
  $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";
  $contact = isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : "";
  $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
  $courses_details = isset($_POST['courses_details']) ? htmlspecialchars($_POST['courses_details']) : "";
  $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : "";
  $person_id = isset($_POST['person_id']) ? intval($_POST['person_id']) : 0; // Assuming person_id is an integer

  // Check if required fields are not empty
  if (!empty($name) && !empty($contact) && !empty($email) && !empty($courses_details) && !empty($address) && $person_id > 0) {
    // Insert information into the database
    $query = "INSERT INTO `education_leads` (`person_id`, `name`, `contact`, `email`, `courses_details`, `address`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("isssss", $person_id, $name, $contact, $email, $courses_details, $address);

    // Execute statement
    if ($stmt->execute()) {
      $response = array("success" => true, "message" => "Record inserted successfully");
    } else {
      $response = array("success" => false, "message" => "Error inserting record");
      http_response_code(500); // Internal Server Error
    }
  } else {
    $response = array("success" => false, "message" => "Missing required fields or invalid person_id");
    http_response_code(400); // Bad Request
  }
} else {
  $response = array("success" => false, "message" => "Invalid request method");
  http_response_code(405); // Method Not Allowed
}

// Encode the response as JSON and send it back
echo json_encode($response);

?>
