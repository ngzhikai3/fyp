<?php
include '../check.php';
?>

<!DOCTYPE HTML>
<html>

<head>

    <title>Course</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/background.css" rel="stylesheet" />
    
</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'stu_topnav.php';
        ?>

        <div class="container my-3">
            <div class="page-header">
                <h1>Course</h1>
            </div>

            <?php
            include '../config/database.php';

            // Check if the student is logged in
            if (isset($_SESSION['student_id'])) {
                // Get the student ID from the session
                $student_id = $_SESSION['student_id'];

                // Check if the course_id is provided in the URL
                if (isset($_GET['course_id'])) {
                    // Get the course ID from the URL
                    $course_id = $_GET['course_id'];

                    // Prepare the SELECT statement to retrieve the lecture_id from the course table
                    $stmt = $con->prepare("SELECT lecture_id FROM course WHERE course_id = :course_id");

                    // Bind the parameter
                    $stmt->bindParam(':course_id', $course_id);

                    // Execute the SELECT statement
                    if ($stmt->execute()) {
                        // Fetch the lecture_id from the result
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($result) {
                            $lecture_id = $result['lecture_id'];

                            // Check if the student is already enrolled in the course
                            $enrollmentCheckStmt = $con->prepare("SELECT * FROM student_course WHERE student_id = :student_id AND course_id = :course_id");
                            $enrollmentCheckStmt->bindParam(':student_id', $student_id);
                            $enrollmentCheckStmt->bindParam(':course_id', $course_id);
                            $enrollmentCheckStmt->execute();

                            if ($enrollmentCheckStmt->rowCount() > 0) {
                                // Student is already enrolled in the course
                                echo "<div class='alert alert-info'>You are already enrolled in this course.</div>";
                            } else {
                                // Student is not enrolled in the course, proceed with enrollment

                                // Check if the form is submitted
                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_course'])) {
                                    // Prepare the INSERT statement to enroll the student in the course
                                    $enrollmentStmt = $con->prepare("INSERT INTO student_course (student_id, course_id, lecture_id) VALUES (:student_id, :course_id, :lecture_id)");

                                    // Bind the parameters
                                    $enrollmentStmt->bindParam(':student_id', $student_id);
                                    $enrollmentStmt->bindParam(':course_id', $course_id);
                                    $enrollmentStmt->bindParam(':lecture_id', $lecture_id);

                                    // Execute the INSERT statement
                                    if ($enrollmentStmt->execute()) {
                                        // Enrollment successful
                                        header("Location: index.php?enrollment={$student_id}");
                                    } else {
                                        // Enrollment failed
                                        echo "<div class='alert alert-danger'>Failed to enroll in the course. Please try again.</div>";
                                    }
                                }
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Course not found.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Failed to retrieve course details. Please try again.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Course ID not provided.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>You must be logged in as a student to access this page.</div>";
            }

            ?>

            <!-- Enrollment Form -->
            <form method="POST" action="">
                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->
                <table class='table table-hover table-dark table-responsive table-bordered'>
                    <tr>
                        <td class="text-center col-4 fs-5">Course Name</td>
                        <td class="text-center col-4 fs-5">Lecture Name</td>
                        <td class="text-center col-4 fs-5">Action</td>
                    </tr>
                    <tr>
                        <td class="text-center col-4"><?php
                                                        $query = "SELECT * FROM course INNER JOIN lecture ON course.lecture_id = lecture.lecture_id WHERE course_id = ? ";
                                                        $stmt = $con->prepare($query);
                                                        $stmt->bindParam(1, $course_id);
                                                        $stmt->execute();
                                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                        $course_name = $row['course_name'];
                                                        $course_id = $row['course_id'];
                                                        $lecture_id = $row['lecture_id'];
                                                        $lecture_firstname = $row['lecture_firstname'];
                                                        $lecture_lastname = $row['lecture_lastname'];
                                                        echo htmlspecialchars($course_name, ENT_QUOTES);  ?>
                        </td>
                        <td class="text-center col-4"> <?php echo $lecture_firstname . " " . $lecture_lastname ?></td>
                        <td class="text-end">
                            <?php if ($enrollmentCheckStmt->rowCount() === 0) { ?>
                                <button type='submit' name="join_course" class='btn btn-success'>
                                    <i class='fa-sharp fa-solid fa-right-to-bracket' style='color: #ffffff;'></i> Join Course
                                </button>
                            <?php } ?>
                            <a href='index.php' class='btn btn-secondary'><i class="fa-sharp fa-solid fa-circle-arrow-left"></i> Back to Home Page</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>