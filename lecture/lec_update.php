<?php
include '../check.php';
?>

<!DOCTYPE html>

<html>

<head>

    <title>Update Profile</title>

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

        <div class="container my-3">
            <div class="page-header">
                <h1>Update Profile</h1>
            </div>
            <?php
            // get passed parameter value, in this case, the record ID
            // isset() is a PHP function used to verify if a value is there or not
            $lecture_id = isset($_GET['lecture_id']) ? $_GET['lecture_id'] : die('ERROR: Record ID not found.');

            $action = isset($_GET['action']) ? $_GET['action'] : "";
            if ($action == 'deleted') {
                echo "<div class='alert alert-success'>Record was deleted.</div>";
            }
            if ($action == 'nodeleted') {
                echo "<div class='alert alert-danger'>Cannot delete this lecture.</div>";
            }

            //include database connection
            include '../config/database.php';

            // read current record's data
            try {
                // prepare select query
                $query = "SELECT * FROM lecture WHERE lecture_id = ? LIMIT 0,1";
                $stmt = $con->prepare($query);

                // this is the first question mark
                $stmt->bindParam(1, $lecture_id);

                // execute our query
                $stmt->execute();

                // store retrieved row to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // values to fill up our form
                $lecture_firstname = $row['lecture_firstname'];
                $lecture_lastname = $row['lecture_lastname'];
                $lecture_password = $row['lecture_password'];
                $lecture_email = $row['lecture_email'];
                $lecture_phone = $row['lecture_phone'];
                $lecture_gender = $row['lecture_gender'];
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
            // check if form was submitted
            if ($_POST) {

                $lecture_password = ($_POST['lecture_password']);
                $old_lecture_password = md5($_POST['old_lecture_password']);
                $confirm_lecture_password = ($_POST['confirm_lecture_password']);
                $lecture_firstname = $_POST['lecture_firstname'];
                $lecture_lastname = $_POST['lecture_lastname'];
                $lecture_email = $_POST['lecture_email'];
                $lecture_phone = $_POST['lecture_phone'];
                $lecture_gender = $_POST['lecture_gender'];
                $error_message = "";

                $emptypass = false;
                if ($old_lecture_password == md5("") && $lecture_password == "" && $confirm_lecture_password == "") {
                    $emptypass = true;
                } else {
                    if ($row['lecture_password'] == $old_lecture_password) {
                        if (!preg_match('/[a-z]/', $lecture_password)) {
                            $error_message .= "<div class='alert alert-danger'>Password need include lowercase</div>";
                        } elseif (!preg_match('/[0-9]/', $lecture_password)) {
                            $error_message .= "<div class='alert alert-danger'>Password need include number</div>";
                        } elseif (strlen($lecture_password) < 8) {
                            $error_message .= "<div class='alert alert-danger'>Password need at least 8 charecter</div>";
                        } elseif ($old_lecture_password == $lecture_password) {
                            $error_message .= "<div class='alert alert-danger'>New password cannot same with old password</div>";
                        } elseif ($old_lecture_password != "" && $lecture_password != "" && $confirm_lecture_password == "") {
                            $error_message .= "<div class='alert alert-danger'>Please enter confirm password</div>";
                        } elseif ($old_lecture_password != "" && $lecture_password != "" && $confirm_lecture_password != "" && $lecture_password != $confirm_lecture_password) {
                            $error_message .= "<div class='alert alert-danger'>confirm password need to same with password</div>";
                        }
                    } else {
                        $error_message .= "<div class='alert alert-danger'>Password incorrect</div>";
                    }
                }
                if ($emptypass == true) {
                    $lecture_password = $row['lecture_password'];
                } else {
                    $lecture_password = md5(strip_tags($_POST['lecture_password']));
                }

                if ($lecture_firstname == "") {
                    $error_message .= "<div class='alert alert-danger'>Please enter your first name</div>";
                }

                if ($lecture_lastname == "") {
                    $error_message .= "<div class='alert alert-danger'>Please enter your last name</div>";
                }

                if ($lecture_gender == "") {
                    $error_message .= "<div class='alert alert-danger'>Please select your gender</div>";
                }

                if (!empty($error_message)) {
                    echo $error_message;
                } else {

                    try {
                        // write update query
                        // in this case, it seemed like we have so many fields to pass and
                        // it is better to label them and not use question marks
                        $query = "UPDATE lecture SET lecture_firstname=:lecture_firstname, lecture_lastname=:lecture_lastname, lecture_password=:lecture_password, lecture_email=:lecture_email, lecture_phone=:lecture_phone, lecture_gender=:lecture_gender WHERE lecture_id = :lecture_id";
                        // prepare query for excecution
                        $stmt = $con->prepare($query);
                        // posted values
                        $lecture_firstname = (strip_tags($_POST['lecture_firstname']));
                        $lecture_lastname = (strip_tags($_POST['lecture_lastname']));
                        $lecture_email = (strip_tags($_POST['lecture_email']));
                        $lecture_phone = (strip_tags($_POST['lecture_phone']));
                        $lecture_gender = (strip_tags($_POST['lecture_gender']));
                        // bind the parameters
                        $stmt->bindParam(':lecture_firstname', $lecture_firstname);
                        $stmt->bindParam(':lecture_lastname', $lecture_lastname);
                        $stmt->bindParam(':lecture_password', $lecture_password);
                        $stmt->bindParam(':lecture_email', $lecture_email);
                        $stmt->bindParam(':lecture_phone', $lecture_phone);
                        $stmt->bindParam(':lecture_gender', $lecture_gender);
                        $stmt->bindParam(':lecture_id', $lecture_id);
                        // Execute the query
                        if ($stmt->execute()) {
                            $query = "UPDATE login 
                                      SET email = :lecture_email, password = :lecture_password 
                                      WHERE lecture_id = :lecture_id";

                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':lecture_email', $lecture_email);
                            $stmt->bindParam(':lecture_password', $lecture_password);
                            $stmt->bindParam(':lecture_id', $lecture_id);

                            if ($stmt->execute()) {
                                header("Location: lec_profile.php?lecture_id={$lecture_id}");
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Unable to update lecture record. Please try again.</div>";
                        }
                    }
                    // show errors
                    catch (PDOException $exception) {
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
            } ?>

            <!--we have our html form here where new record information can be updated-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?lecture_id={$lecture_id}"); ?>" method="post" enctype="multipart/form-data">
                <table class='table table-hover table-dark table-responsive table-bordered'>
                    <tr>
                        <td class="text-center">Old Password</td>
                        <td colspan="3"><input type='password' name='old_lecture_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                    </tr>
                    <tr>
                        <td class="text-center">New Password</td>
                        <td><input type='password' name='lecture_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                        <td class="text-center">Confirm Password</td>
                        <td><input type='password' name='confirm_lecture_password' class='form-control' placeholder="Leave blank if no password has been changed" /></td>
                    </tr>
                    <tr>
                        <td class="text-center">First Name</td>
                        <td><input type='text' name='lecture_firstname' value="<?php echo htmlspecialchars($lecture_firstname, ENT_QUOTES);  ?>" class='form-control' /></td>
                        <td class="text-center">Last Name</td>
                        <td><input type='text' name='lecture_lastname' value="<?php echo htmlspecialchars($lecture_lastname, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center">email</td>
                        <td><input type='text' name='lecture_email' value="<?php echo htmlspecialchars($lecture_email, ENT_QUOTES);  ?>" class='form-control' /></td>
                        <td class="text-center">Phone</td>
                        <td><input type='text' name='lecture_phone' value="<?php echo htmlspecialchars($lecture_phone, ENT_QUOTES);  ?>" class='form-control' /></td>
                    </tr>
                    <tr>
                        <td class="text-center">Gender</td>
                        <td>
                            <?php
                            if ($lecture_gender == "male") {
                                echo "<div class='form-check'>
                                    <input class='form-check-input' type='radio' name='lecture_gender' value='male' checked>
                                    <label class='form-check-label'>
                                    Male
                                    </label>
                                </div>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='lecture_gender' value='female'>
                                    <label class='form-check-label'>
                                    Female
                                    </label>
                                </div>";
                            } else {
                                echo "<div class='form-check'>
                                        <input class='form-check-input' type='radio' name='lecture_gender' value='male'>
                                        <label class='form-check-label'>
                                            Male
                                        </label>
                                    </div>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='radio' name='lecture_gender' value='female' checked>
                                        <label class='form-check-label'>
                                            Female
                                        </label>
                                    </div>";
                            }
                            ?>
                        </td>
                        <td colspan="2" class="text-end">
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