<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
if ($_POST) {
    // include database connection
    include 'config/database.php';
    try {
        header("Content-type: application/json; charset=utf-8");
        // insert query
        $query = "INSERT INTO register SET FirstName=:fname, LastName=:lname, Email=:email, Company=:company, Skype=:skype, Website=:website, Message=:message";
        // prepare query for execution
        $stmt = $con->prepare($query);
        // posted values
        $fname = $_POST['FirstName'];
        $lname = $_POST['LastName'];
        $email = $_POST['Email'];
        $company = $_POST['Company'];
        $skype = $_POST['Skype'];
        $website = $_POST['Website'];
        $message = $_POST['Message'];
        // bind the parameters
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':skype', $skype);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':message', $message);
        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(array('result' => 'success'));
        } else {
            echo json_encode(array('result' => 'fail'));
        }
    }
    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>