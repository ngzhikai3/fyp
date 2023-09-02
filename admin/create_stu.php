<?php
include '../check.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Create Student</title>

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
            <?php
            if (isset($_GET['empty'])) {
                echo "<div class='alert alert-danger'>Please upload an Excel File.</div>";
            }
            if (isset($_GET['invalid_format'])) {
                echo "<div class='alert alert-danger'>The uploaded Excel file has an invalid format. Please upload a file with the correct format.</div>";
            }
            ?>
            <div class="page-header text-center">
                <h1>Create Student Profile</h1>
            </div>

            <!-- Excel file upload form -->
            <div class="col-md-12">
                <div class="">
                    <a href="javascript:void(0);" class="btn btn-primary mb-3 text-white" onclick="formToggle('importFrm');"><i class="fa-solid fa-file-circle-plus"></i></a>
                </div>
            </div>

            <div class="col" id="importFrm" style="display: none;">
                <form class="row g-3" action="import_StuData.php" method="post" enctype="multipart/form-data">
                    <div class="col-auto">
                        <label for="fileInput" class="visually-hidden">File</label>
                        <input type="file" class="form-control" name="file" id="fileInput" />
                    </div>
                    <div class="col-auto">
                        <input type="submit" class="btn btn-success mb-3" name="importSubmit" value="Upload">
                    </div>
                </form>
            </div>

            <?php
            $student_firstname = $student_lastname = $student_email = $student_phone = $student_gender = $date_of_birth = "";

            if ($_POST) {
                // include database connection
                $student_firstname = $_POST['student_firstname'];
                $student_lastname = $_POST['student_lastname'];
                $student_password = md5($_POST['student_password']);
                $confirm_student_password = md5($_POST['confirm_student_password']);
                $student_email = $_POST['student_email'];
                $student_phone = $_POST['student_phone'];
                $student_gender = $_POST['student_gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $error_message = "";

                if ($student_firstname == "" || $student_lastname == "" || $student_password == md5("") || $confirm_student_password == md5("") ||  $student_email == "" || $student_phone == "" || $student_gender == "" || $date_of_birth == "") {
                    $error_message .= "<div class='alert alert-danger'>Please make sure all fields are not empty</div>";
                }

                if (!preg_match('/[a-z]/', $student_password)) {
                    $error_message .= "<div class='alert alert-danger'>Password need include lowercase</div>";
                } elseif (!preg_match('/[0-9]/', $student_password)) {
                    $error_message .= "<div class='alert alert-danger'>Password need include number</div>";
                } elseif (strlen($student_password) < 8) {
                    $error_message .= "<div class='alert alert-danger'>Password need at least 8 charecter</div>";
                }

                if ($student_password != $confirm_student_password) {
                    $error_message .= "<div class='alert alert-danger'>Password need to same with confirm password</div>";
                }

                if ($date_of_birth != "") {
                    $day = $_POST['date_of_birth'];
                    $today = date("Ymd");
                    $date1 = date_create($day);
                    $date2 = date_create($today);
                    $diff = date_diff($date1, $date2);
                    if ($diff->format("%y") <= "18") {
                        $error_message .= "<div class='alert alert-danger'>User need 18 years old and above</div>";
                    }
                }

                if (!empty($error_message)) {
                    echo "<div class='alert alert-danger'>{$error_message}</div>";
                } else {

                    include '../config/database.php';
                    try {
                        // Insert into student table
                        $student_query = "INSERT INTO student SET student_firstname=:student_firstname, student_lastname=:student_lastname, student_password=:student_password, student_email=:student_email, student_phone=:student_phone, student_gender=:student_gender, date_of_birth=:date_of_birth, user_type=:user_type";
                        $student_stmt = $con->prepare($student_query);

                        // Bind the parameters for the student table
                        $student_stmt->bindParam(':student_firstname', $student_firstname);
                        $student_stmt->bindParam(':student_lastname', $student_lastname);
                        $student_stmt->bindParam(':student_password', $student_password);
                        $student_stmt->bindParam(':student_email', $student_email);
                        $student_stmt->bindParam(':student_phone', $student_phone);
                        $student_stmt->bindParam(':student_gender', $student_gender);
                        $student_stmt->bindParam(':date_of_birth', $date_of_birth);
                        $user_type = "student";
                        $student_stmt->bindParam(':user_type', $user_type);

                        // Execute the student query
                        $student_result = $student_stmt->execute();

                        // Get the last inserted ID from the student table
                        $student_id = $con->lastInsertId();

                        // Insert into login table
                        $login_query = "INSERT INTO login (email, password, role, student_id) VALUES (:student_email, :student_password, 'student', :student_id)";
                        $login_stmt = $con->prepare($login_query);

                        // Bind the parameters for the login table
                        $login_stmt->bindParam(':student_email', $student_email);
                        $login_stmt->bindParam(':student_password', $student_password);
                        $login_stmt->bindParam(':student_id', $student_id);

                        // Execute the login query
                        $login_result = $login_stmt->execute();

                        // Check if both queries executed successfully
                        if ($student_result && $login_result) {
                            header("Location: student_read.php?update={save}");
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                    } catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }

                    // show error
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            }
            ?>

            <!-- html form here where the product information will be entered -->
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <table class='table table-dark table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="text-center col-3">First Name</td>
                        <td><input type='text' name='student_firstname' value='<?php echo $student_firstname ?>' class='form-control' /></td>
                        <td class="text-center col-3">Last Name</td>
                        <td><input type='text' name='student_lastname' value='<?php echo $student_lastname ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center col-3">Password</td>
                        <td><input type='password' name='student_password' class='form-control' /></td>
                        <td class="text-center col-3">Confirm Password</td>
                        <td><input type='password' name='confirm_student_password' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center col-3">Email</td>
                        <td><input type='email' name='student_email' value='<?php echo $student_email ?>' class='form-control' /></td>
                        <td class="text-center col-3">Phone number</td>
                        <td><input type='tel' name='student_phone' value='<?php echo $student_phone ?>' class='form-control' pattern="[0-9]{3}-[0-9]{7-8}" /></td>
                    </tr>
                    <tr>
                        <td class="text-center col-3">Gender</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="student_gender" value="male" checked>
                                <label class="form-check-label">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="student_gender" value="female">
                                <label class="form-check-label">
                                    Female
                                </label>
                            </div>
                        </td>
                        <td class="text-center col-3">Date Of Birth</td>
                        <td><input type='date' name='date_of_birth' value='<?php echo $date_of_birth ?>' class='form-control' /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" class="text-end">
                            <button type='submit' class='btn btn-success'>
                                <i class="fa-solid fa-floppy-disk"></i>
                            </button>
                            <a href='student_read.php' class='btn btn-secondary'>Go to Student List <i class="fa-sharp fa-solid fa-circle-arrow-right"></i></a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- end .container -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        function formToggle(ID) {
            var element = document.getElementById(ID);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }
    </script>

</body>

</html>