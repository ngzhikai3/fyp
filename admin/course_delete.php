<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $course_id = isset($_GET['course_id']) ? $_GET['course_id'] :  die('ERROR: Record ID not found.');

    $query = "DELETE FROM course WHERE course_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $course_id);
    if ($stmt->execute()) {
        header('Location: course_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
