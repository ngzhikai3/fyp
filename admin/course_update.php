<?php
include '../check.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Update Course Name</title>

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
                <h1>Update Course Name</h1>
            </div>
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $course_id = isset($_GET['course_id']) ? $_GET['course_id'] : die('ERROR: Record ID not found.');

            $action = isset($_GET['action']) ? $_GET['action'] : "";
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }
            if ($action == 'nodeleted') {
                echo "<div class='alert alert-danger'>Cannot delete this course.</div>";
            }

            //include database connection
            include '../config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM course INNER JOIN lecture ON course.lecture_id = lecture.lecture_id  WHERE course.course_id = ? LIMIT 0,1";//INNER JOIN file ON course.course_id = file.course_id
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $course_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $course_name = $row['course_name'];
                $lecture_firstname = $row['lecture_firstname'];
                $lecture_lastname = $row['lecture_lastname'];
                //$file_name = $row['file_name'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted
            if ($_POST) {
                $course_name = $_POST['course_name'];
                $file_name = $row['file_name'];
                $error_message = "";

                if ($course_name == "") {
                    $error_message .= "<div class='alert alert-danger'>Please enter course name</div>";
                }

                if ($file_name) {

                    // upload to file to folder
                    $target_directory = "note";
                    $target_file = $target_directory . $file_name;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    // make sure certain file types are allowed
                    $allowed_file_types = array("docx", "pptx", "pdf");
                    if (!in_array($file_type, $allowed_file_types)) {
                        $error_message .= "<div class='alert alert-danger'>Only DOCX, PPTX, PDF files are allowed.</div>";
                    }
                    // make sure file does not exist
                    if (file_exists($target_file)) {
                        $error_message .= "<div class='alert alert-danger'>File already exists. Try to change file name.</div>";
                    }
                    // make sure submitted file is not too large, can't be larger than 1 MB
                    if ($_FILES['file_name']['size'] > (524288000)) {
                        $error_message .= "<div class='alert alert-danger'>Image must be less than 500 MB in size.</div>";
                    }
                    // make sure the 'note' folder exists
                    // if not, create it
                    if (!is_dir($target_directory)) {
                        mkdir($target_directory, 0777, true);
                    }
                    // if $file_upload_error_messages is still empty
                    if (empty($error_message)) {
                        // it means there are no errors, so try to upload the file
                        if (!move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {
                            $error_message .= "<div class='alert alert-danger>Unable to upload file.</div>";
                            $error_message .= "<div class='alert alert-danger>Update the record to upload file.</div>";
                        }
                    }
                }

                if (!empty($error_message)) {
                    echo $error_message;
                } else {

                    try {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE course SET course_name=:course_name WHERE course_id = :course_id";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $course_name = (strip_tags($_POST['course_name']));
                        // bind the parameters
                        $stmt->bindParam(':course_name', $course_name);
                        $stmt->bindParam(':course_id', $course_id);
                        // Execute the query
                        if ($stmt->execute()) {
                            header("Location: course_read.php?update={$course_id}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                        }
                    }
                    
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            } ?>
            

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?course_id={$course_id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-dark table-responsive table-bordered'>
                    <tr>
                        <td class="text-center">Course Name</td>
                        <td><input type='text' name='course_name' value="<?php echo htmlspecialchars($course_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <?php
                    include '../config/database.php';
                    echo "  <tr> 
                        <td class='col-3 text-center'>Lecture</td>
                        <td class='col-9'>
                        <select class=\"form-select form-select\" aria-label=\".form-select example\" name=\"lecture_id\">
                        <option value='Select Lecture' selected>$lecture_firstname $lecture_lastname</option>";
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
                            <a href='course_read.php' class='btn btn-secondary'><i class="fa-sharp fa-solid fa-circle-arrow-left"></i> Back to course list</a>
                            <?php echo "<a href='course_delete.php?course_id={$course_id}' class='btn btn-danger m-r-1em'><i class='fa-solid fa-trash'></i></a>"; ?>
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