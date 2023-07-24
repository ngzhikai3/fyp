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

        <?php include 'lec_topnav.php'; ?>

        <div class="container my-3 py-2">
            <div class="page-header text-center">
                <h1>Create Course</h1>
            </div>

            <?php
            $course_name = "";

            if ($_POST) {
                // include database connection
                $course_name = $_POST['course_name'];
                $lecture_id = $_SESSION["lecture_id"];
                $error_message = "";

                if ($course_name == "") {
                    $error_message .= "<div class='alert alert-danger'>Course name cannot be empty</div>";
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
                            header("Location: index.php?update={save}");
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
                    <tr>
                        <td class="text-center col-3">Lecture Name</td>
                        <?php
                        include '../config/database.php';
                        $lecture_id = $_SESSION["lecture_id"];
                        $query = "SELECT lecture_id, lecture_firstname, lecture_lastname FROM lecture WHERE lecture_id = :lecture_id";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(":lecture_id", $lecture_id);
                        $stmt->execute();
                        $lecture = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($stmt->rowCount() > 0) {
                            $lecture_firstname = $lecture['lecture_firstname'];
                            $lecture_lastname = $lecture['lecture_lastname'];
                            echo "<td>$lecture_firstname $lecture_lastname</td>";
                        } else {
                            echo "<td>Lecture not found</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="text-end">
                            <button type='submit' class='btn btn-success'>
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
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