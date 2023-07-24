<?php
include '../check.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Update Student Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="images/icon.png" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="../css/background.css" rel="stylesheet" />
    
</head>

<body>

    <div class="container-fluid px-0">

        <?php include 'stu_topnav.php'; ?>

        <div class="container my-3">
            <div class="page-header">
                <h1>Update Student Profile</h1>
            </div>
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : die('ERROR: Record ID not found.');

            $action = isset($_GET['action']) ? $_GET['action'] : "";
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }
            if ($action == 'nodeleted') {
                echo "<div class='alert alert-danger'>Cannot delete this student.</div>";
            }

            //include database connection
            include '../config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM student WHERE student_id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $student_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $student_firstname = $row['student_firstname'];
                $student_lastname = $row['student_lastname'];
                $student_password = $row['student_password'];
                $student_email = $row['student_email'];
                $student_phone = $row['student_phone'];
                $student_gender = $row['student_gender'];
                $date_of_birth = $row['date_of_birth'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted
            if ($_POST) {

                $student_password = ($_POST['student_password']);
                $old_student_password = md5($_POST['old_student_password']);
                $confirm_student_password = ($_POST['confirm_student_password']);
                $student_firstname = $_POST['student_firstname'];
                $student_lastname = $_POST['student_lastname'];
                $student_email = $_POST['student_email'];
                $student_phone = $_POST['student_phone'];
                $student_gender = $_POST['student_gender'];
                $date_of_birth = $_POST['date_of_birth'];
                $error_message = "";

                $emptypass = false;
                if ($old_student_password == md5("") && $student_password == "" && $confirm_student_password == "") {
                    $emptypass = true;
                } else {
                    if ($row['student_password'] == $old_student_password) {
                        if (!preg_match('/[a-z]/', $student_password)) {
                            $error_message .= "<div class='alert alert-danger'>Password need include lowercase</div>";
                        } elseif (!preg_match('/[0-9]/', $student_password)) {
                            $error_message .= "<div class='alert alert-danger'>Password need include number</div>";
                        } elseif (strlen($student_password) < 8) {
                            $error_message .= "<div class='alert alert-danger'>Password need at least 8 charecter</div>";
                        } elseif ($old_student_password == $student_password) {
                            $error_message .= "<div class='alert alert-danger'>New password cannot same with old password</div>";
                        } elseif ($old_student_password != "" && $student_password != "" && $confirm_student_password == "") {
                            $error_message .= "<div class='alert alert-danger'>Please enter confirm password</div>";
                        } elseif ($old_student_password != "" && $student_password != "" && $confirm_student_password != "" && $student_password != $confirm_student_password) {
                            $error_message .= "<div class='alert alert-danger'>confirm password need to same with password</div>";
                        }
                    } else {
                        $error_message .= "<div class='alert alert-danger'>Password incorrect</div>";
                    }
                }
                if ($emptypass == true) {
                    $student_password = $row['student_password'];
                } else {
                    $student_password = md5(strip_tags($_POST['student_password']));
                }

                if ($student_firstname == "") {
                    $error_message .= "<div class='alert alert-danger'>Please enter your first name</div>";
                }

                if ($student_lastname == "") {
                    $error_message .= "<div class='alert alert-danger'>Please enter your last name</div>";
                }

                if ($student_gender == "") {
                    $error_message .= "<div class='alert alert-danger'>Please select your gender</div>";
                }

                if ($date_of_birth == "") {
                    $error_message .= "<div class='alert alert-danger'>Please select your date of birth</div>";
                }

                $day = $_POST['date_of_birth'];
                $today = date("Ymd");
                $date1 = date_create($day);
                $date2 = date_create($today);
                $diff = date_diff($date1, $date2);
                if ($diff->format("%y") <= "18") {
                    $error_message .= "<div class='alert alert-danger'>User need 18 years old and above</div>";
                }

                if (!empty($error_message)) {
                    echo $error_message;
                } else {

                    try {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE student SET student_firstname=:student_firstname, student_lastname=:student_lastname, student_password=:student_password, student_email=:student_email, student_phone=:student_phone, student_gender=:student_gender, date_of_birth=:date_of_birth WHERE student_id = :student_id";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $student_firstname = (strip_tags($_POST['student_firstname']));
                        $student_lastname = (strip_tags($_POST['student_lastname']));
                        $student_email = (strip_tags($_POST['student_email']));
                        $student_phone = (strip_tags($_POST['student_phone']));
                        $student_gender = (strip_tags($_POST['student_gender']));
                        $date_of_birth = (strip_tags($_POST['date_of_birth']));
                        // bind the parameters
                        $stmt->bindParam(':student_firstname', $student_firstname);
                        $stmt->bindParam(':student_lastname', $student_lastname);
                        $stmt->bindParam(':student_password', $student_password);
                        $stmt->bindParam(':student_email', $student_email);
                        $stmt->bindParam(':student_phone', $student_phone);
                        $stmt->bindParam(':student_gender', $student_gender);
                        $stmt->bindParam(':date_of_birth', $date_of_birth);
                        $stmt->bindParam(':student_id', $student_id);
                        // Execute the query
                        if ($stmt->execute()) {
                            $query = "UPDATE login 
                                      SET email = :student_email, password = :student_password 
                                      WHERE student_id = :student_id";

                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':student_email', $student_email);
                            $stmt->bindParam(':student_password', $student_password);
                            $stmt->bindParam(':student_id', $student_id);

                            if ($stmt->execute()) {
                                header("Location: stu_profile.php?student_id={$student_id}");
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update your profile. Please try again.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update your profile. Please try again.</div>";
                        }
                    }
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            } ?>

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?student_id={$student_id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-dark table-responsive table-bordered'>
                    <tr>
                        <td class="text-center">Old Password</td>
                        <td colspan="3"><input type='password' name='old_student_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                    </tr>
                    <tr>
                        <td class="text-center">New Password</td>
                        <td><input type='password' name='student_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                        <td class="text-center">Confirm Password</td>
                        <td><input type='password' name='confirm_student_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                    </tr>
                    <tr>
                        <td class="text-center">First Name</td>
                        <td><input type='text' name='student_firstname' value="<?php echo htmlspecialchars($student_firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                        <td class="text-center">Last Name</td>
                        <td><input type='text' name='student_lastname' value="<?php echo htmlspecialchars($student_lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center">Gender</td>
                        <td>
                            <?php
                            if ($student_gender == "male") {
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='student_gender' value='male' checked>
                                    <label class='form-check-label'>
                                    Male
                                    </label>
                                </div>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='student_gender' value='female'>
                                    <label class='form-check-label'>
                                    Female
                                    </label>
                                </div>";
                            } else {
                                echo "<div class='form-check'>
                                        <input class='form-check-input' type='radio' name='student_gender' value='male'>
                                        <label class='form-check-label'>
                                            Male
                                        </label>
                                    </div>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='student_gender' value='female' checked>
                                        <label class='form-check-label'>
                                            Female
                                        </label>
                                    </div>";
                            }
                            ?>
                        </td>
                        <td class="text-center">Date Of Birth</td>
                        <td><input type='date' name='date_of_birth' value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center">Email</td>
                        <td><input type='text' name='student_email' value="<?php echo htmlspecialchars($student_email, ENT_QUOTES);  ?>" class='form-control' readonly/></td>
                        <td class="text-center">Phone</td>
                        <td><input type='text' name='student_phone' value="<?php echo htmlspecialchars($student_phone, ENT_QUOTES);  ?>" class='form-control' /></td>
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