<?php
include '../check.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Course</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/background.css" rel="stylesheet" />

</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'admin_topnav.php';
        ?>

        <div class="container my-3 py-2">
            <div class="page-header text-center">
                <h1>Create Course</h1>
            </div>

            <?php
            $course_name = "";

            if ($_POST) {
                // include database connection
                $course_name = $_POST['course_name'];
                $lecture_id = $_POST['lecture_id'];
                $error_message = "";

                if ($course_name == "") {
                    $error_message .= "<div class='alert alert-danger'>Course name cannot be empty</div>";
                }

                if ($lecture_id == "Select Lecture") {
                    $error_message .= "<div class='alert alert-danger'>Please select a lecture for this course</div>";
                }

                if (!empty($error_message)) {
                    echo "<div class='alert alert-danger'>{$error_message}</div>";
                } else {

                    include '../config/database.php';
                    try {
                        // insert query
                        $query = "INSERT INTO course SET course_name=:course_name, lecture_id=:lecture_id";
                        // prepare query for execution
                        $stmt = $con->prepare($query);
                        // bind the parameters
                        $stmt->bindParam(':course_name', $course_name);
                        $stmt->bindParam(':lecture_id', $lecture_id);
                        // Execute the query
                        if ($stmt->execute()) {
                            header("Location: course_read.php?update={save}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-dark table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="text-center col-3">Course Name</td>
                        <td><input type='text' name='course_name' value='<?php echo $course_name ?>' class='form-control' /></td>
                    </tr>

                    <?php
                    include '../config/database.php';
                    echo "  <tr> 
                        <td class='col-3 text-center'>Lecture</td>
                        <td class='col-9'>
                        <select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"lecture_id\">
                        <option value='Select Lecture' selected>Select Lecture</option>";
                    $query = "SELECT * FROM lecture ORDER BY lecture_id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $num = $stmt->rowCount();
                    if ($num > 0) {
                    } else {
                        echo "<div class='alert alert-danger'>No records found.</div>";
                    }
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value=\"$lecture_id\">$lecture_firstname $lecture_lastname</option>";
                    }
                    ?>

                    <tr>
                        <td></td>
                        <td colspan="3" class="text-end">
                            <button type='submit' class='btn btn-success'>
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href='course_read.php' class='btn btn-secondary'>Go to Course List <i class="fa-sharp fa-solid fa-circle-arrow-right"></i></a>
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