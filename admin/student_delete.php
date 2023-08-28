<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] :  die('ERROR: Record ID not found.');

    // Delete from student table
    $student_query = "DELETE FROM student WHERE student_id = ?";
    $student_stmt = $con->prepare($student_query);
    $student_stmt->bindParam(1, $student_id);
    
     // Delete from login table
     $login_query = "DELETE FROM login WHERE student_id = ?";
     $login_stmt = $con->prepare($login_query);
     $login_stmt->bindParam(1, $student_id);
 
     // Perform both delete operations
     $con->beginTransaction();
 
     if ($student_stmt->execute() && $login_stmt->execute()) {
         $con->commit();
         header('Location: student_read.php?action=deleted');
     } else {
         $con->rollback();
         die('Unable to delete record.');
     }
 }

// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
