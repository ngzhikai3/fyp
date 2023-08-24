<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $lecture_id = isset($_GET['lecture_id']) ? $_GET['lecture_id'] :  die('ERROR: Record ID not found.');

    $query = "DELETE FROM lecture WHERE lecture_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $lecture_id);
    if ($stmt->execute()) {
        header('Location: lecture_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
