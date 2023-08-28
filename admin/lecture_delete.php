<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // Get record ID
    $lecture_id = isset($_GET['lecture_id']) ? $_GET['lecture_id'] :  die('ERROR: Record ID not found.');

    // Delete from lecture table
    $lecture_query = "DELETE FROM lecture WHERE lecture_id = ?";
    $lecture_stmt = $con->prepare($lecture_query);
    $lecture_stmt->bindParam(1, $lecture_id);

    // Delete from login table
    $login_query = "DELETE FROM login WHERE lecture_id = ?";
    $login_stmt = $con->prepare($login_query);
    $login_stmt->bindParam(1, $lecture_id);

    // Perform both delete operations
    $con->beginTransaction();

    if ($lecture_stmt->execute() && $login_stmt->execute()) {
        $con->commit();
        header('Location: lecture_read.php?action=deleted');
    } else {
        $con->rollback();
        die('Unable to delete record.');
    }
}

// Show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>
