<?php
include '../check.php';
?>

<!DOCTYPE HTML>
<html>

<head>

    <title>Read Student Info</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/background.css" rel="stylesheet" />

</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'admin_topnav.php'; ?>

        <div class="container my-3">
            <div class="page-header">
                <h1 class="text-center">Read Student Profile</h1>
            </div>

            <!-- PHP read one record will be here -->
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die('ERROR: Record Customer not found.');

            $action = isset($_GET['action']) ? $_GET['action'] : "";
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }
            if ($action == 'nodeleted') {
                echo "<div class='alert alert-danger'>This customer had order placed so cannot be delete.</div>";
            }

            //include database connection
            include '../config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM student WHERE student_id = :student_id ";
                $stmt = $con->prepare($query);

                // Bind the parameter
                $stmt->bindParam(":student_id", $student_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $student_firstname = $row['student_firstname'];
                $student_lastname = $row['student_lastname'];
                $student_email = $row['student_email'];
                $student_phone = $row['student_phone'];
                $student_gender = $row['student_gender'];
                $date_of_birth = $row['date_of_birth'];
                // shorter way to do that is extract($row)
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <!-- HTML read one record table will be here -->
            <!--we have our html table here where the record will be displayed-->
            <table class='table table-hover table-dark table-responsive table-bordered'>
                <tr>
                    <td class="text-center col-3">First Name</td>
                    <td class="text-center col-3"><?php echo htmlspecialchars($student_firstname, ENT_QUOTES);  ?></td>
                    <td class="text-center col-3">Last Name</td>
                    <td class="text-center col-3"><?php echo htmlspecialchars($student_lastname, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td class="text-center col-3">Email</td>
                    <td class="text-center col-3"><?php echo htmlspecialchars($student_email, ENT_QUOTES);  ?></td>
                    <td class="text-center col-3">Phone</td>
                    <td class="text-center col-3"><?php echo htmlspecialchars($student_phone, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td class="text-center col-3">Gender</td>
                    <td class="text-center col-3"><?php if ($student_gender == "male") {
                            echo "<i class='fa-solid fa-person fs-1 text-primary ms-3'></i>";
                        } else {
                            echo "<i class='fa-solid fa-person-dress fs-1 text-danger ms-3'></i>";
                        } ?></td>
                    <td class="text-center col-3">Date of Birth</td>
                    <td class="text-center col-3"><?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end" colspan="3">
                        <?php echo "<a href='student_update.php?student_id={$student_id}' class='btn btn-primary m-r-1em'><i class='fa-solid fa-pen-to-square'></i></a>"; ?>
                        <a href='student_read.php' class='btn btn-secondary'><i class="fa-sharp fa-solid fa-circle-arrow-left"></i> Back to Student Profile</a>
                        <?php echo "<a href='student_delete.php?student_id={$student_id}' class='btn btn-danger'><i class='fa-solid fa-trash'></i></a>"; ?>
                    </td>
                </tr>
            </table>

            <div>
                <h1 class="text-center my-3">Student's Results</h1>
                <?php
                try {
                    // select all data
                    $query = "SELECT * FROM course INNER JOIN lecture ON course.lecture_id = lecture.lecture_id INNER JOIN student_course ON course.course_id = student_course.course_id INNER JOIN student ON student_course.student_id = student.student_id WHERE student_course.student_id = :student_id";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':student_id', $student_id);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    // check if more than 0 record found
                    if ($num > 0) {
                        // Display table header
                        echo "<table class='table table-hover table-dark table-responsive table-striped table-hover table-bordered'>";
                        echo "<tr>";
                        echo "<th class='text-center col-2 fs-4'>Course ID</th>";
                        echo "<th class='text-center col-4 fs-4'>Course Name</th>";
                        echo "<th class='text-center col-4 fs-4'>Lecture Name</th>";
                        echo "<th class='text-center col-2 fs-4'>Grade</th>";
                        echo "</tr>";

                        // Retrieve and display table contents
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // extract row
                            extract($row);
                            // creating new table row per record
                            echo "<tr>";
                            echo "<td class='col-2 text-center'>{$course_id}</td>";
                            echo "<td class='col-4 text-center text-break'>{$course_name}</td>";
                            echo "<td class='col-4 text-center text-break'>{$lecture_firstname} {$lecture_lastname}</td>";
                            if ($grade == NULL) {
                                echo "<td class='col-4 text-center text-break'>Coming Soon</td>";
                            } else {
                                echo "<td class='col-4 text-center text-break'>{$grade}</td>";
                            }
                            echo "</tr>";
                        }

                        // Close the table
                        echo "</table>";
                    } else {
                        echo "<div class='alert alert-danger'>The student has not enrolled in any courses.</div>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage(); // Display the error message
                }
                ?>
            </div>
        </div>
        <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    
</body>

</html>