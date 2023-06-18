<?php
session_start();
// include database connection
include '../config/database.php';

try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $lecture_id = isset($_GET['lecture_id']) ? $_GET['lecture_id'] :  die('ERROR: Record ID not found.');

    /*$select = "SELECT *, COUNT(*) AS order_count, customers.username AS user_name FROM customers INNER JOIN order_summary ON customers.username = order_summary.username WHERE customers.lecture_id=:lecture_id";
    $stmt = $con->prepare($select);
    $stmt->bindParam(":lecture_id", $lecture_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $order_count = $row['order_count'];
    $user_name = $row['user_name'];

    if ($_SESSION["login"] == $user_name) {
        header('Location: customer_read.php?action=self');
    } else {
        if ($order_count > 0) {
            header('Location: customer_read.php?action=nodeleted');
        } else {*/
            $query = "DELETE FROM lecture WHERE lecture_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $lecture_id);
            if ($stmt->execute()) {
                header('Location: lecture_read.php?action=deleted');
            } else {
                die('Unable to delete record.');
            }
        }/*
    }
}*/
// show error
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
