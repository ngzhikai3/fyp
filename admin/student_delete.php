<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] :  die('ERROR: Record ID not found.');

    $query = "DELETE FROM student WHERE student_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $student_id);
    if ($stmt->execute()) {
        header('Location: student_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
