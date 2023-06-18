<?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $grade = $_POST['grade'];

    // Update the grade in the database
    try {
        $query = "UPDATE student_course SET grade = :grade WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();

        // Redirect back to the grading page
        header("Location: grade_list.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Display the error message
    }
}
?>
