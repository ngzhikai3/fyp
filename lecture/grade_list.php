<?php
include '../check.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Grade List</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/button.css" rel="stylesheet" />
    <link href="../css/background.css" rel="stylesheet" />

</head>

<body>

    <div class="container-fluid px-0">
        <?php include 'lec_topnav.php'; ?>

        <div class="container-fluid row m-0 pt-5">
            <h1 class="text-center my-3">Grade List</h1>
            <?php
            include '../config/database.php';

            try {
                // select all data
                $lecture_id = $_SESSION["lecture_id"];
                $query = "SELECT * FROM student_course INNER JOIN lecture ON student_course.lecture_id = lecture.lecture_id INNER JOIN course ON course.course_id = student_course.course_id INNER JOIN student ON student_course.student_id = student.student_id WHERE student_course.lecture_id = :lecture_id";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':lecture_id', $lecture_id);
                $stmt->execute();

                // this is how to get number of rows returned
                $num = $stmt->rowCount();

                // check if more than 0 record found
                if ($num > 0) {
                    // Display table header
                    echo "<table class='table table-hover table-dark table-responsive table-striped table-hover table-bordered'>";
                    echo "<tr>";
                    echo "<th class='text-center col-2 fs-4'>Course ID</th>";
                    echo "<th class='text-center col-3 fs-4'>Course Name</th>";
                    echo "<th class='text-center col-2 fs-4'>Student Id</th>";
                    echo "<th class='text-center col-3 fs-3'>Student Name</th>";
                    echo "<th class='text-center col-2 fs-2'>Grade</th>";
                    echo "</tr>";

                    // Retrieve and display table contents
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // extract row
                        extract($row);
                        // creating new table row per record
                        echo "<tr>";
                        echo "<td class='col-2 text-center'>{$course_id}</td>";
                        echo "<td class='col-3 text-center text-break'>{$course_name}</td>";
                        echo "<td class='col-2 text-center text-break'>{$student_id}</td>";
                        echo "<td class='col-3 text-center text-break'>{$student_firstname} {$student_lastname}</td>";
                        if ($grade == NULL) {
                            echo "<td class='col-2 text-center text-break'>Still being assessed</td>";
                        } else {
                            echo "<td class='col-2 text-center text-break'>{$grade}</td>";
                        }
                        echo "</tr>";
                    }

                    // Close the table
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-danger'>No records found.</div>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); // Display the error message
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>