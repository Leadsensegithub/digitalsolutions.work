<?php

// Include the database configuration file
include '../canfig.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Decode the JSON data
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate and sanitize the incoming data
    $sku = isset($data['sku']) ? htmlspecialchars(strip_tags($data['sku'])) : "";
    $firstName = isset($data['firstName']) ? htmlspecialchars(strip_tags($data['firstName'])) : "";
    $lastName = isset($data['lastName']) ? htmlspecialchars(strip_tags($data['lastName'])) : "";
    $phone = isset($data['phone']) ? htmlspecialchars(strip_tags($data['phone'])) : "";
    $phone2 = isset($data['phone2']) ? htmlspecialchars(strip_tags($data['phone2'])) : "";
    $clickID = isset($data['clickID']) ? htmlspecialchars(strip_tags($data['clickID'])) : "";
    $publishID = isset($data['publishID']) ? htmlspecialchars(strip_tags($data['publishID'])) : "";
    $baseURL = isset($data['baseURL']) ? htmlspecialchars(strip_tags($data['baseURL'])) : "";
    $clientIP = isset($data['clientIP']) ? htmlspecialchars(strip_tags($data['clientIP'])) : "";

    // No empty fields found, proceed with insertion
    if (!empty($sku) && !empty($firstName) && !empty($lastName) && !empty($phone) && !empty($clickID) && !empty($publishID) && !empty($baseURL) && !empty($clientIP)) {
        // Insert data into the database
        $query = "INSERT INTO `digital_sol_leads` (`sku`, `firstName`, `lastName`, `phone`, `phone2`, `clickID`, `publishID`, `baseURL`, `clientIP`) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("sssssssss", $sku, $firstName, $lastName, $phone, $phone2, $clickID, $publishID, $baseURL, $clientIP);

        // Execute statement
        if ($stmt->execute()) {
            $response = array("success" => true, "message" => "Record inserted successfully");
        } else {
            $response = array("success" => false, "message" => "Error inserting record");
            http_response_code(500); // Internal Server Error
        }
    } else {
        $response = array("success" => false, "message" => "Missing required fields");
        http_response_code(400); // Bad Request
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method");
    http_response_code(405); // Method Not Allowed
}

// Encode the response as JSON and send it back
echo json_encode($response);

?>
